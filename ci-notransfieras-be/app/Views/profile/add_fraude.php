<?php

$this->extend('dashboard_view'); ?>
<?php $this->section('contenido'); ?>
<div class="row">

    <div class="col-lg-12 mb-5">
        <div class="p-5">

            <div class="row">

                <div class="col-lg-12 mb-4 ">
                    <div class="card shadow mb-10">
                        <div class="card-header py-4">
                            <h7 class="m-0 font-weight-bold text-primary">Busqueda</h7>
                        </div>
                        <div class="card-body">
                            <form action="#" id="busqueda">
                                <div class="input-group">

                                    <input name="rut" type="text" class="form-control bg-light border-0 small rut-registro" placeholder="RUT" aria-label="RUT" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>


                                <form>
                        </div>


                    </div>
                </div>


                <div class="col-lg-6 mb-4 ">
                    <div class="card shadow mb-10">
                        <div class="card-header py-4">
                            <h7 class="m-0 font-weight-bold text-primary">Datos RUT</h7>
                        </div>
                        <div class="card-body">

                            <div class="form-group ">

                                <label>NOMBRE
                                </label>
                                <input type="text" name="nombre" id="nombre" class="form-control form-control-user rut-registro" placeholder="Nombre completo" readonly>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>ID</label>
                                    <input type="text" name="id" id="id" class="form-control form-control-user rut-registro" readonly>

                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>SEXO</label>
                                    <input type="text" name="sexo" id="sexo" class="form-control form-control-user rut-registro" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>DIRECCION</label>
                                    <input type="text" name="direccion" class="form-control form-control-user rut-registro" id="direccion" readonly>

                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>COMUNA</label>
                                    <input type="text" name="comuna" class="form-control form-control-user rut-registro" id="comuna" readonly>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- -->
                <div class="col-lg-6 mb-4 ">
                    <div class="card shadow mb-10">
                        <div class="card-header py-4">
                            <h7 class="m-0 font-weight-bold text-primary">Datos incidente</h7>
                        </div>
                        <div class="card-body">


                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>ID usuario</label>
                                    <input type="text" name="id_usuario" id="id_usuario" class="form-control form-control-user rut-registro" readonly>

                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Fecha incidente</label>
                                    <input type="text" id="fecha_registro" name="fecha_registro" class="form-control datepicker" placeholder="Seleccionar fecha" autocomplete="off">

                                </div>
                            </div>

                           

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                <label>TELEFONO</label>
                                    <input type="text" name="telefono" class="form-control form-control-user rut-registro" id="telefono">


                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                <label>SITIO WEB</label>
                                    <input type="text" name="webside" class="form-control form-control-user rut-registro" id="webside">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- -->
                <!-- -->
                <div class="col-lg-12 mb-4 ">
                    <div class="card shadow mb-10">
                     
                        <div class="card-body">


                        <div class="form-group ">

                        <label>DETALLE
                        </label>
                        <textarea name="detalle" id="detalle" class="form-control form-control-user rut-registro" rows="6"></textarea>

                        </div>

                        </div>
                    </div>
                </div>
                <!-- -->


            </div>



            <div class="row">
                <!-- -->

                <div class="col-lg-12 mb-4 ">
                    <div class="card shadow mb-10">
                        <div class="card-header py-4">
                            <h7 class="m-0 font-weight-bold text-primary">Adjuntos</h7>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="adjuntarImagen">Adjuntar Imágenes (1 a 3 archivos)</label>
                                <input type="file" class="form-control-file" id="adjuntarImagen" name="imagenes[]" accept="image/*" multiple>
                            </div>

                           
                                <div class="row" id='listAdjunto'>
                                    
                                </div>
                           
                               

                        </div>
                        <div class="card-footer">>
                                     <div class="text-rigth">
                                        <button class="btn btn-primary btn-user btn-block rut-registro" id="btn-done">aceptar</button>
                                     </div>
                                </div> 

                    </div>
                </div>
                <!-- -->
            </div>

        </div>
    </div>
