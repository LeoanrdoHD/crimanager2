@extends('adminlte::page')

@section('content')
    <div class="card"
        style="
        width: 100%;
        min-height: calc(100vh - 60px);
        display: flex;
        justify-content: flex-end; /* Alinea el contenido a la derecha */
        align-items: center; /* Centra verticalmente */
        overflow: hidden;
        border-radius: 15px;
        background: rgba(0, 0, 0, 0.8); /* Fondo más oscuro */
        padding: 15px;
        position: relative;
    ">
        <!-- Imagen de fondo con animación -->
        <div class="background-animation"
            style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('storage/FONDO.png') }}') no-repeat center center;
            background-size: cover;
            animation: fadeBlur 6s infinite alternate, scale 8s infinite ease-in-out;
            border-radius: 15px;
            filter: brightness(0.7); /* Oscurecer la imagen */
        ">
        </div>
        <!-- Destellos de la estrella -->
        <div class="star-flare"
            style="
 position: absolute;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 background: radial-gradient(
     circle at 0% 50%,
     rgba(255, 255, 255, 0.5) 0%,
     rgba(255, 255, 255, 0) 50% /* Radio más pequeño */
 );
 animation: flare 6s infinite ease-in-out; /* Destellos más lentos */
 opacity: 0;
 border-radius: 15px;
">
        </div>
        <!-- Contenedor del mensaje -->
        <div class="user-welcome">
            <h3>BIENVENIDO A: CRIMANAGER-DACI</h3>
            <h3>Usuario: {{ Auth::user()->name }}</h3>
        </div>

        <!-- Contenedor de botones -->
        <div class="botonnes">
            @can('agregar.criminal')<a href="{{ url('criminals') }}" class="btn btn-custom-white">Registrar Nuevo</a>@endcan
            <a href="{{ url('criminals/search_cri') }}" class="btn btn-custom-black">Buscar Registros</a>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center mt-3" style="color: white; font-size: 14px;">
        © <span id="currentYear"></span> LDH84.
    </div>

    <!-- Animaciones con CSS -->
    <style>
        /* Animación de escalado */
        @keyframes scale {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Animación de destellos */
        @keyframes flare {
            0% {
                opacity: 0;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }

            100% {
                opacity: 0;
                transform: scale(1);
            }
        }

        /* Estilos para el mensaje de bienvenida */
        .user-welcome {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            text-align: right;
            z-index: 2;
        }

        /* Estilos para el contenedor de botones */
        .botonnes {
            position: absolute;
            top: 50%;
            /* Centra verticalmente */
            right: 50px;
            /* Margen a la derecha en pantallas grandes */
            transform: translateY(-50%);
            display: flex;
            flex-direction: row; /* Botones uno al lado del otro */
            /* Asegura que los botones estén uno debajo del otro */
            align-items: center;
            gap: 20px;
            z-index: 2;
        }

        /* Estilos específicos para móviles */
        @media (max-width: 768px) {
            .user-welcome {
                top: 10%;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
                width: 90%;
                background: rgba(0, 0, 0, 0.6);
                padding: 15px;
                border-radius: 10px;
            }

            .botonnes {
                position: absolute;
                top: 60%;
                /* Ajusta la posición vertical */
                left: 50%;
                transform: translate(-50%, -50%);
                display: flex;
                flex-direction: column;
                /* Mantiene los botones en columna */
                align-items: center;
                /* Centra horizontalmente */
                width: 100%;
                /* Se extiende en todo el ancho */
                padding: 20px;
            }

            .botonnes a {
                width: 80%;
                /* Botones más grandes en móviles */
                text-align: center;
            }
        }

        /* Estilos personalizados para los botones */
        .btn-custom-white {
            background-color: white;
            color: black;
            border: 1px solid #ccc;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: block;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-custom-white:hover {
            background-color: #f0f0f090;
            color: rgb(12, 12, 12);
        }

        .btn-custom-black {
            background-color: black;
            color: white;
            border: 1px solid #727171;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: block;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-custom-black:hover {
            background-color: #333;
            color: white;
        }
    </style>

    <!-- Script para actualizar el año automáticamente -->
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
@stop
