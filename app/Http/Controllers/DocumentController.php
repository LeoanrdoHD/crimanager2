<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Options;
use App\Models\Criminal;

class DocumentController extends Controller
{
    private string $secretKey;
    private string $algorithm = 'sha256';

    public function __construct()
    {
        $this->secretKey = config('app.pdf_signature_key', 'your-secret-key-here');
    }

    /**
     * ⚡ GENERAR PDF RÁPIDO
     */
    public function generateFastPDF($criminal_id)
    {
        return $this->generateSecurePDF(
            $criminal_id, 
            'exportar.pdf_rapido', 
            'rapido', 
            'perfil_delincuente'
        );
    }

    /**
     * 📋 GENERAR PDF COMPLETO
     */
    public function generateCompletePDF($criminal_id)
    {
        return $this->generateSecurePDF(
            $criminal_id, 
            'exportar.pdf_todo', 
            'completo', 
            'Todo_delincuente'
        );
    }

    /**
     * 🔧 MÉTODO BASE - Generar PDFs con firma digital
     */
    private function generateSecurePDF($criminal_id, $viewName, $documentType, $filenamePrefix)
    {
        try {
            $options = new Options();
            $options->set('isRemoteEnabled', true);

            $criminal = Criminal::with([
                'civilState', 'country', 'state', 'city', 'nationality', 'occupation',
                'photographs', 'arrestHistories', 'criminalAddresses.country',
                'criminalAddresses.state', 'criminalAddresses.city',
                'physicalCharacteristics.earType', 'physicalCharacteristics.eyeType',
                'physicalCharacteristics.lipType', 'physicalCharacteristics.noseType',
                'physicalCharacteristics.skinColor', 'physicalCharacteristics.Confleccion',
                'physicalCharacteristics.criminalGender', 'criminalPartner.relationshipType'
            ])->findOrFail($criminal_id);

            // Verificar si necesita desactivar PDFs anteriores
            $shouldDeactivateOldPDFs = $this->checkIfNeedToDeactivateOldPDFs($criminal_id);

            // Generar firma digital
            $timestamp = Carbon::now('America/La_Paz')->format('Y-m-d H:i:s');
            $user = Auth::user()->name ?? 'Sistema';
            $digitalSignature = $this->generateDocumentSignature($criminal, $timestamp, $user);
            
            // Generar QR híbrido compacto
            $qrData = $this->generateSecureQRData($criminal, $digitalSignature, true);
            $qrCodeBase64 = $this->generateSimpleQR($qrData);
            $generationInfo = $this->getGenerationInfo();

            $generationInfo['signature_hash'] = substr($digitalSignature['signature'], 0, 16);
            $generationInfo['document_id'] = 'DOC-' . strtoupper($documentType) . '-' . str_pad($criminal->id, 6, '0', STR_PAD_LEFT) . '-' . date('YmdHis');
            $generationInfo['document_type'] = ucfirst($documentType);

            // Generar PDF
            $pdf = PDF::loadView($viewName, compact('criminal', 'qrCodeBase64', 'generationInfo'));
            $pdf->setPaper('letter', 'portrait');

            // Desactivar PDFs anteriores si es necesario
            if ($shouldDeactivateOldPDFs) {
                $this->deactivateOldDocuments($criminal_id);
                Log::info("PDFs anteriores desactivados para criminal_id: {$criminal_id}");
            }

            // Registrar documento
            $this->logDocumentGeneration($criminal->id, $digitalSignature, $generationInfo['document_id'], $documentType);

            $filename = $filenamePrefix . '_' . $criminal->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error generando PDF: ' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'Error al generar documento'], 500);
        }
    }

