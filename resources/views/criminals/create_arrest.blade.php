@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <h1>REGISTRAR SOBRE SU ARRESTO</h1>
@stop
@section('content')
    <div class="container">
        <div class="class text-center">Llenar los siguientes datos</div>
        <form class="form-arrest" action="/criminals" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-10">
                <div>
                    <label>SELECCIONE UN DELINCUENTE</label>
                    <div class="form-group">
                        <label >Nombres y apellido:</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Ingrese el nombre">
                    </div>
                    <div class="form-group">
                        <label>Cedula de Identidad/DNI:</label>
                        <input type="text" class="form-control" name="identity_number" placeholder="Ingrese los apellidos">
                    </div>
                    <div class="form-group">
                        <label >Situacion Legal:</label>
                        <select class="form-control" name="situacion_legal">
                            <option value="slegal1">Aprehendido</option>
                        </select>
                    </div>
                    <div>
                        <label >Tipo de Aprehencion::</label>
                        <select class="form-control" name="type_aprencion">
                            <option value="slegal1">Orden Judicial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Nuemro de CUD:</label>
                        <input type="text" class="form-control" name="n_cud" placeholder="Ingrese EL CUD">
                    </div>
                    <div class="form-group">
                        <label >Fecha de Captura:</label>
                        <input type="date" class="form-control" name="fecha_captura" placeholder="dia/mes/año">
                    </div>
                    <div class="form-group">
                        <label >Hora de Captura:</label>
                        <input type="time" class="form-control" name="hora_captura" placeholder="dia/mes/año">
                    </div>
                    <div class="form-group">
                        <label >Lugar de Captura:</label>
                        <input type="text" class="form-control" name="lugar_captura" placeholder="Ingrese la Direccion">
                    </div>
                    <div class="form-group">
                        <label >Detalle de la Captura:</label>
                        <input type="text" class="form-control" name="detalle_captura" placeholder="Breve descripccion">
                    </div>
                    <div class="form-group">
                        <label>Especialidad/Motivo de captura</label>
                        <select class="form-control" name="especiality">
                            <option value="robo">Robo</option>
                        </select>
                    </div>
                    <label>TELEFONOS QUE UTILIZA</label>
                    <div class="form-group">
                        <label >Numero de Celular:</label>
                        <input type="text" class="form-control" name="cel_number" placeholder="Ingrese el numero de celular">
                    </div>
                    <div class="form-group">
                        <label >Compañia Telefonica</label>
                        <select class="form-control" name="companie_cel">
                            <option value="">Entel</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label>OTRAS IDENTIDADES</label>
                    <div class="form-group">
                        <label>Otros Nombre::</label>
                        <input type="text" class="form-control" name="otthers_nombres" placeholder="Nombre y Apellidos">
                    </div>
                    <div class="form-group">
                        <label>Otros Numeros de Identidad::</label>
                        <input type="text" class="form-control" name="others_ci" placeholder="Ingresar CI/DNI">
                    </div>
                    <div class="form-group">
                        <label>Otras Nacionalidades:</label>
                        <select class="form-control" name="others_natuonality">
                            <option value="">Bolivia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Otros Direcciones de Residencia:</label>
                        <input type="text" class="form-control" name="others_direcction" placeholder="Ingresar Direccion">
                    </div>
                    <label>Lugar de recidencia:</label>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="form-group">
                            <select class="form-control" name="others_city">
                                <option value="">Ciudad</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="other_pais">
                                <option value="">Pais</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Apodo/Chapa</label>
                        <input type="text" class="form-control" name="apodo" placeholder="Ingrese su Apodo">
                    </div>
                    <label>OBJETOS/ARMAS/HERRAMIENTAS</label>
                    <div class="form-group">
                        <label >Tipo:</label>
                        <select class="form-control" name="type_arms">
                            <option value="">Arma de Fuego</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Detalles del Objeto, Arma o Herramienta:</label>
                        <input type="text" class="form-control" name="detail_arms"
                            placeholder="Ingrese la direccion">
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-primary" type="submit">GUARDAR</button>
            </div>
        </form>
    </div>
@stop
