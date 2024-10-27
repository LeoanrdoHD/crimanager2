@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <h1>REGISTRAR UN NUEVO DELINCUENTE</h1>
@stop
@section('content')
    <div class="container">
        <div class="class text-center">Llenar los siguientes datos</div>
        <div>
            <form class="form-criminal" action="/criminals" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-10">
                    <div>
                        <label>DATOS GENERALES DE LEY</label>
                        <div class="form-group">
                            <label>Nombres:</label>
                            <input type="text" class="form-control" name="firs_name" placeholder="Ingrese el nombre">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Ingrese los apellidos">
                        </div>
                        <div class="form-group">
                            <label>Cedula de Identidad/DNI:</label>
                            <input type="text" class="form-control" name="identity_number"
                                placeholder="Ingrese el numero de documento">
                        </div>
                        <div class="form-group">
                            <label>Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="data_of_birth" placeholder="dia/mes/año">
                        </div>
                        <div class="form-group">
                            <label>Nacionalidad</label>
                            <select class="form-control" name="nationality_id">
                                <option value="1">BOLIVIA</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Edad:</label>
                            <input type="text" class="form-control" name="age" placeholder="Edad">
                        </div>
                        <div class="form-group">
                            <label>Estado Civil</label>
                            <select class="form-control" name="civil_state_id">
                                <option value="2">Casado</option>
                            </select>
                        </div>
                        <label>Lugar de recidencia:</label>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <select class="form-control" name="city_id">
                                    <option value="3">ORURO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="country">
                                    <option value="4">Mexico</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" name="inputAddress"
                                placeholder="Ingrese la direccion">
                        </div>
                        <div class="form-group">
                            <label>Persona de referencia</label>
                            <input type="text" class="form-control" name="ref_person" placeholder="Nombre y Apellido">
                        </div>
                        <div class="form-group">
                            <label>CI de referencia</label>
                            <input type="text" class="form-control" name="ref_ci" placeholder="Ingrese numero CI/DNI">
                        </div>
                        <div class="form-group">
                            <label>Relacion con el delincuente</label>
                            <select class="form-control" name="relacion_type">
                                <option value="5">Padre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Domicilio de la referencia:</label>
                            <input type="text" class="form-control" name="ref_Address"
                                placeholder="Ingrese la direccion">
                        </div>
                    </div>
                    <div>
                        <label>RASGOS FISICOS</label>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Estatura:</label>
                                <input type="number" class="form-control" name="height" placeholder="Talla" min="120"
                                    max="210">
                            </div>
                            <div class="form-group">
                                <label>Peso:</label>
                                <input type="number" class="form-control" name="weigth" placeholder="Peso" min="35"
                                    max="120">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Conflexion:</label>
                                <input type="text" class="form-control" name="complexion" placeholder="tipo de cuerpo">
                            </div>
                            <div class="form-group">
                                <label>Tez (piel):</label>
                                <select class="form-control" name="skin_color">
                                    <option value="Moreno">Moreno</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Sexo:</label>
                                <select class="form-control" name="sex">
                                    <option value="masculino">Masculino</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Genero:</label>
                                <select class="form-control" name="gender">
                                    <option value="hombre">Hombre</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Tipos de Ojos:</label>
                                <select class="form-control" name="eyes_type">
                                    <option value="Moreno">Moreno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Naris:</label>
                                <select class="form-control" name="nose_type">
                                    <option value="Moreno">Moreno</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Tipo de labios:</label>
                                <select class="form-control" name="lips_type">
                                    <option value="Moreno">Moreno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de orejas:</label>
                                <select class="form-control" name="ears_type">
                                    <option value="Moreno">Moreno</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputnames">Caracteristicas Particulares:</label>
                            <input type="text" class="form-control" name="sennas_particulares"
                                placeholder="Descripccion">
                        </div>
                        <div><label>FOTOGRAFIAS:</label></div>
                        <label>Medio Cuerpo:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="half_body" required>
                            <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                        <label>Perfil Izquierdo:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="left_profile" required>
                            <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                        <label>Perfil Derecho:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="right_profile" required>
                            <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                        <label>Cuerpo Completo:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="full_body" required>
                            <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
@stop