</div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('#adjuntarImagen').on('change', function() {
    var archivos = $(this)[0].files;
    var contenedor = $('#listAdjunto'); // Cambia esto al ID de tu contenedor real
    var totalSize = 0; // Inicializar el tamaño total
    
    // Calcular el tamaño total de los archivos
    for (var i = 0; i < archivos.length; i++) {
        totalSize += archivos[i].size; // Agregar el tamaño de cada archivo
    }
    
    // Convertir bytes a megabytes
    var totalSizeMB = totalSize / (1024 * 1024);
    
    // Validar si el tamaño total supera los 10MB
    if (totalSizeMB > 10) {
        alert("El tamaño total de los archivos no puede superar los 10MB.");
        // Reiniciar el campo de entrada para eliminar los archivos seleccionados
        $(this).val('');
        return; // Salir de la función si el tamaño total excede el límite
    }
    
    // Validar si se seleccionaron más de tres archivos
    if (archivos.length > 3) {
        alert("Solo se pueden seleccionar hasta tres archivos.");
        // Reiniciar el campo de entrada para eliminar los archivos seleccionados
        $(this).val('');
        return; // Salir de la función si se seleccionaron más de tres archivos
    }
    
    // Agregar los divs de adjuntos al contenedor
    for (var i = 0; i < archivos.length; i++) {
        var divAdjunto = $('<div class="row"><div class="col-xl-12 col-md-12 mb-4  adjunto-div">' +
                           '    <div class="card border-left-info shadow h-100 py-2">' +
                           '        <div class="card-body">' +
                           '            <div class="row no-gutters align-items-center">' +
                           '                <div class="col-auto">' +
                           //'                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>' +
                           '                    <img class="img-thumbnail adjunto-icono" alt="'+archivos[i].name+'" src="' +  URL.createObjectURL(archivos[i]) + '" style="width: 200px; height: 200px;"></div>' +
                           '                </div>' +
                           '                <div class="col mr-2">' +
                           '                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">' + truncateNameImage(archivos[i].name,11) + '</div>' +
                           '                    <div class="row no-gutters align-items-center">' +
                           '                        <div class="col">' +
                           '                            <a href="#" class="btn btn-danger btn-circle btn-sm eliminar-adjunto">' +
                           '                                <i class="fas fa-trash"></i>' +
                           '                            </a>' +
                           '                        </div>' +
                           '                    </div>' +
                           '                </div>' +
                           '            </div>' +
                           '        </div>' +
                           '    </div>' +
                           '</div></div>');

        contenedor.append(divAdjunto);
    }
});

function truncateNameImage(nombreArchivo,length){
    if (nombreArchivo.length > length) {
        var extension = nombreArchivo.split('.').pop(); // Obtener la extensión del archivo
        var nombreTruncado = nombreArchivo.substr(0, 7) + '...' + extension; // Truncar el nombre y agregar '...'
        return nombreTruncado;
    }
    return nombreArchivo; 
}
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy', // Formato de la fecha
            autoclose: true // Cierra automáticamente después de seleccionar una fecha
        });

        $('#btn-done').prop('disabled', true);

        $('#btn-done').click(function(event) {

            event.preventDefault();

            var formData = $(this).serialize();


            $.post('<?= site_url('/adm/dashboard/rut/alter') ?>', formData, function(data) {
                    alert("se ha modificado el RUT");
                    $('#btn-done').prop('disabled', true);
                    $('.rut-registro').val("");

                }, 'json')
                .fail(function(xhr, textStatus, errorThrown) {
                    alert(textStatus + ", " + errorThrown);
                    console.log('Error en la solicitud:', textStatus, errorThrown);
                });
        });

        $('#busqueda').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.post('<?= site_url('/adm/dashboard/rut/buscar') ?>', formData, function(data) {
                    $('#btn-done').prop('disabled', false);
                    $('#id').val(data['RUT']['id']);
                    $('#nombre').val(data['RUT']['nombre']);
                    $('#sexo').val(data['RUT']['sexo']);
                    $('#direccion').val(data['RUT']['direccion']);
                    $('#comuna').val(data['RUT']['comuna']);
                    //$('.rut-registro').prop('readonly', true);
                }, 'json')
                .fail(function(xhr, textStatus, errorThrown) {
                    alert(textStatus + ", " + errorThrown);
                    console.log('Error en la solicitud:', textStatus, errorThrown);
                });
        });
    });
</script>
<?php $this->endSection(); ?>