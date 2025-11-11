<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\photograph;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FaceCheckController extends Controller
{
    public function showForm()
    {
        return view('criminals.face_check');
    }

    public function checkFace(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:10240' // Max 10MB
        ]);

        try {
            Log::info('=== INICIO DE PROCESO DE RECONOCIMIENTO FACIAL ===');

            // Foto subida por el usuario
            $uploadedPhoto = $request->file('photo');
            Log::info('Archivo subido:', [
                'name' => $uploadedPhoto->getClientOriginalName(),
                'size' => $uploadedPhoto->getSize(),
                'mime' => $uploadedPhoto->getMimeType(),
                'path' => $uploadedPhoto->getRealPath()
            ]);

            // Verificar que el archivo existe y es legible
            if (!file_exists($uploadedPhoto->getRealPath())) {
                Log::error('Archivo subido no existe en la ruta especificada');
                return view('criminals.face_check', [
                    'result' => ['error' => 'Error: archivo subido no accesible.']
                ]);
            }

            // Obtener solo las fotos face_photo con información del criminal
            $photos = photograph::whereNotNull('face_photo')
                ->where('face_photo', '!=', '')
                ->with('criminal') // Cargar relación con criminal
                ->select('id', 'criminal_id', 'face_photo')
                ->get();

            Log::info('Fotos face_photo encontradas:', [
                'count' => $photos->count(),
                'sample_data' => $photos->take(3)->map(function ($photo) {
                    return [
                        'id' => $photo->id,
                        'criminal_id' => $photo->criminal_id,
                        'criminal_name' => $photo->criminal ? $photo->criminal->first_name : 'N/A',
                        'face_photo' => $photo->face_photo
                    ];
                })->toArray()
            ]);

            if ($photos->isEmpty()) {
                return view('criminals.face_check', [
                    'result' => ['error' => 'No hay fotos face_photo almacenadas para comparar.']
                ]);
            }

            // Crear un mapeo de filename -> criminal_info para respuesta rápida
            $filenameToCase = [];
            Log::info('Mapeo filename -> criminal creado:', [
                'total_mappings' => count($filenameToCase),
                'sample_mappings' => array_slice($filenameToCase, 0, 3, true),
                'all_filenames' => array_keys($filenameToCase)
            ]);

            // Preparar archivos para multipart - CORREGIR RUTAS
            $validPhotos = [];
            foreach ($photos as $photo) {
                $facePhoto = $photo->face_photo;

                // Las rutas en BD son como: /storage/fotos_criminal/123456-imagen.jpg
                // Necesitamos convertir a: storage/app/public/fotos_criminal/123456-imagen.jpg

                if (strpos($facePhoto, '/storage/') === 0) {
                    // Quitar /storage/ del inicio
                    $relativePath = substr($facePhoto, 9); // Quita "/storage/"
                } else {
                    $relativePath = $facePhoto;
                }

                $fullPath = storage_path('app/public/' . $relativePath);
                $filename = basename($fullPath);

                Log::info('Verificando foto:', [
                    'db_path' => $facePhoto,
                    'relative_path' => $relativePath,
                    'full_path' => $fullPath,
                    'filename' => $filename,
                    'criminal_id' => $photo->criminal_id,
                    'exists' => file_exists($fullPath),
                    'readable' => file_exists($fullPath) ? is_readable($fullPath) : false
                ]);

                if (file_exists($fullPath) && is_readable($fullPath)) {
                    $validPhotos[] = $fullPath;

                    // Mapear filename a información del criminal
                    $filenameToCase[$filename] = [
                        'photo_id' => $photo->id,
                        'criminal_id' => $photo->criminal_id,
                        'criminal' => $photo->criminal ? [
                            'id' => $photo->criminal->id,
                            'first_name' => $photo->criminal->first_name,
                            'last_nameP' => $photo->criminal->last_nameP ?? null,
                            'last_nameM' => $photo->criminal->last_nameM ?? null,
                            'identity_number' => $photo->criminal->identity_number ?? null,
                            'date_of_birth' => $photo->criminal->date_of_birth ?? null,
                            'age' => $photo->criminal->age ?? null,
                        ] : null
                    ];

                    Log::info('✅ Foto válida encontrada:', [
                        'path' => $fullPath,
                        'filename' => $filename,
                        'criminal' => $photo->criminal ? $photo->criminal->first_name : 'Sin criminal',
                        'criminal_id' => $photo->criminal_id
                    ]);
                } else {
                    Log::warning('❌ Foto no encontrada o no legible:', [
                        'expected_path' => $fullPath,
                        'db_value' => $facePhoto
                    ]);
                }
            }

            Log::info('Mapeo filename -> criminal creado:', [
                'total_mappings' => count($filenameToCase),
                'sample_mappings' => array_slice($filenameToCase, 0, 3, true)
            ]);

            if (empty($validPhotos)) {
                return view('criminals.face_check', [
                    'result' => ['error' => 'No se encontraron fotos válidas para comparar.']
                ]);
            }

            Log::info('Fotos válidas para procesar:', ['count' => count($validPhotos)]);

            // Preparar multipart de forma más simple
            $multipart = [
                [
                    'name'     => 'uploaded_photo',
                    'contents' => fopen($uploadedPhoto->getRealPath(), 'r'),
                    'filename' => $uploadedPhoto->getClientOriginalName(),
                ]
            ];

            foreach ($validPhotos as $index => $photoPath) {
                $multipart[] = [
                    'name'     => 'stored_photos',
                    'contents' => fopen($photoPath, 'r'),
                    'filename' => basename($photoPath),
                ];
            }

            Log::info('Multipart preparado con elementos:', ['count' => count($multipart)]);

            // Realizar petición a FastAPI
            $apiUrl = 'http://127.0.0.1:8000/compare-faces/';
            Log::info('Enviando petición a:', ['url' => $apiUrl]);

            try {
                $response = Http::timeout(120) // Más tiempo para procesamiento
                    ->asMultipart()
                    ->post($apiUrl, $multipart);

                Log::info('Respuesta de API recibida:', [
                    'status' => $response->status(),
                    'successful' => $response->successful(),
                    'body_length' => strlen($response->body())
                ]);

                if ($response->successful()) {
                    $result = $response->json();

                    $result = $response->json();
                    Log::info('Respuesta del API recibida:', $result);

                    // FORZAR el mapeo del criminal
                    if (isset($result['match']) && $result['match'] && isset($result['filename'])) {
                        $matchedFilename = $result['filename'];
                        Log::info('Procesando coincidencia:', ['filename' => $matchedFilename]);

                        // Buscar directamente en la base de datos
                        $photo = \App\Models\photograph::where('face_photo', 'LIKE', '%' . $matchedFilename . '%')
                            ->with('criminal')
                            ->first();

                        if ($photo && $photo->criminal) {
                            $result['criminal_info'] = [
                                'id' => $photo->criminal->id,
                                'first_name' => $photo->criminal->first_name,
                                'last_nameP' => $photo->criminal->last_nameP ?? null,
                                'last_nameM' => $photo->criminal->last_nameM ?? null,
                                'identity_number' => $photo->criminal->identity_number ?? null,
                                'date_of_birth' => $photo->criminal->date_of_birth ?? null,
                                'age' => $photo->criminal->age ?? null,
                            ];
                            $result['photo_id'] = $photo->id;
                            Log::info('✅ Criminal encontrado y agregado:', $result['criminal_info']);
                        } else {
                            Log::warning('❌ No se encontró foto/criminal para:', ['filename' => $matchedFilename]);

                            // Buscar por coincidencia parcial
                            $photos = \App\Models\photograph::whereNotNull('face_photo')
                                ->with('criminal')
                                ->get();

                            foreach ($photos as $photo) {
                                $storedFilename = basename($photo->face_photo);
                                if (strpos($storedFilename, $matchedFilename) !== false || strpos($matchedFilename, $storedFilename) !== false) {
                                    $result['criminal_info'] = [
                                        'id' => $photo->criminal->id,
                                        'first_name' => $photo->criminal->first_name,
                                        'last_nameP' => $photo->criminal->last_nameP ?? null,
                                        'last_nameM' => $photo->criminal->last_nameM ?? null,
                                        'identity_number' => $photo->criminal->identity_number ?? null,
                                        'date_of_birth' => $photo->criminal->date_of_birth ?? null,
                                        'age' => $photo->criminal->age ?? null,
                                    ];
                                    $result['photo_id'] = $photo->id;
                                    Log::info('✅ Criminal encontrado por coincidencia parcial');
                                    break;
                                }
                            }
                        }
                    }

                    Log::info('Resultado final con criminal:', $result);
                    return view('criminals.face_check', [
                        'result' => $result
                    ]);
                } else {
                    Log::error('Respuesta no exitosa:', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);

                    return view('criminals.face_check', [
                        'result' => [
                            'error' => 'Error del servidor de reconocimiento facial.',
                            'debug' => [
                                'status' => $response->status(),
                                'response' => $response->body()
                            ]
                        ]
                    ]);
                }
            } catch (\Illuminate\Http\Client\RequestException $e) {
                Log::error('Error de petición HTTP:', [
                    'message' => $e->getMessage(),
                    'response' => $e->response ? $e->response->body() : 'No response'
                ]);

                return view('criminals.face_check', [
                    'result' => ['error' => 'Error de comunicación con el servidor de reconocimiento facial.']
                ]);
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::error('Error de conexión:', ['message' => $e->getMessage()]);

                return view('criminals.face_check', [
                    'result' => ['error' => 'No se puede conectar al servidor de reconocimiento facial. Verifica que esté ejecutándose.']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error general en checkFace:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('criminals.face_check', [
                'result' => ['error' => 'Error inesperado: ' . $e->getMessage()]
            ]);
        }
    }
}
