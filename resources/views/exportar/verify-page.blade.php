<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Documento - DACI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6f42c1;
            --secondary-color: #495057;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #fd7e14;
            --info-color: #0dcaf0;
            --dark-bg: #1a1d29;
            --dark-card: #242940;
            --dark-border: #3a3f5c;
            --dark-text: #e9ecef;
            --dark-muted: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #2c3e50 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-text);
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            z-index: -1;
        }
        
        .container {
            background: var(--dark-card);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(0,0,0,0.3),
                0 0 20px rgba(111, 66, 193, 0.1);
            padding: 40px;
            max-width: 700px;
            width: 100%;
            border: 1px solid var(--dark-border);
            backdrop-filter: blur(10px);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .header h1 {
            color: var(--dark-text);
            margin: 0;
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .header h1 i {
            animation: float 3s ease-in-out infinite;
            color: var(--primary-color);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        .header p {
            color: var(--dark-muted);
            margin: 10px 0 0;
            font-size: 1.1rem;
        }

        /* Auto-verify notification */
        .auto-verify-info {
            background: linear-gradient(135deg, rgba(13, 202, 240, 0.15) 0%, rgba(111, 66, 193, 0.1) 100%);
            border: 1px solid rgba(13, 202, 240, 0.3);
            color: var(--info-color);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
            animation: slideIn 0.5s ease;
        }

        .auto-verify-info strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .auto-verify-countdown {
            font-size: 0.9rem;
            margin-top: 10px;
            opacity: 0.8;
        }

        /* Instructions section */
        .instructions {
            background: linear-gradient(135deg, var(--dark-border) 0%, rgba(111, 66, 193, 0.1) 100%);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
        }
        
        .instructions h3 {
            color: var(--info-color);
            margin-bottom: 1rem;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .instructions ul {
            color: var(--dark-text);
            line-height: 1.6;
            padding-left: 1rem;
            list-style: none;
        }
        
        .instructions li {
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .instructions li::before {
            content: '▶';
            color: var(--primary-color);
            position: absolute;
            left: 0;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark-text);
            font-size: 1.1rem;
        }
        
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--dark-border);
            border-radius: 12px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            resize: vertical;
            min-height: 120px;
            box-sizing: border-box;
            background: var(--dark-bg);
            color: var(--dark-text);
            transition: all 0.3s ease;
        }

        .form-group textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
            outline: none;
        }

        .form-group textarea::placeholder {
            color: var(--dark-muted);
            opacity: 0.8;
        }

        /* QR Scanner Section */
        .qr-scanner-section {
            background: linear-gradient(135deg, rgba(111, 66, 193, 0.1) 0%, rgba(142, 68, 173, 0.05) 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: center;
            border: 1px solid var(--dark-border);
        }
        
        #reader {
            max-width: 300px;
            margin: 1rem auto;
            border: 3px dashed var(--dark-border);
            border-radius: 15px;
            display: none;
            background: var(--dark-bg);
        }

        #reader video {
            border-radius: 12px;
        }

        .camera-permissions {
            background: rgba(253, 126, 20, 0.1);
            border: 1px solid rgba(253, 126, 20, 0.3);
            border-radius: 10px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: center;
        }

        .camera-permissions .fas {
            color: var(--warning-color);
            margin-right: 0.5rem;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
            margin: 0.25rem;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8e44ad 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);
            width: 100%;
            justify-content: center;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #8e44ad 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(111, 66, 193, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #6c757d 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(73, 80, 87, 0.3);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #6c757d 0%, var(--secondary-color) 100%);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%);
            color: white;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn:disabled:hover {
            transform: none;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
            margin: 1rem 0;
        }

        /* Loading */
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
            background: var(--dark-card);
            border-radius: 15px;
            margin: 1rem 0;
            border: 1px solid var(--dark-border);
        }
        
        .spinner {
            border: 4px solid var(--dark-border);
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Results */
        .result {
            margin-top: 20px;
            padding: 20px;
            border-radius: 15px;
            display: none;
            animation: slideIn 0.4s ease;
            border: none;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .result::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: currentColor;
        }
        
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(-20px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        .result.success {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.15) 0%, rgba(32, 201, 151, 0.1) 100%);
            border: 1px solid rgba(25, 135, 84, 0.3);
            color: #75b798;
        }
        
        .result.error {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.15) 0%, rgba(231, 76, 60, 0.1) 100%);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #f1aeb5;
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
            margin: 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .status-valid {
            background: linear-gradient(135deg, var(--success-color) 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
        }
        
        .status-invalid {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        /* Document details */
        .document-details {
            margin-top: 15px;
            background: rgba(111, 66, 193, 0.1);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--dark-border);
        }
        
        .document-details h4 {
            margin: 0 0 15px 0;
            color: var(--info-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .document-details p {
            margin: 8px 0;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .document-details strong {
            color: var(--info-color);
            min-width: 120px;
        }

        .verification-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }

        .verification-item {
            background: rgba(111, 66, 193, 0.1);
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid var(--dark-border);
        }

        .verification-item strong {
            color: var(--info-color);
            display: block;
            margin-bottom: 0.5rem;
        }

        /* Text utilities */
        .text-muted {
            color: var(--dark-muted) !important;
            font-size: 0.9rem;
        }

        .text-center {
            text-align: center;
        }

        .text-success {
            color: var(--success-color) !important;
        }

        .text-danger {
            color: var(--danger-color) !important;
        }

        .text-warning {
            color: var(--warning-color) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 20px;
            }
            
            .btn {
                width: 100%;
                margin: 0.25rem 0;
                justify-content: center;
            }

            .quick-actions {
                flex-direction: column;
            }

            .verification-grid {
                grid-template-columns: 1fr;
            }
            
            #reader {
                max-width: 100%;
                width: 280px;
            }

            .instructions {
                padding: 1rem;
            }

            .form-group textarea {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            
            .btn {
                padding: 0.875rem 1rem;
                font-size: 0.95rem;
            }
        }

        /* Dark scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8e44ad;
        }

        /* Toast notifications */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--dark-card);
            color: var(--dark-text);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            border: 1px solid var(--dark-border);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideInRight 0.3s ease;
            max-width: 300px;
            word-wrap: break-word;
        }
        
        .toast-success { border-left: 4px solid var(--success-color); }
        .toast-error { border-left: 4px solid var(--danger-color); }
        .toast-warning { border-left: 4px solid var(--warning-color); }
        .toast-info { border-left: 4px solid var(--info-color); }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .toast-notification.removing {
            animation: slideOutRight 0.3s ease;
        }
        
        @media (max-width: 480px) {
            .toast-notification {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-shield-alt"></i> Verificación de Documento</h1>
            <p><i class="fas fa-certificate"></i> Sistema de Verificación de Autenticidad - DACI</p>
        </div>

        <!-- Auto-verify notification (only shown when QR data is detected) -->
        @if($qrData && !($autoVerify ?? false))
        <div class="auto-verify-info" id="autoVerifyInfo">
            <strong><i class="fas fa-mobile-alt"></i> Verificación Automática desde QR</strong>
            <div>Se ha detectado un código QR válido. Verificando automáticamente...</div>
            <div class="auto-verify-countdown" id="countdown">
                <i class="fas fa-clock"></i> Verificando en <span id="countdownNumber">3</span> segundos
            </div>
        </div>
        @elseif($qrData && ($autoVerify ?? false))
        <div class="auto-verify-info" id="autoVerifyInfo">
            <strong><i class="fas fa-link"></i> Verificación Automática desde URL</strong>
            <div>Documento detectado desde enlace directo. Verificando automáticamente...</div>
            <div class="auto-verify-countdown" id="countdown">
                <i class="fas fa-clock"></i> Verificando en <span id="countdownNumber">3</span> segundos
            </div>
        </div>
        @endif

        <!-- Instructions -->
        <div class="instructions">
            <h3><i class="fas fa-info-circle"></i> Instrucciones de Verificación</h3>
            <ul>
                <li><strong>Escanear QR:</strong> Use el botón de cámara para escanear directamente el código QR</li>
                <li><strong>Pegar contenido:</strong> Copie y pegue manualmente el texto del código QR</li>
                <li><strong>Verificación automática:</strong> El sistema validará la firma digital instantáneamente</li>
                <li><strong>Resultado inmediato:</strong> Obtendrá confirmación de autenticidad en tiempo real</li>
            </ul>
        </div>

        <form id="verifyForm">
            @csrf
            <div class="form-group" id="manualInputGroup" style="display: none;">
                <label for="qr_data">
                    <i class="fas fa-qrcode"></i> Datos del código QR:
                </label>
                <textarea 
                    id="qr_data" 
                    name="qr_data" 
                    placeholder='Pegue aquí el contenido completo del código QR del documento.

Ejemplo de formato esperado:
{"id":"DACI-000123","ci":"1234567","name":"Juan Pérez","ts":"2024-08-05 14:30:00","sig":"abc123def456","hash":"xy789zab"}

Consejo: Presione Ctrl + Enter para verificar rápidamente'
                    required>{{ $qrData }}</textarea>
                <div class="text-muted">
                    <i class="fas fa-lightbulb"></i> Consejo: Presione <strong>Ctrl + Enter</strong> para verificar rápidamente
                </div>
            </div>

            <!-- QR Scanner Section -->
            <div class="qr-scanner-section">
                <h5 style="margin-bottom: 1rem;"><i class="fas fa-camera"></i> Escáner de Cámara</h5>
                <div class="quick-actions">
                    <button type="button" class="btn btn-secondary" onclick="toggleScanner()">
                        <i class="fas fa-camera"></i> Activar Escáner
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleManualInput()">
                        <i class="fas fa-keyboard"></i> Entrada Manual
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearForm()">
                        <i class="fas fa-eraser"></i> Limpiar
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="loadSampleData()">
                        <i class="fas fa-flask"></i> Datos de Prueba
                    </button>
                </div>
                
                <div id="reader"></div>
                
                <div class="camera-permissions">
                    <i class="fas fa-exclamation-triangle"></i>
                    <small>El escáner requiere permisos de cámara y conexión HTTPS para funcionar correctamente</small>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-check-circle"></i> Verificar Documento
            </button>
        </form>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <h5><i class="fas fa-cog fa-spin"></i> Verificando documento...</h5>
            <p class="text-muted">Validando firma digital y autenticidad</p>
        </div>

        <div class="result" id="result">
            <div id="resultContent"></div>
        </div>
    </div>

    <!-- QR Code Scanner -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    
    <script>
        let html5QrcodeScanner = null;
        let scannerActive = false;
        let autoVerifyTimer = null;

        // Auto-verificación desde QR o URL corta
        @if($qrData && ($autoVerify ?? false))
        document.addEventListener('DOMContentLoaded', function() {
            let countdown = 3;
            const countdownElement = document.getElementById('countdownNumber');
            
            // Mostrar notificación de auto-verificación
            const autoVerifyInfo = document.getElementById('autoVerifyInfo');
            if (!autoVerifyInfo) {
                // Crear notificación si no existe
                const notification = document.createElement('div');
                notification.className = 'auto-verify-info';
                notification.innerHTML = `
                    <strong><i class="fas fa-link"></i> Verificación Automática desde URL</strong>
                    <div>Documento detectado desde enlace directo. Verificando automáticamente...</div>
                    <div class="auto-verify-countdown">
                        <i class="fas fa-clock"></i> Verificando en <span id="countdownNumber">${countdown}</span> segundos
                    </div>
                `;
                
                // Insertar después del header
                const header = document.querySelector('.header');
                header.insertAdjacentElement('afterend', notification);
            }
            
            const countdownInterval = setInterval(function() {
                countdown--;
                const countdownEl = document.getElementById('countdownNumber');
                if (countdownEl) {
                    countdownEl.textContent = countdown;
                }
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    // Trigger verification
                    document.getElementById('verifyForm').dispatchEvent(new Event('submit'));
                    // Hide auto-verify info
                    const autoVerifyNotification = document.querySelector('.auto-verify-info');
                    if (autoVerifyNotification) {
                        autoVerifyNotification.style.display = 'none';
                    }
                }
            }, 1000);
        });
        @elseif($qrData)
        document.addEventListener('DOMContentLoaded', function() {
            let countdown = 3;
            const countdownElement = document.getElementById('countdownNumber');
            
            const countdownInterval = setInterval(function() {
                countdown--;
                if (countdownElement) {
                    countdownElement.textContent = countdown;
                }
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    // Trigger verification
                    document.getElementById('verifyForm').dispatchEvent(new Event('submit'));
                    // Hide auto-verify info
                    const autoVerifyInfo = document.getElementById('autoVerifyInfo');
                    if (autoVerifyInfo) {
                        autoVerifyInfo.style.display = 'none';
                    }
                }
            }, 1000);
        });
        @endif

        // QR Scanner functions
        function toggleScanner() {
            const readerDiv = document.getElementById('reader');
            const button = event.target;
            
            if (!scannerActive) {
                readerDiv.style.display = 'block';
                button.innerHTML = '<i class="fas fa-stop"></i> Detener Escáner';
                button.className = 'btn btn-danger';
                startScanner();
            } else {
                readerDiv.style.display = 'none';
                button.innerHTML = '<i class="fas fa-camera"></i> Activar Escáner';
                button.className = 'btn btn-secondary';
                stopScanner();
            }
        }

        function startScanner() {
            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error('Camera not supported');
                }

                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", 
                    { 
                        fps: 10, 
                        qrbox: { width: 250, height: 250 },
                        aspectRatio: 1.0,
                        showTorchButtonIfSupported: true,
                        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                    },
                    false
                );

                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                scannerActive = true;
                
                showToast('Cámara activada', 'success');
            } catch (error) {
                console.error('Scanner error:', error);
                showError(`
                    <div class="text-center">
                        <i class="fas fa-camera-slash fa-2x mb-3"></i>
                        <h5>No se pudo activar la cámara</h5>
                        <p>Posibles causas:</p>
                        <ul style="text-align: left; display: inline-block;">
                            <li>Permisos de cámara denegados</li>
                            <li>Cámara en uso por otra aplicación</li>
                            <li>Conexión no segura (requiere HTTPS)</li>
                            <li>Navegador no compatible</li>
                        </ul>
                        <p style="margin-top: 1rem;">Intente pegar el contenido del QR manualmente.</p>
                    </div>
                `);
                resetScannerButton();
            }
        }

        function stopScanner() {
            try {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                    html5QrcodeScanner = null;
                }
                scannerActive = false;
                showToast('Escáner detenido', 'info');
            } catch (error) {
                console.error('Error stopping scanner:', error);
            }
        }

        function resetScannerButton() {
            const button = document.querySelector('button[onclick="toggleScanner()"]');
            if (button) {
                button.innerHTML = '<i class="fas fa-camera"></i> Activar Escáner';
                button.className = 'btn btn-secondary';
            }
            scannerActive = false;
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Detectar tipo de QR y actuar en consecuencia
            try {
                // Caso 1: Formato URL|JSON (nuevo formato híbrido simple)
                if (decodedText.includes('|')) {
                    const parts = decodedText.split('|');
                    if (parts.length === 2) {
                        const url = parts[0];
                        const jsonPart = parts[1];
                        
                        showToast('QR híbrido URL|JSON detectado', 'info');
                        
                        try {
                            const jsonData = JSON.parse(jsonPart);
                            
                            if (navigator.onLine) {
                                showToast('Conexión detectada - Disponible verificación automática', 'success');
                                // En un app real, esto abriría: window.open(url, '_blank');
                                
                                // Para demo, usar los datos directamente
                                document.getElementById('qr_data').value = JSON.stringify(jsonData, null, 2);
                            } else {
                                showToast('Sin conexión - Usando datos offline', 'warning');
                                document.getElementById('qr_data').value = JSON.stringify(jsonData, null, 2);
                            }
                        } catch (e) {
                            // Si el JSON está malformado, usar como texto plano
                            document.getElementById('qr_data').value = decodedText;
                        }
                    }
                }
                // Caso 2: JSON estructurado {v: ..., d: ...}
                else {
                    const qrData = JSON.parse(decodedText);
                    
                    // QR híbrido compacto: tiene URL (v) y datos (d)
                    if (qrData.v && qrData.d) {
                        showToast('QR híbrido {v,d} detectado - Modo inteligente activado', 'info');
                        
                        if (navigator.onLine) {
                            showToast('Conexión detectada - Redirigiendo para verificación automática', 'success');
                            // window.open(qrData.v, '_blank');
                            document.getElementById('qr_data').value = JSON.stringify(qrData.d, null, 2);
                        } else {
                            showToast('Sin conexión - Usando datos offline', 'warning');
                            document.getElementById('qr_data').value = JSON.stringify(qrData.d, null, 2);
                        }
                    } else {
                        // QR normal (JSON directo)
                        document.getElementById('qr_data').value = decodedText;
                    }
                }
                
            } catch (e) {
                // No es JSON, podría ser URL directa o texto plano
                if (decodedText.includes('/verify/')) {
                    showToast('URL de verificación detectada', 'info');
                    if (navigator.onLine) {
                        showToast('Redirigiendo para verificación automática...', 'success');
                        // window.open(decodedText, '_blank');
                    } else {
                        showToast('Sin conexión - URL no puede procesarse offline', 'error');
                        return;
                    }
                } else {
                    // Texto plano o formato desconocido
                    document.getElementById('qr_data').value = decodedText;
                }
            }
            
            stopScanner();
            document.getElementById('reader').style.display = 'none';
            resetScannerButton();
            
            showToast('QR escaneado exitosamente', 'success');
            
            // Auto-verify después del escaneo
            setTimeout(() => {
                verifyDocument();
            }, 1500);
        }

        function onScanFailure(error) {
            console.debug('Scan failure:', error);
        }

        // Form submission
        document.getElementById('verifyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            await verifyDocument();
        });

        async function verifyDocument() {
            const submitBtn = document.getElementById('submitBtn');
            const loading = document.getElementById('loading');
            const result = document.getElementById('result');
            const resultContent = document.getElementById('resultContent');
            const qrData = document.getElementById('qr_data').value.trim();
            
            if (!qrData) {
                showError(`
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-2x" style="margin-bottom: 1rem;"></i>
                        <h5>Datos Requeridos</h5>
                        <p>Por favor ingrese o escanee el contenido del código QR del documento.</p>
                    </div>
                `);
                return;
            }

            // Validate and parse QR data (mejorado para formato URL|JSON)
            let parsedData;
            try {
                // Caso 1: Formato URL|JSON
                if (qrData.includes('|')) {
                    const parts = qrData.split('|');
                    if (parts.length === 2) {
                        const jsonPart = parts[1];
                        parsedData = JSON.parse(jsonPart);
                        showToast('QR híbrido URL|JSON procesado', 'info');
                    } else {
                        throw new Error('Invalid URL|JSON format');
                    }
                }
                // Caso 2: JSON normal
                else {
                    parsedData = JSON.parse(qrData);
                    
                    // Manejar QR híbrido compacto (v + d)
                    if (parsedData.v && parsedData.d) {
                        showToast('QR híbrido {v,d} procesado', 'info');
                        parsedData = parsedData.d; // Usar los datos directos
                    }
                    // Manejar QR híbrido legacy (url + data)
                    else if (parsedData.url && parsedData.data) {
                        parsedData = parsedData.data; // Usar los datos directos
                    }
                }
                
                if (!parsedData.id && !parsedData.sig && !parsedData.hash) {
                    throw new Error('Invalid QR structure');
                }
            } catch (e) {
                showError(`
                    <div class="text-center">
                        <i class="fas fa-times-circle fa-2x" style="margin-bottom: 1rem;"></i>
                        <h5>Formato de QR Inválido</h5>
                        <p>El contenido debe ser un JSON válido o formato URL|JSON.</p>
                        <p class="text-muted" style="margin-top: 1rem;">Verifique que haya copiado correctamente todo el contenido del código QR.</p>
                    </div>
                `);
                return;
            }
            
            // Show loading
            submitBtn.disabled = true;
            loading.style.display = 'block';
            result.style.display = 'none';
            showToast('Iniciando verificación...', 'info');
            
            try {
                const response = await fetch('{{ route("verify.document") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        qr_data: qrData
                    })
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();
                
                // Hide loading
                loading.style.display = 'none';
                result.style.display = 'block';
                
                if (data.valid) {
                    result.className = 'result success';
                    let content = `
                        <div class="text-center" style="margin-bottom: 2rem;">
                            <div class="status-badge status-valid">
                                <i class="fas fa-check-circle"></i> DOCUMENTO AUTÉNTICO
                            </div>
                        </div>
                        <div class="text-center" style="margin-bottom: 2rem;">
                            <i class="fas fa-shield-check fa-3x text-success" style="margin-bottom: 1rem;"></i>
                            <h4 class="text-success">✅ ${data.message}</h4>
                        </div>
                    `;
                    
                    if (data.data) {
                        // Formatear ID DACI con 6 dígitos
                        const daciId = 'DACI-' + String(data.data.criminal_id).padStart(6, '0');
                        
                        content += `
                            <div class="document-details">
                                <h4><i class="fas fa-clipboard-list"></i> Detalles del Documento:</h4>
                                <div class="verification-grid">
                                    <div class="verification-item">
                                        <strong><i class="fas fa-fingerprint"></i> ID DACI:</strong>
                                        <span>${daciId}</span>
                                    </div>
                                    <div class="verification-item">
                                        <strong><i class="fas fa-id-card"></i> Cédula de Identidad:</strong>
                                        <span>${data.data.ci || 'N/A'}</span>
                                    </div>
                                    <div class="verification-item">
                                        <strong><i class="fas fa-user"></i> Nombre Completo:</strong>
                                        <span>${data.data.name || 'N/A'}</span>
                                    </div>
                                    <div class="verification-item">
                                        <strong><i class="fas fa-file-alt"></i> Tipo de Documento:</strong>
                                        <span>${data.data.document_type}</span>
                                    </div>
                                    <div class="verification-item">
                                        <strong><i class="fas fa-calendar-plus"></i> Fecha de Generación:</strong>
                                        <span>${data.data.generated_at}</span>
                                    </div>
                                    <div class="verification-item">
                                        <strong><i class="fas fa-check-circle"></i> Estado del Documento:</strong>
                                        <span class="text-success">${data.data.document_status}</span>
                                    </div>
                                    <div class="verification-item">
                                        <strong><i class="fas fa-clock"></i> Hora de Verificación:</strong>
                                        <span>${data.data.verification_time}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    resultContent.innerHTML = content;
                    showToast('Documento verificado exitosamente', 'success');
                } else {
                    result.className = 'result error';
                    resultContent.innerHTML = `
                        <div class="text-center" style="margin-bottom: 2rem;">
                            <div class="status-badge status-invalid">
                                <i class="fas fa-times-circle"></i> DOCUMENTO NO VÁLIDO
                            </div>
                        </div>
                        <div class="text-center" style="margin-bottom: 2rem;">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger" style="margin-bottom: 1rem;"></i>
                            <h4 class="text-danger">❌ ${data.message}</h4>
                        </div>
                        <div class="text-center">
                            <p style="margin-bottom: 1rem;">El documento no pudo ser verificado. Posibles causas:</p>
                            <ul style="text-align: left; display: inline-block; margin-bottom: 1rem;">
                                <li>Código QR inválido o corrupto</li>
                                <li>Documento no registrado en el sistema</li>
                                <li>Documento desactivado por nueva información</li>
                                <li>Firma digital inválida</li>
                            </ul>
                            <p class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Si considera que esto es un error, contacte al administrador del sistema.
                            </p>
                        </div>
                    `;
                    showToast('Documento no válido', 'error');
                }
                
                // Scroll to result
                result.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
            } catch (error) {
                loading.style.display = 'none';
                result.style.display = 'block';
                result.className = 'result error';
                resultContent.innerHTML = `
                    <div class="text-center" style="margin-bottom: 2rem;">
                        <div class="status-badge status-invalid">
                            <i class="fas fa-exclamation-triangle"></i> ERROR DEL SISTEMA
                        </div>
                    </div>
                    <div class="text-center" style="margin-bottom: 2rem;">
                        <i class="fas fa-wifi fa-3x text-warning" style="margin-bottom: 1rem;"></i>
                        <h4 class="text-warning">❌ Error de Conexión</h4>
                        <p>No se pudo conectar con el servidor de verificación.</p>
                    </div>
                    <div class="text-center">
                        <p class="text-muted" style="margin-bottom: 1rem;">
                            <i class="fas fa-refresh"></i>
                            Por favor, verifique su conexión a internet e intente nuevamente.
                        </p>
                        <button class="btn btn-primary" onclick="verifyDocument()">
                            <i class="fas fa-redo"></i> Reintentar Verificación
                        </button>
                    </div>
                `;
                console.error('Error:', error);
                showToast('Error de conexión', 'error');
            } finally {
                submitBtn.disabled = false;
            }
        }

        // Utility functions
        function showError(content) {
            const result = document.getElementById('result');
            const resultContent = document.getElementById('resultContent');
            result.className = 'result error';
            resultContent.innerHTML = content;
            result.style.display = 'block';
            result.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-times-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };
            
            toast.innerHTML = `
                <i class="${icons[type] || icons.info}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('removing');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 4000);
        }

        // Toggle manual input function
        function toggleManualInput() {
            const manualInputGroup = document.getElementById('manualInputGroup');
            const button = event.target;
            
            if (manualInputGroup.style.display === 'none') {
                manualInputGroup.style.display = 'block';
                button.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar Entrada Manual';
                button.className = 'btn btn-warning';
                // Focus on textarea for better UX
                setTimeout(() => {
                    document.getElementById('qr_data').focus();
                }, 300);
                showToast('Entrada manual activada', 'info');
            } else {
                manualInputGroup.style.display = 'none';
                button.innerHTML = '<i class="fas fa-keyboard"></i> Entrada Manual';
                button.className = 'btn btn-secondary';
                showToast('Entrada manual oculta', 'info');
            }
        }

        // Clear form function
        function clearForm() {
            document.getElementById('qr_data').value = '';
            document.getElementById('qr_data').style.height = 'auto';
            document.getElementById('result').style.display = 'none';
            if (scannerActive) {
                toggleScanner();
            }
            showToast('Formulario limpiado', 'info');
        }

        // Load sample data function
        function loadSampleData() {
            const daciId = "DACI-" + Math.floor(Math.random() * 999999).toString().padStart(6, '0');
            const sampleData = {
                id: daciId,
                ci: "1234567",
                name: "Juan Pérez García",
                ts: new Date().toISOString().slice(0, 19).replace('T', ' '),
                sig: "abc123def456ghi789jkl012mno345pqr678stu901vwx234yz",
                hash: "xy789zab123cde456fgh789ijk012lmn345opq678rst901uvw"
            };
            
            const textarea = document.getElementById('qr_data');
            textarea.value = JSON.stringify(sampleData, null, 2);
            textarea.style.height = 'auto';
            textarea.style.height = Math.max(textarea.scrollHeight, 120) + 'px';
            showToast('Datos de prueba cargados', 'info');
        }

        // Keyboard shortcuts
        document.getElementById('qr_data').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.ctrlKey) {
                e.preventDefault();
                verifyDocument();
            }
        });

        // Auto-resize textarea
        document.getElementById('qr_data').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.max(this.scrollHeight, 120) + 'px';
        });

        // Clear results when typing
        document.getElementById('qr_data').addEventListener('input', function() {
            if (this.value.trim() === '') {
                document.getElementById('result').style.display = 'none';
            }
        });

        // Detect and format JSON on paste
        document.getElementById('qr_data').addEventListener('paste', function(e) {
            setTimeout(function() {
                const content = e.target.value.trim();
                if (content.startsWith('http') || content.startsWith('https')) {
                    return;
                }
                try {
                    const parsed = JSON.parse(content);
                    e.target.value = JSON.stringify(parsed, null, 2);
                    e.target.style.height = 'auto';
                    e.target.style.height = Math.max(e.target.scrollHeight, 120) + 'px';
                } catch (err) {
                    // Not valid JSON, leave as is
                }
            }, 100);
        });

        // Handle visibility change to stop scanner when tab is not active
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && scannerActive) {
                stopScanner();
                document.getElementById('reader').style.display = 'none';
                resetScannerButton();
            }
        });

        // Detect mobile device
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        // Mobile optimizations
        if (isMobile()) {
            document.addEventListener('DOMContentLoaded', function() {
                // Add haptic feedback for buttons (if supported)
                document.querySelectorAll('.btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (navigator.vibrate) {
                            navigator.vibrate(50);
                        }
                    });
                });
            });
        }

        // Error handling for unhandled promises
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled promise rejection:', event.reason);
            showToast('Error inesperado del sistema', 'error');
        });

        // Initialize app
        document.addEventListener('DOMContentLoaded', function() {
            showToast('Sistema de verificación DACI cargado', 'success');
            
            // Si viene con datos QR, mostrar entrada manual automáticamente
            @if($qrData)
            const manualInputGroup = document.getElementById('manualInputGroup');
            manualInputGroup.style.display = 'block';
            const manualButton = document.querySelector('button[onclick="toggleManualInput()"]');
            if (manualButton) {
                manualButton.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar Entrada Manual';
                manualButton.className = 'btn btn-warning';
            }
            @else
            // Focus en el escáner para mejor UX si no hay auto-verificación
            setTimeout(() => {
                showToast('Use el escáner de cámara o active la entrada manual', 'info');
            }, 1500);
            @endif
        });
    </script>
</body>
</html>