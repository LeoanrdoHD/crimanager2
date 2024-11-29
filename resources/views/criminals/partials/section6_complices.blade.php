@vite('resources/css/app.css')
<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest6') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
        <div class="class text-center"><label>Complices del Delicuente:</label></div>
        <div class="grid grid-cols-3 gap-5">
            <div class="form-group">
                <label for="inputnames">Nombre Y Apellido:</label>
                <input type="text" class="form-control"  name="complice_name" placeholder="Ingresar Nombre y Apellido">
            </div>
            <div class="form-group">
                <label for="inputAddress2">CI/DNI del Complice:</label>
                <input type="text" class="form-control"  name="CI_complice" placeholder="Ingrese CI/DNI">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Otros Detalles:</label>
                <input type="text" class="form-control" name="detail_complice" placeholder="Ingresar Breve Descripción">
            </div>
        </div>
            <div>
                <button class="btn btn-primary" type="submit">GUARDAR</button>
            </div>
    </form>
</div>
