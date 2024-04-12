<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Incidentes</title>

        <!-- Custom fonts for this template-->
        <link href="<?php echo base_url()?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url()?>css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>
<div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
<div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
    <div class="container">
        <div id="datosUsuario" class="registro-paso">
            <!-- form INI -->
            <div class="row">

                <div class="col-lg-12 mb-4 ">
                    <div class="card shadow mb-12">
                        <div class="card-header py-4">
                            <h7 class="m-0 font-weight-bold text-primary">Detalle del incidente</h7>
                        </div>

                        <div class="card-body">
                            <form>
                                <!-- Campos de datos de usuario -->
                                <div class="form-group row">

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <li>
                                                <label for="nombreUsuario">RUT: <?php echo $RUT['body']->rut?></label>
                                            </li>
                                            <li>
                                                <label for="nombreUsuario">NOMBRE: <?php echo $RUT['body']->nombre?></label>
                                            </li>
                                        </ul>
                                    </div>
                                   
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Fecha incidente</label>
                                    <input type="text" id="fecha_registro" name="fecha_registro" class="form-control datepicker" placeholder="Seleccionar fecha" autocomplete="off">

                                </div>

                                </div>
                                <div class="form-group">
                                    <label for="nombreUsuario">Relato del incidente:</label>
                                    <textarea name="detalle" id="detalle" class="form-control form-control-user " rows="6"></textarea>
                                </div>
                                <!-- Otros campos de datos de usuario -->

                                <!-- Botón para ir al siguiente paso -->
                                <button type="button" class="btn btn-primary btn-siguiente" data-paso="datosAdjuntos">Siguiente</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- form FIN -->


        </div>

        <div id="datosAdjuntos" class="registro-paso" style="display: none;">
            <div class="col-lg-12 mb-4 ">
                <div class="card shadow mb-12">
                    <div class="card-header py-4">
                        <h7 class="m-0 font-weight-bold text-primary">Adjuntos</h7>
                    </div>

                    <div class="card-body">
                        <p class="h7 mb-0 font-weight text-gray-800">
                            Adjunta el comprobante de transferencia y toda la evidencia que creas necesaria para hacer valida esta publicacion por ejemplo: Screenshot(Pantallasos) de chats,etc.
                        </p>
                        <form>
                            <div class="form-group">


                                <label for="files-list" class="form-label">Adjuntar</label>
                                <input class="form-control " id="files-list" type="file" id="adjuntarImagen" name="imagenes[]" accept="image/*" multiple="">
                              
                            </div>
                  
                <!-- Otros campos de datos de usuario -->

                <!-- Botones para ir al paso anterior o siguiente -->
                <div class="form-group">
                    <button type="button" class="btn btn-secondary btn-anterior" data-paso="datosUsuario">Anterior</button>
                    <button type="button" class="btn btn-primary btn-siguiente" data-paso="datosContacto">Siguiente</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    </form>
    </div>

    <div id="datosContacto" class="registro-paso" style="display: none;">
        <h2>Datos de Contacto</h2>
        <form>
            <!-- Campos de datos de contacto -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Ingrese su correo electrónico">
            </div>
            <!-- Otros campos de datos de contacto -->

            <!-- Botones para ir al paso anterior o enviar el formulario -->
            <button type="button" class="btn btn-secondary btn-anterior" data-paso="datosAdjuntos">Anterior</button>
            <button type="button" id="registro" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    <button type="button" id="registro" class="btn btn-primary">Enviar</button>
    <a href="<?php echo base_url()?>" class="btn btn-secondary">
        vovler
    </a>
    </div>

    <!-- Incluye jQuery y Bootstrap JS al final del body -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
 <!-- Bootstrap core JavaScript-->
 <script src="<?php echo base_url()?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url()?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url()?>js/sb-admin-2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#registro').click(function() {
/*
                adjunto=[];
                

                var formData = new FormData(); // Crear un objeto FormData

                    files=$('#files-list')[0].files;
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        formData.append('imagenes[]', file);
                        adjunto.push(
                            {nombre: file.name,
                            ext:file.type,
                            file:file
                            }
                        );
                    }

                
                dataRegistro={
                    detalle:$('#detalle').val(),
                    fechaRegistro:$('#fecha_registro').val(),
                    usuarioID:'<?php echo $RUT['body']->id?>',
                    adjuntos:adjunto
                }
*/
var formData = new FormData(); // Crear un objeto FormData

    // Agregar datos JSON al objeto FormData
    formData.append('detalle', $('#detalle').val());
    formData.append('fechaRegistro', $('#fecha_registro').val());
    formData.append('usuarioID', '<?php echo $RUT['body']->id?>');

    // Agregar archivos al objeto FormData
    var files = $('#files-list')[0].files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        formData.append('imagenes[]', file);
    }
    $('#loading-overlay').show();
                $.ajax({
                    url: '<?php echo site_url('profile/incidente')?>',
                    type: 'POST', // Tipo de solicitud (en este caso, POST)
                    data: formData, // Datos que se enviarán al servidor
                    contentType: false, // Importante: deshabilita el tipo de contenido predeterminado
                    processData: false, // Importante: deshabilita el procesamiento de datos predeterminado
                    success: function(response) {
                        // Manejar la respuesta del servidor si la solicitud fue exitosa
                    $('#modal-title-head').addClass(' bg-gradient-info text-white');
                    $('#title-modal-head').text($('#fecha_registro').val());
                    $('#modal-body-content-detalle').text('Se ha registrado de manera correcta.');
                        console.log(response);
                        setTimeout(function() {         $('#loading-overlay').hide();              }, 100);
                        $('.cerrar-modal').click(function() {
                            window.location.href ='<?php echo site_url('/')?>';
                        });
                        $('#modalDetalle').modal('show');
                    },
                    error: function(xhr, status, error) {
                    $('#modal-title-head').addClass(' bg-gradient-danger text-white');
                    $('#title-modal-head').text('Error');
                    $('#modal-body-content-detalle').text(xhr.responseText);
                   
                    setTimeout(function() {
                        $('#loading-overlay').hide();
                    }, 100);
                    $('#modalDetalle').modal('show');
                   
                        console.error(xhr.responseText);
                    }
                });
      
            });
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy', // Formato de la fecha
            autoclose: true // Cierra automáticamente después de seleccionar una fecha
        });
            // Manejar el clic en los botones "Siguiente"
            $('.btn-siguiente').click(function() {
                var pasoActual = $(this).closest('.registro-paso');
                var siguientePaso = $('#' + $(this).data('paso'));

                pasoActual.hide();
                siguientePaso.show();
            });

            // Manejar el clic en los botones "Anterior"
            $('.btn-anterior').click(function() {
                var pasoActual = $(this).closest('.registro-paso');
                var pasoAnterior = $('#' + $(this).data('paso'));

                pasoActual.hide();
                pasoAnterior.show();
            });
        });
    </script>
<!--modal -->
<div class="modal fade " id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header " id="modal-title-head">
                <h5 class="modal-title" id="title-modal-head"></h5>
                <button class="close cerrar-modal" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-content">
                <p class="text-gray-900 p-3 m-0" id="modal-body-content-detalle"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary cerrar-modal" id="cerrar-modal" type="button" data-dismiss="modal">cerrar</button>

            </div>
        </div>
    </div>
</div>
<!-- modal fin-->
</body>

</html>