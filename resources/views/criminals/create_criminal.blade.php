@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #333 inset !important;
            /* Color de fondo oscuro */
            -webkit-text-fill-color: #fff !important;
            /* Color del texto */
            border: 1px solid #555;
            /* Asegurar que se mantenga un borde consistente */
        }

        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #444 inset !important;
            /* Color de fondo al hover o focus */
            -webkit-text-fill-color: #fff !important;
        }

        .custom-file-label::after {
            content: "Archivo";
        }

        .center-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }
    </style>
    <h1 class="class text-center">REGISTRO DE NUEVO DELINCUENTE</h1>
@stop
@section('content')

    @if (session('error'))
        <div id="errorAlert" class="alert alert-danger" style="color: rgb(225, 215, 215);">
            {{ session('error') }}
        </div>
    @endif
    <script>
        // Ocultar el mensaje de error después de 5 segundos
        setTimeout(function() {
            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 5000);
    </script>
    @include('criminals.partials.section0_perfil')
@endsection