    /**
     * 🔍 Verificar si necesita desactivar PDFs anteriores
     */
    private function checkIfNeedToDeactivateOldPDFs($criminal_id): bool
    {
        try {
            $lastPDF = DB::table('document_generations')
                ->where('criminal_id', $criminal_id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$lastPDF) {
                return false;
            }

            $recentArrest = DB::table('arrest_and_apprehension_histories')
                ->where('criminal_id', $criminal_id)
                ->where('created_at', '>', $lastPDF->created_at)
                ->exists();

            return $recentArrest;

        } catch (\Exception $e) {
            Log::error('Error verificando necesidad de desactivar PDFs: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 🔄 Desactivar documentos anteriores
     */
    private function deactivateOldDocuments($criminal_id)
    {
        try {
            DB::table('document_generations')
                ->where('criminal_id', $criminal_id)
                ->where('status', 'active')
                ->update([
                    'status' => 'inactive',
                    'deactivated_at' => now(),
                    'deactivated_by' => Auth::id(),
                    'deactivation_reason' => 'Nuevo arresto registrado'
                ]);
        } catch (\Exception $e) {
            Log::error('Error desactivando documentos anteriores: ' . $e->getMessage());
        }
    }

    /**
     * 🔐 Generar firma digital
     */
    private function generateDocumentSignature($criminal, string $timestamp, string $user): array
    {
        $criticalData = [
            'criminal_id' => $criminal->id,
            'identity_number' => $criminal->identity_number,
            'full_name' => trim($criminal->first_name . ' ' . $criminal->last_nameP . ' ' . $criminal->last_nameM),
            'date_of_birth' => $criminal->date_of_birth,
            'timestamp' => $timestamp,
            'user' => $user,
            'version' => '1.0'
        ];

        $dataString = $this->createDeterministicString($criticalData);
        $signature = hash_hmac($this->algorithm, $dataString, $this->secretKey);
        
        return [
            'signature' => $signature,
            'data_hash' => hash($this->algorithm, $dataString),
            'timestamp' => $timestamp,
            'critical_data' => $criticalData
        ];
    }

    private function createDeterministicString(array $data): string
    {
        ksort($data);
        $parts = [];
        foreach ($data as $key => $value) {
            $parts[] = $key . ':' . ($value ?? 'NULL');
        }
        return implode('|', $parts);
    }

    /**
     * 🔐 Generar datos del QR HÍBRIDO COMPACTO
     */
    private function generateSecureQRData($criminal, $digitalSignature, $includeVerificationUrl = false)
    {
        $compactData = [
            'id' => 'DACI-' . str_pad($criminal->id, 6, '0', STR_PAD_LEFT),
            'ci' => $criminal->identity_number ?? 'N/A',
            'name' => substr(trim($criminal->first_name . ' ' . $criminal->last_nameP), 0, 30),
            'ts' => $digitalSignature['timestamp'],
            'sig' => substr($digitalSignature['signature'], 0, 12),
            'hash' => substr($digitalSignature['data_hash'], 0, 8)
        ];

        if ($includeVerificationUrl) {
            // 🔧 SIMPLIFICADO: Usar timestamp + criminal_id como identificador único
            $shortHash = substr(hash('md5', $criminal->id . '_' . $digitalSignature['timestamp']), 0, 8);
            
            
            // Formato: URL + separador + JSON (usando el prefijo verify existente)
            $verifyUrl = url('/verify/' . $shortHash);
            $jsonData = json_encode($compactData, JSON_UNESCAPED_UNICODE);
            
            // Formato simple: URL|JSON
            return $verifyUrl . '|' . $jsonData;
        }

        return json_encode($compactData, JSON_UNESCAPED_UNICODE);
    }


    /**
     * 📱 Generar QR usando API externa
     */
    private function generateSimpleQR($data)
    {
        try {
            $encodedData = urlencode($data);
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&format=png&data={$encodedData}";
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'method' => 'GET'
                ]
            ]);
            
            $qrImage = file_get_contents($qrUrl, false, $context);
            
            if ($qrImage !== false) {
                return base64_encode($qrImage);
            } else {
                return $this->generateTextPlaceholder($data);
            }
        } catch (\Exception $e) {
            Log::warning('Error generando QR externo: ' . $e->getMessage());
            return $this->generateTextPlaceholder($data);
        }
    }

