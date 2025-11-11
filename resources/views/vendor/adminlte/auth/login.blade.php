@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
    <style>
        /* Variables CSS optimizadas */
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --accent-hover: #2980b9;
            --success: #27ae60;
            --danger: #e74c3c;
            --warning: #f39c12;
            --white: #ffffff;
            --light: #ecf0f1;
            --dark: #34495e;
            --border: #bdc3c7;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --radius: 8px;
        }

        /* Body optimizado */
        body {
            background: linear-gradient(135deg, var(--primary), var(--dark)) !important;
            color: var(--white) !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        /* Login box */
        .login-box {
            width: 100%;
            max-width: 400px;
            margin: 2rem auto;
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        /* Card */
        .card {
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: none;
        }

        .card-header {
            background: var(--accent) !important;
            color: var(--white) !important;
            padding: 1.5rem;
            text-align: center;
            border-bottom: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
            background: var(--white);
            color: var(--dark);
        }

        /* Alertas */
        .alert {
            border-radius: var(--radius);
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Inputs */
        .form-control {
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 0.75rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background: var(--light);
            border: 2px solid var(--border);
            border-left: none;
            color: var(--dark);
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--accent);
            background: rgba(52, 152, 219, 0.1);
        }

        /* Checkbox */
        .icheck-primary input[type="checkbox"]:checked + label::before {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .icheck-primary label {
            color: var(--white) !important;
            font-weight: 500;
        }

        /* Botón */
        .btn-primary {
            background: var(--accent);
            border: none;
            border-radius: var(--radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Modal */
        .contact-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 1rem;
        }

        .contact-modal.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .contact-content {
            background: var(--white);
            border-radius: var(--radius);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            color: var(--dark);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .contact-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
        }

        .contact-info {
            background: var(--light);
            padding: 1.5rem;
            border-radius: var(--radius);
            margin: 1rem 0;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-item i {
            width: 24px;
            margin-right: 1rem;
            color: var(--accent);
        }

        .contact-item a {
            color: var(--accent);
            text-decoration: none;
        }

        .contact-item a:hover {
            text-decoration: underline;
        }

        /* Botones del modal */
        .modal-actions {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .btn-close-modal, .btn-contact {
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            margin: 0 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-close-modal {
            background: var(--light);
            color: var(--dark);
        }

        .btn-close-modal:hover {
            background: var(--border);
        }

        .btn-contact {
            background: var(--accent);
            color: var(--white);
        }

        .btn-contact:hover {
            background: var(--accent-hover);
        }

        /* Mensaje del servidor */
        .server-time-message {
            animation: pulse 2s infinite;
            font-weight: bold !important;
        }

        @keyframes pulse {
            0%, 100% { 
                opacity: 1; 
                transform: scale(1);
            }
            50% { 
                opacity: 0.8; 
                transform: scale(1.02);
            }
        }

        /* Estados de carga */
        .btn-loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-box {
                margin: 1rem;
                max-width: none;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .contact-content {
                padding: 1.5rem;
                margin: 1rem;
            }
        }
    </style>
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
@endif

@section('auth_header')
    <div class="text-center mb-3">
        <i class="fas fa-shield-alt fa-2x text-white mb-2"></i>
        <h4 class="text-white font-weight-bold">{{ config('app.name', 'CRIMANAGER') }}</h4>
        <p class="text-light">Acceso Seguro al Sistema</p>
    </div>
@stop

@section('auth_body')
    <!-- Meta tag para CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Alertas del servidor -->
    @if(session('error'))
        <div class="alert alert-danger server-error-alert" id="server-error" data-error="{{ session('error') }}">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger server-error-alert" data-error="{{ $error }}">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ $error }}
            </div>
        @endforeach
    @endif

    <!-- Formulario de login -->
    <form action="{{ $login_url }}" method="post" id="loginForm" novalidate>
        @csrf

        <!-- Email -->
        <div class="input-group">
            <input type="email" 
                   name="email" 
                   id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" 
                   placeholder="Correo Electrónico"
                   autofocus 
                   autocomplete="email"
                   required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group">
            <input type="password" 
                   name="password" 
                   id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Contraseña"
                   autocomplete="current-password"
                   required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember me y botón -->
        <div class="row align-items-center">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Recordarme</label>
                </div>
            </div>

            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Ingresar
                </button>
            </div>
        </div>

        <!-- Información de intentos -->
        <div id="attempts-info" class="text-center mt-3" style="display: none;">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                <span id="attempts-text"></span>
            </small>
        </div>
    </form>

    <!-- Modal de contacto -->
    <div id="contactModal" class="contact-modal">
        <div class="contact-content">
            <!-- Contenido dinámico -->
        </div>
    </div>
@stop

@section('adminlte_js')
    <script>
        // Sistema de login optimizado
        class LoginSystem {
            constructor() {
                this.form = document.getElementById('loginForm');
                this.emailInput = document.getElementById('email');
                this.passwordInput = document.getElementById('password');
                this.loginBtn = document.getElementById('loginBtn');
                this.serverError = document.getElementById('server-error');
                this.attemptsInfo = document.getElementById('attempts-info');
                this.attemptsText = document.getElementById('attempts-text');
                
                this.maxAttempts = 5;
                this.init();
            }

            init() {
                this.checkServerError();
                this.setupEventListeners();
                this.checkExistingBlock();
            }

            setupEventListeners() {
                this.form.addEventListener('submit', (e) => this.handleSubmit(e));
                [this.emailInput, this.passwordInput].forEach(input => {
                    input.addEventListener('input', () => this.validateForm());
                });
            }

            validateForm() {
                const email = this.emailInput.value.trim();
                const password = this.passwordInput.value;
                const isValid = email.includes('@') && password.length >= 3;
                this.loginBtn.disabled = !isValid;
            }

            checkServerError() {
                const errorElements = document.querySelectorAll('.alert-danger, .server-error-alert');
                
                let errorText = '';
                let errorElement = null;
                let blockTimeMessage = '';
                
                if (this.serverError) {
                    errorText = this.serverError.dataset.error.toLowerCase();
                    errorElement = this.serverError;
                }
                
                errorElements.forEach(element => {
                    const text = element.textContent.toLowerCase();
                    
                    if (text.includes('está inactiva') || 
                        text.includes('contacta al administrador')) {
                        errorText = text;
                        errorElement = element;
                    }
                    else if (text.includes('demasiados intentos') || 
                        text.includes('bloqueada temporalmente')) {
                        errorText = text;
                        errorElement = element;
                        blockTimeMessage = this.extractTimeFromMessage(element.textContent);
                    }
                });
                
                if (errorText && errorElement) {
                    errorElement.style.display = 'none';
                    
                    if (this.isCredentialError(errorText)) {
                        this.recordFailedAttempt();
                    } else if (this.isAccountInactive(errorText)) {
                        this.showContactModal('inactiva');
                    } else if (this.isAccountBlocked(errorText)) {
                        this.showContactModal('bloqueada', blockTimeMessage);
                        this.disableForm();
                    }
                }
            }

            extractTimeFromMessage(message) {
                const patterns = [
                    /(\d+)\s*minutos?\s*y\s*(\d+)\s*segundos?/i,
                    /(\d+)\s*minutos?/i,
                    /(\d+)\s*segundos?/i
                ];
                
                for (let pattern of patterns) {
                    const match = message.match(pattern);
                    if (match) {
                        if (pattern.source.includes('y')) {
                            return `${match[1]} minutos y ${match[2]} segundos`;
                        } else if (pattern.source.includes('minutos')) {
                            return `${match[1]} minutos`;
                        } else {
                            return `${match[1]} segundos`;
                        }
                    }
                }
                return 'unos minutos';
            }

            isCredentialError(text) {
                return ['credenciales', 'incorrectas', 'invalid', 'wrong'].some(word => 
                    text.includes(word)
                );
            }

            isAccountInactive(text) {
                return ['inactiva', 'inactive', 'contacta al administrador'].some(word => 
                    text.includes(word)
                );
            }

            isAccountBlocked(text) {
                return ['demasiados intentos', 'bloqueada temporalmente'].some(word => 
                    text.includes(word)
                );
            }

            recordFailedAttempt() {
                const attempts = this.getFailedAttempts();
                const now = Date.now();
                
                attempts.push(now);
                localStorage.setItem('failedAttempts', JSON.stringify(attempts));
                
                this.updateAttemptsDisplay();
                
                if (attempts.length >= this.maxAttempts) {
                    this.blockAccount();
                }
            }

            getFailedAttempts() {
                const attempts = JSON.parse(localStorage.getItem('failedAttempts') || '[]');
                const cutoff = Date.now() - (15 * 60 * 1000);
                return attempts.filter(time => time > cutoff);
            }

            updateAttemptsDisplay() {
                const attempts = this.getFailedAttempts();
                const remaining = this.maxAttempts - attempts.length;
                
                if (attempts.length > 0 && remaining > 0) {
                    this.attemptsText.textContent = `Credenciales incorrectas. Te ${remaining === 1 ? 'queda' : 'quedan'} ${remaining} intento${remaining === 1 ? '' : 's'} más`;
                    this.attemptsInfo.style.display = 'block';
                    this.attemptsInfo.style.color = remaining <= 2 ? '#e74c3c' : '#f39c12';
                } else {
                    this.attemptsInfo.style.display = 'none';
                }
            }

            blockAccount() {
                const blockUntil = Date.now() + (15 * 60 * 1000);
                localStorage.setItem('blockedUntil', blockUntil.toString());
                localStorage.setItem('blockedEmail', this.emailInput.value);
                this.showContactModal('bloqueada', '15 minutos');
                this.disableForm();
            }

            checkExistingBlock() {
                const blockedUntil = localStorage.getItem('blockedUntil');
                const blockedEmail = localStorage.getItem('blockedEmail');
                const userEmail = this.emailInput.value;
                
                if (blockedUntil && Date.now() < parseInt(blockedUntil)) {
                    if (!blockedEmail || !userEmail || blockedEmail === userEmail) {
                        const remainingMinutes = Math.ceil((parseInt(blockedUntil) - Date.now()) / 1000 / 60);
                        this.showContactModal('bloqueada', `${remainingMinutes} minutos`);
                        this.disableForm();
                        return true;
                    }
                } else if (blockedUntil) {
                    this.clearBlockData();
                }
                
                this.updateAttemptsDisplay();
                return false;
            }

            clearBlockData() {
                localStorage.removeItem('blockedUntil');
                localStorage.removeItem('blockedEmail');
                localStorage.removeItem('failedAttempts');
            }

            disableForm() {
                [this.emailInput, this.passwordInput].forEach(input => {
                    input.disabled = true;
                });
                this.loginBtn.disabled = true;
                this.loginBtn.innerHTML = '<i class="fas fa-lock me-1"></i> Bloqueado';
                this.loginBtn.style.background = '#e74c3c';
            }

            showContactModal(type, timeMessage = null) {
                const modal = document.getElementById('contactModal');
                const modalContent = modal.querySelector('.contact-content');
                
                let headerIcon, headerTitle, headerText, subject, body;
                
                if (type === 'bloqueada') {
                    headerIcon = 'fas fa-user-lock fa-2x text-danger mb-2';
                    headerTitle = 'Cuenta Temporalmente Bloqueada';
                    headerText = 'Su cuenta ha sido bloqueada por seguridad, debido a múltiples intentos fallidos.';
                    subject = 'Cuenta Bloqueada - Solicitud de Ayuda';
                    body = 'Mi cuenta ha sido bloqueada y necesito ayuda para acceder.';
                } else {
                    headerIcon = 'fas fa-user-times fa-2x text-warning mb-2';
                    headerTitle = 'Cuenta Inhabilitada';
                    headerText = 'Su cuenta fue desactivada. Si considera que esto es un error, contacte al administrador del sistema para solicitar la reactivación.';
                    subject = 'Cuenta Inhabilitada - Solicitud de Reactivación';
                    body = 'Mi cuenta está inhabilitada y solicito su reactivación.';
                }
                
                modalContent.innerHTML = `
                    <div class="contact-header">
                        <i class="${headerIcon}"></i>
                        <h4>${headerTitle}</h4>
                        <p class="mb-0">${headerText}</p>
                    </div>

                    <div class="contact-info">

                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Teléfono:</strong><br>
                                <a href="tel:+59112345678">+591 1234-5678</a>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Horario:</strong><br>
                                Lunes a Viernes: 8:00 AM - 6:00 PM
                            </div>
                        </div>
                        
                        ${type === 'bloqueada' && timeMessage ? `
                            <div class="contact-item">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                <div>
                                    <strong>⚠️ Tiempo de Bloqueo:</strong><br>
                                    <div class="server-time-message mt-2 p-2 bg-danger text-white rounded text-center">
                                        <strong>Intente nuevamente en: ${timeMessage} </strong>
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-close-modal" onclick="closeContactModal()">
                            ${type === 'bloqueada' ? 'Entendido' : 'Cerrar'}
                        </button>
                    </div>
                `;
                
                modal.classList.add('show');
            }

            handleSubmit(e) {
                if (this.getFailedAttempts().length >= this.maxAttempts) {
                    e.preventDefault();
                    this.showContactModal('bloqueada', '15 minutos');
                    this.disableForm();
                    return false;
                }

                this.loginBtn.classList.add('btn-loading');
                this.loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Verificando...';
                return true;
            }
        }

        // Funciones globales
        function closeContactModal() {
            document.getElementById('contactModal').classList.remove('show');
        }

        function sendEmail() {
            document.getElementById('emailContact').click();
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            new LoginSystem();
        });
    </script>
@stop