@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
<div class="class text-center">
    <h1>REGISTRAR VEHICULOS USADOS POR EL DELINCUENTE</h1>
</div>
    
@stop
@section('content')
    <div class="container">
        <div class="grid grid-cols-2 gap-10">
            <div>
                <div class="class text-center">Llenar los siguientes datos</div>
                <form>
                    <label>SOBRE EL VEHICULO</label>
                    <div class="form-group">
                        <label for="inputAddress2">Tipo de Vehiculo:</label>
                        <select class="form-control" id="inputAddress2">
                            <option value="">Vagoneta</option>
                            <option value="soltero">Camioneta</option>
                            <option value="casado">Jepp</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputnames">Numero de PLaca</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Ingrese Numero de PLanca">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">ITV</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Numero ITV">
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="form-group">
                            <label for="inputAddress2">Marca</label>
                            <select class="form-control" id="inputAddress2">
                                <option value="">Toyota</option>
                                <option value="soltero">Negro</option>
                                <option value="casado">Rojo</option>
                                <option value="viudo">Azul</option>
                                <option value="divorciado">Plomo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Modelo</label>
                            <input type="text" class="form-control" id="inputAddress2" placeholder="Modelo">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="form-group">
                            <label>Año de Fabricacion:</label>
                            <input type="number" class="form-control" id="inputAddress" placeholder="Año" min="1950" max="2050">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Color</label>
                            <select class="form-control" id="inputAddress2">
                                <option value="">Blanco</option>
                                <option value="soltero">Negro</option>
                                <option value="casado">Rojo</option>
                                <option value="viudo">Azul</option>
                                <option value="divorciado">Plomo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Industria</label>
                        <select class="form-control" id="inputAddress2">
                            <option value="">Estados Unidos</option>
                            <option value="soltero">Japon</option>
                            <option value="casado">Brasil</option>
                            <option value="viudo">Azul</option>
                            <option value="divorciado">Plomo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Detalles del Vehiculo:</label>
                        <input type="text" class="form-control" id="inputAddress"
                            placeholder="Descripccion de detalles">
                    </div>
                    <label for="inputAddress2">DATOS DEL PROPIETARIO:</label>
                    <div class="form-group">
                        <label for="inputAddress2">Nombre del Propietario:</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Nombres y Apellido">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">CI. del Propietario:</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Ingrese CI/DNI">
                    </div>
                    <div class="form-group">
                        <label for="inputnames">Relacion con el delincuente</label>
                        <select class="form-control" id="inputAddress2">
                            <option value="">Padre</option>
                            <option value="soltero">Madre</option>
                            <option value="casado">Esposa</option>
                            <option value="viudo">Hermano</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="inputAddress2">Otras Observaciones</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Descripcion">
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">GUARDAR</button>
                    </div>
                </form>
            </div>
            <div>
                <form>
                </form>
            </div>
        </div>
    </div>
@stop