    /**
     * 📱 Placeholder de texto cuando no hay QR
     */
    private function generateTextPlaceholder($data)
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        try {
            $width = 150;
            $height = 150;
            $image = imagecreate($width, $height);
            
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            $gray = imagecolorallocate($image, 128, 128, 128);
            
            imagefill($image, 0, 0, $white);
            imagerectangle($image, 0, 0, $width-1, $height-1, $black);
            
            imagestring($image, 3, 20, 30, "CODIGO QR", $black);
            imagestring($image, 2, 15, 60, "VERIFICACION", $black);
            imagestring($image, 2, 25, 80, "DIGITAL", $black);
            imagestring($image, 1, 10, 110, "Use /verify para", $gray);
            imagestring($image, 1, 15, 125, "verificar", $gray);
            
            ob_start();
            imagepng($image);
            $imageData = ob_get_contents();
            ob_end_clean();
            imagedestroy($image);
            
            return base64_encode($imageData);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 🔍 Mostrar página de verificación con parámetros de URL
     */
    public function showVerificationPage(Request $request)
    {
        $qrData = null;
        
        if ($request->has('data')) {
            try {
                $decodedData = base64_decode($request->get('data'));
                $qrData = $decodedData;
            } catch (\Exception $e) {
                Log::warning('Error decodificando datos de verificación: ' . $e->getMessage());
            }
        }

        return view('exportar.verify-page', compact('qrData'));
    }

    /**
     * 🔍 Mostrar página de verificación con URL corta
     */
    public function showVerificationPageShort($hash)
    {
        $qrData = null;
        
        try {
            $data = $this->getQRDataFromHash($hash);
            if ($data) {
                $qrData = json_encode($data, JSON_UNESCAPED_UNICODE);
            }
        } catch (\Exception $e) {
            Log::warning('Error obteniendo datos de hash corto: ' . $e->getMessage());
        }

        return view('exportar.verify-page', compact('qrData'));
    }

    /**
     * 🔍 Verificar documento (unificado y mejorado)
     */
    public function verifyDocument(Request $request)
    {
        try {
            $qrDataString = $request->input('qr_data');
            
            // Manejar diferentes tipos de entrada
            if ($request->has('hash')) {
                // URL corta con hash
                $qrData = $this->getQRDataFromHash($request->get('hash'));
                if (!$qrData) {
                    return response()->json(['valid' => false, 'message' => 'Código QR expirado o inválido']);
                }
            } elseif ($request->has('data')) {
                // URL con parámetro data
                $qrDataString = base64_decode($request->get('data'));
                $qrData = json_decode($qrDataString, true);
            } else {
                // Parseo automático
                $request->validate(['qr_data' => 'required|string']);
                $qrData = $this->parseQRData($qrDataString);
            }

            if (!$qrData || !isset($qrData['sig'], $qrData['id'])) {
                return response()->json(['valid' => false, 'message' => 'QR inválido - Estructura de datos incorrecta']);
            }

            $criminalId = $this->extractCriminalId($qrData['id']);
            if (!$criminalId) {
                return response()->json(['valid' => false, 'message' => 'ID DACI inválido']);
            }

            $documentLog = $this->findDocumentLog($criminalId, $qrData['ts']);
            if (!$documentLog) {
                return response()->json(['valid' => false, 'message' => 'Documento no encontrado en el sistema']);
            }

            if ($documentLog->status !== 'active') {
                return response()->json([
                    'valid' => false, 
                    'message' => 'Documento inactivo - Se ha generado una nueva versión'
                ]);
            }

            $isValid = $this->verifyQRSignature($qrData, $documentLog);

            if ($isValid) {
                $criminal = Criminal::find($criminalId);
                
                return response()->json([
                    'valid' => true,
                    'message' => 'Documento auténtico y válido',
                    'data' => [
                        'criminal_id' => $criminalId,
                        'ci' => $criminal ? $criminal->identity_number : ($qrData['ci'] ?? 'N/A'),
                        'name' => $criminal ? trim($criminal->first_name . ' ' . $criminal->last_nameP . ' ' . $criminal->last_nameM) : ($qrData['name'] ?? 'N/A'),
                        'document_type' => ucfirst($documentLog->document_type ?? 'desconocido'),
                        'generated_at' => $qrData['ts'],
                        'document_status' => 'Válido y Activo',
                        'verification_time' => Carbon::now('America/La_Paz')->format('Y-m-d H:i:s')
                    ]
                ]);
            } else {
                return response()->json(['valid' => false, 'message' => 'Firma digital inválida - Posible falsificación']);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['valid' => false, 'message' => 'Datos de verificación requeridos'], 422);
        } catch (\Exception $e) {
            Log::error('Error verificando documento: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json(['valid' => false, 'message' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * 🔍 Obtener datos del QR desde hash corto (usando document_generations)
     */
    private function getQRDataFromHash($hash)
    {
        try {
            // 🔧 SIMPLIFICADO: Buscar en document_generations usando el hash
            // El hash se genera con: criminal_id + timestamp
            $documents = DB::table('document_generations')
                ->join('criminals', 'document_generations.criminal_id', '=', 'criminals.id')
                ->where('document_generations.status', 'active')
                ->select([
                    'document_generations.*',
                    'criminals.identity_number',
                    'criminals.first_name',
                    'criminals.last_nameP'
                ])
                ->get();

            // Buscar el documento que coincida con el hash
            foreach ($documents as $doc) {
                $expectedHash = substr(hash('md5', $doc->criminal_id . '_' . $doc->timestamp), 0, 8);
                
                if ($expectedHash === $hash) {
                    // Reconstruir los datos del QR
                    return [
                        'id' => 'DACI-' . str_pad($doc->criminal_id, 6, '0', STR_PAD_LEFT),
                        'ci' => $doc->identity_number ?? 'N/A',
                        'name' => substr(trim($doc->first_name . ' ' . $doc->last_nameP), 0, 30),
                        'ts' => $doc->timestamp,
                        'sig' => substr($doc->signature, 0, 12),
                        'hash' => substr($doc->data_hash, 0, 8)
                    ];
                }
            }
            
            return null; // No encontrado
        } catch (\Exception $e) {
            Log::error('Error obteniendo datos de hash desde document_generations: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 🔍 Parser inteligente de datos QR
     */
    private function parseQRData($qrDataString)
    {
        try {
            // Caso 1: Formato URL|JSON (nuevo formato híbrido simple)
            if (strpos($qrDataString, '|') !== false) {
                $parts = explode('|', $qrDataString, 2);
                if (count($parts) === 2) {
                    $url = $parts[0];
                    $jsonPart = $parts[1];
                    
                    Log::info('QR híbrido URL|JSON detectado', ['url' => $url]);
                    
                    // Intentar parsear la parte JSON
                    $jsonData = json_decode($jsonPart, true);
                    if ($jsonData) {
                        return $jsonData; // Usar datos directos del JSON
                    }
                }
            }
            
            // Caso 2: JSON con estructura híbrida compacta {v:..., d:...}
            $jsonData = json_decode($qrDataString, true);
            if ($jsonData && isset($jsonData['v'], $jsonData['d'])) {
                Log::info('QR híbrido compacto {v,d} detectado');
                return $jsonData['d']; // Usar datos directos
            }
            
            // Caso 3: URL corta sola
            if (preg_match('/\/verify\/([a-f0-9]{8})$/i', $qrDataString, $matches)) {
                return $this->getQRDataFromHash($matches[1]);
            }
            
            // Caso 4: URL con parámetros
            if (filter_var($qrDataString, FILTER_VALIDATE_URL)) {
                $urlParts = parse_url($qrDataString);
                if (isset($urlParts['query'])) {
                    parse_str($urlParts['query'], $queryParams);
                    if (isset($queryParams['data'])) {
                        $decoded = base64_decode($queryParams['data']);
                        return json_decode($decoded, true);
                    }
                }
            }
            
            // Caso 5: JSON directo
            if ($jsonData) {
                // Backward compatibility con formato legacy
                if (isset($jsonData['url']) && isset($jsonData['data'])) {
                    return $jsonData['data'];
                }
                return $jsonData;
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error parseando QR data: ' . $e->getMessage());
            return null;
        }
    }

    // Métodos auxiliares
    private function extractCriminalId($daciId)
    {
        try {
            if (!is_string($daciId)) {
                return null;
            }
            
            $parts = explode('-', $daciId);
            if (count($parts) >= 2 && strtoupper($parts[0]) === 'DACI') {
                $id = (int) ltrim($parts[1], '0');
                return $id > 0 ? $id : null;
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error extrayendo criminal_id: ' . $e->getMessage());
            return null;
        }
    }

    private function verifyQRSignature($qrData, $documentLog)
    {
        try {
            if (!isset($qrData['sig']) || !$documentLog->signature) {
                return false;
            }
            
            $expectedSig = substr($documentLog->signature, 0, 12);
            $providedSig = $qrData['sig'];
            
            return $expectedSig === $providedSig;
        } catch (\Exception $e) {
            Log::error('Error verificando firma: ' . $e->getMessage());
            return false;
        }
    }

    private function findDocumentLog($criminalId, $timestamp)
    {
        try {
            return DB::table('document_generations')
                ->where('criminal_id', $criminalId)
                ->where('timestamp', $timestamp)
                ->first();
        } catch (\Exception $e) {
            Log::error('Error buscando documento: ' . $e->getMessage());
            return null;
        }
    }

    private function logDocumentGeneration($criminalId, $digitalSignature, $documentId, $documentType = 'rapido')
    {
        try {
            DB::table('document_generations')->insert([
                'document_id' => $documentId,
                'criminal_id' => $criminalId,
                'signature' => $digitalSignature['signature'],
                'data_hash' => $digitalSignature['data_hash'],
                'timestamp' => $digitalSignature['timestamp'],
                'document_type' => $documentType,
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'status' => 'active',
                'created_at' => now()
            ]);
            
            Log::info('Documento registrado exitosamente', [
                'document_id' => $documentId,
                'criminal_id' => $criminalId,
                'type' => $documentType
            ]);
        } catch (\Exception $e) {
            Log::error('Error registrando documento: ' . $e->getMessage());
        }
    }

    private function getGenerationInfo()
    {
        return [
            'fecha_generacion' => Carbon::now('America/La_Paz')->translatedFormat('l d \d\e F \d\e Y'),
            'hora_generacion' => Carbon::now('America/La_Paz')->format('H:i:s'),
            'usuario' => Auth::user()->name ?? 'Usuario desconocido',
            'version_sistema' => '2.0'
        ];
    }

    /**
     * 📊 Obtener documentos del usuario actual
     */
    public function getUserDocuments()
    {
        try {
            $documents = DB::table('document_generations')
                ->join('criminals', 'document_generations.criminal_id', '=', 'criminals.id')
                ->where('document_generations.user_id', Auth::id())
                ->select([
                    'document_generations.document_id',
                    'document_generations.document_type', 
                    'document_generations.timestamp',
                    'document_generations.status',
                    'criminals.first_name',
                    'criminals.last_nameP',
                    'criminals.identity_number'
                ])
                ->orderBy('document_generations.created_at', 'desc')
                ->paginate(20);

            return response()->json(['success' => true, 'documents' => $documents]);
        } catch (\Exception $e) {
            Log::error('Error obteniendo documentos del usuario: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error obteniendo documentos'], 500);
        }
    }

    /**
     * 📈 Estadísticas de verificación
     */
    public function getVerificationStats()
    {
        try {
            $stats = [
                'total_documents' => DB::table('document_generations')->count(),
                'active_documents' => DB::table('document_generations')->where('status', 'active')->count(),
                'today_generated' => DB::table('document_generations')
                    ->whereDate('created_at', today())
                    ->count(),
                'this_month_generated' => DB::table('document_generations')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];

            return response()->json(['success' => true, 'stats' => $stats]);
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error obteniendo estadísticas'], 500);
        }
    }
}