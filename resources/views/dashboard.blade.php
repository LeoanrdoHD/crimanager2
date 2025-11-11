@extends('adminlte::page')

@section('content')
    <div class="card dashboard-card">
        <!-- Imagen de fondo optimizada con lazy loading -->
        <div class="background-animation" data-bg="{{ asset('storage/FONDO.png') }}"></div>
        
        <!-- Destellos de la estrella -->
        <div class="star-flare"></div>
        
        <!-- Contenedor del mensaje -->
        <div class="user-welcome">
            <h3>BIENVENIDO A: CRIMANAGER-DACI</h3>
            <h3>Usuario: {{ Auth::user()->name }}</h3>
        </div>

        <!-- Contenedor de botones -->
        <div class="botonnes">
            @can('agregar.criminal')
                <a href="{{ url('criminals') }}" class="btn btn-custom-white">Registrar Nuevo</a>
            @endcan
            <a href="{{ url('criminals/search_cri') }}" class="btn btn-custom-black">Buscar Registros</a>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center mt-3 copyright">
        © <span id="currentYear"></span> LDH84.
    </div>

    <!-- Estilos optimizados -->
    <style>
        /* Variables CSS para mejor rendimiento */
        :root {
            --bg-dark: rgba(0, 0, 0, 0.8);
            --bg-semi: rgba(0, 0, 0, 0.5);
            --bg-semi-mobile: rgba(0, 0, 0, 0.6);
            --white: #ffffff;
            --black: #000000;
            --gray: #333333;
            --border-gray: #727171;
            --border-light: #cccccc;
            --transition: 0.3s ease;
            --radius: 15px;
            --radius-small: 10px;
            --radius-btn: 5px;
        }

        /* Estilos principales optimizados */
        .dashboard-card {
            width: 100%;
            min-height: calc(100vh - 60px);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            overflow: hidden;
            border-radius: var(--radius);
            background: var(--bg-dark);
            padding: 15px;
            position: relative;
            /* Optimización para GPU */
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        /* Imagen de fondo optimizada */
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: var(--radius);
            filter: brightness(0.7);
            /* Optimizaciones de GPU */
            will-change: transform, opacity;
            transform: translateZ(0);
            /* Usar transform en lugar de background para mejor rendimiento */
            background-color: #1a1a1a; /* Fallback mientras carga */
        }

        /* Cargar imagen de fondo de forma optimizada */
        .background-animation.loaded {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            /* Animaciones más suaves y eficientes */
            animation: fadeBlur 6s infinite alternate ease-in-out, 
                      scale 8s infinite ease-in-out;
        }

        /* Animaciones optimizadas usando transform */
        @keyframes scale {
            0%, 100% {
                transform: translateZ(0) scale(1);
            }
            50% {
                transform: translateZ(0) scale(1.02); /* Reducido para mejor rendimiento */
            }
        }

        @keyframes fadeBlur {
            0% {
                filter: brightness(0.7) blur(0px);
                opacity: 1;
            }
            100% {
                filter: brightness(0.6) blur(1px);
                opacity: 0.9;
            }
        }

        /* Destellos optimizados */
        .star-flare {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(
                circle at 0% 50%,
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0) 40%
            );
            animation: flare 6s infinite ease-in-out;
            opacity: 0;
            border-radius: var(--radius);
            will-change: opacity, transform;
            transform: translateZ(0);
        }

        @keyframes flare {
            0%, 100% {
                opacity: 0;
                transform: translateZ(0) scale(1);
            }
            50% {
                opacity: 0.8;
                transform: translateZ(0) scale(1.1);
            }
        }

        /* Mensaje de bienvenida optimizado */
        .user-welcome {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--bg-semi);
            padding: 10px 20px;
            border-radius: var(--radius-small);
            color: var(--white);
            font-weight: bold;
            text-align: right;
            z-index: 2;
            /* Optimización de renderizado */
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        .user-welcome h3 {
            margin: 5px 0;
            font-size: 1rem;
        }

        /* Contenedor de botones optimizado */
        .botonnes {
            position: absolute;
            top: 50%;
            right: 50px;
            transform: translateY(-50%) translateZ(0);
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 20px;
            z-index: 2;
        }

        /* Botones optimizados */
        .btn-custom-white,
        .btn-custom-black {
            padding: 12px 25px;
            border-radius: var(--radius-btn);
            text-decoration: none;
            transition: all var(--transition);
            display: block;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            border: 1px solid;
            /* Optimizaciones de GPU */
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: background-color, transform;
        }

        .btn-custom-white {
            background-color: var(--white);
            color: var(--black);
            border-color: var(--border-light);
        }

        .btn-custom-white:hover {
            background-color: rgba(240, 240, 240, 0.9);
            color: var(--black);
            transform: translateZ(0) translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-custom-black {
            background-color: var(--black);
            color: var(--white);
            border-color: var(--border-gray);
        }

        .btn-custom-black:hover {
            background-color: var(--gray);
            color: var(--white);
            transform: translateZ(0) translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
        }

        /* Copyright optimizado */
        .copyright {
            color: var(--white);
            font-size: 14px;
            transform: translateZ(0);
        }

        /* Media queries optimizadas */
        @media (max-width: 768px) {
            .user-welcome {
                top: 10%;
                left: 50%;
                right: auto;
                transform: translateX(-50%) translateZ(0);
                text-align: center;
                width: 90%;
                background: var(--bg-semi-mobile);
                padding: 15px;
            }

            .user-welcome h3 {
                font-size: 0.9rem;
                margin: 3px 0;
            }

            .botonnes {
                top: 60%;
                left: 50%;
                right: auto;
                transform: translate(-50%, -50%) translateZ(0);
                flex-direction: column;
                align-items: center;
                width: 100%;
                padding: 20px;
                gap: 15px;
            }

            .btn-custom-white,
            .btn-custom-black {
                width: 80%;
                font-size: 15px;
                padding: 15px 20px;
            }
        }

        /* Optimización para pantallas de alta densidad */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .background-animation {
                /* Usar imagen de mayor resolución si está disponible */
                background-image: url('{{ asset('storage/FONDO@2x.png') }}'), 
                                url('{{ asset('storage/FONDO.png') }}');
            }
        }

        /* Reducir animaciones para usuarios que prefieren menos movimiento */
        @media (prefers-reduced-motion: reduce) {
            .background-animation {
                animation: none;
            }
            
            .star-flare {
                animation: none;
                opacity: 0.5;
            }
            
            .btn-custom-white:hover,
            .btn-custom-black:hover {
                transform: translateZ(0);
            }
        }
    </style>

    <!-- Script optimizado -->
    <script>
        // Función optimizada para cargar imagen de fondo
        function loadBackgroundImage() {
            const bgElement = document.querySelector('.background-animation');
            const bgUrl = bgElement.dataset.bg;
            
            // Crear imagen en memoria para precargar
            const img = new Image();
            img.onload = function() {
                // Aplicar imagen solo cuando esté completamente cargada
                bgElement.style.backgroundImage = `url(${bgUrl})`;
                bgElement.classList.add('loaded');
            };
            img.onerror = function() {
                // Fallback en caso de error
                bgElement.style.backgroundColor = '#2c3e50';
                bgElement.classList.add('loaded');
            };
            img.src = bgUrl;
        }

        // Función optimizada para actualizar año
        function updateYear() {
            const yearElement = document.getElementById('currentYear');
            if (yearElement) {
                yearElement.textContent = new Date().getFullYear();
            }
        }

        // Usar requestAnimationFrame para mejor rendimiento
        function initializeDashboard() {
            requestAnimationFrame(() => {
                updateYear();
                loadBackgroundImage();
            });
        }

        // Cargar solo cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeDashboard);
        } else {
            initializeDashboard();
        }

        // Optimización adicional: pausar animaciones cuando la pestaña no está visible
        document.addEventListener('visibilitychange', function() {
            const animations = document.querySelectorAll('.background-animation, .star-flare');
            animations.forEach(element => {
                if (document.hidden) {
                    element.style.animationPlayState = 'paused';
                } else {
                    element.style.animationPlayState = 'running';
                }
            });
        });
    </script>
@stop