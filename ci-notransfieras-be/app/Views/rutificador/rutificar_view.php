<!DOCTYPE html>
<html lang="es">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>No Transfieras</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>


<body>

    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>

    <div class="content">


        <div class="container">
            <div class="row">
                <!-- busqueda -->
                <div class="col-lg-12 mb-4 ">
                    <div class="card shadow mb-12">
                        <div class="card-header py-4">
                            <h7 class="m-0 font-weight-bold text-primary">busqueda</h7>
                        </div>

                        <div class="card-body">


                            <form action="<?= site_url('rutifica') ?>" method="post" id="busquedaRut">
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-6 mb-sm-0">
                                        <input class="form-control bg-light border-0 small" type="search" name="rut" placeholder="ingrese un rut valido" aria-label="Search">
                                    </div>
                                    <div class="col-sm-2 mb-6 mb-sm-0">
                                        <button class="btn btn-primary" id="buscar">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>

                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
                <!-- busqueda -->
                <!-- resutaldo -->
                <?php if (isset($rutificado) && !empty($rutificado)) : ?>
                    <div class="col-lg-12 mb-4 ">
                        <div class="card shadow mb-10">
                            <div class="card-header py-4">
                                <h7 class="m-0 font-weight-bold text-primary">Resultado</h7>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <p><?php if (isset($rutificado) && array_key_exists('error', $rutificado)) : ?>
                                    <h1 class="card-title pricing-card-title"><?= $rutificado["error"] ?></h1>
                                <?php elseif (isset($rutificado) && array_key_exists('nombre', $rutificado)) : ?></p>
                                    <div class="col-md-12 order-md-1">
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <li>
                                                <h5 class="card-title pricing-card-title"><?= $rutificado["nombre"] ?></h5>
                                            </li>
                                            <li><?= $rutificado["rut"] ?></li>
                                            <?php if ($rutificado["sexo"] === "MUJ") : ?>
                                                <li>Mujer</li>
                                            <?php else : ?>
                                                <li>Hombre</li>
                                            <?php endif; ?>
                                            <?php if (filter_var($rutificado['isFake'], FILTER_VALIDATE_BOOLEAN)) : ?>
                                                <li style="font-weight: bold;">
                                                    <img src="<?= base_url('/img/alerta.png') ?>" alt="RUT POSIBLE FRAUDE" width="25" height="25">
                                                    <?= $rutificado["message"] ?>
                                                </li>
                                                <img src="<?= base_url('/img/ladron.png') ?>" alt="RUT POSIBLE FRAUDE" width="70" height="70">
                                            <?php else : ?>
                                                <li style="font-weight: bold;">
                                                    <img src="<?= base_url('/img/chequed.png') ?>" alt="RUT LIMPIO" width="25" height="25">
                                                    <?= $rutificado["message"] ?>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-3 order-md-2">
                                    <form method="post" action="<?= site_url('profile/login/index') ?>" >
                                                <input type="hidden" name="rutID" value="<?= $rutificado["id"] ?>" />
                                                <button class="btn btn-info btn-icon-split " id="">
                                                    <span class="text">¿desea agregar?</span>
                                                </button>
                                            </form>
                                        
                                    </div>
                                </div>
                               
                                <?php if (filter_var($rutificado['isFake'], FILTER_VALIDATE_BOOLEAN) && array_key_exists('fraudes', $rutificado)) : ?>

                                    <div class="row py-2">
                                        <?php foreach ($rutificado['fraudes'] as $index =>  $fraude) : ?>

                                            <!-- tarjetas des -->
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 mb-4  adjunto-div">
                                                    <div class="card border-left-info shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                    <?php echo $fraude['usu_fraude_fecha_registro'] ?>
                                                                </div>
                                                                <div class="h7 mb-0 font-weight-bold text-gray-800"><?= $fraude['usu_fraude_detalle'] ?></div>
                                                                <div class="col-auto">

                                                                </div>
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"></div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col mr-2">

                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col">
                                                                                    <a href="#" class="btn btn-info btn-icon-split detalle-fraud" id="<?= $fraude['usu_fraude_id'] ?>" data-target="#modalDetalle">

                                                                                        <span class="text">mas...</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!-- tarjetas des -->

                                        <?php endforeach; ?>

                                    </div>

                                <?php endif; ?>
                            <?php endif; ?></p>
                            <!--        </ul> -->
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>

<?php endif; ?>
</div>
</div>
</div>

<!--modal -->
<div class="modal fade " id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header " id="modal-title-head">
                <h5 class="modal-title" id="title-modal-head"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-content">
                <p class="text-gray-900 p-3 m-0" id="modal-body-content-detalle"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">cerrar</button>

            </div>
        </div>
    </div>
</div>
<!-- modal fin-->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2272370549665702"
     crossorigin="anonymous"></script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3892935254816725" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $_ENV['recaptchav3_key_site'] ?>"></script>
<script src="<?php echo base_url('/bootstrap-4.3.1/js/bootstrap.js'); ?>"></script>
<script src="<?php echo base_url() ?>vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url() ?>js/sb-admin-2.min.js"></script>

<script>
    $(document).ready(function() {
        function limpiarModal() {
            $('#body-content').empty();
            $('#modal-title-head').removeClass(' bg-gradient-warning text-info');
            $('#title-modal-head').text('');
            $('#body-content').append($('<p class="text-gray-900 p-3 m-0" id="modal-body-content-detalle"></p>'));

        }
        $('.detalle-fraud').click(function() {

            limpiarModal();
            var url = '<?= site_url('rutifica/fraude/') ?>' + this.id;
            $('#loading-overlay').show();
            $.post(url, function(data) {
                    $('#modal-title-head').addClass(' bg-gradient-info text-white');
                    $('#title-modal-head').text(data.body.fechaRegistro);

                    $('#modal-body-content-detalle').text(data.body.detalle);


                    var nuevoDiv = $('<div>');
                    $.each(data.body.adjuntos, function(index, item) {


                        //var nuevaImagen = $('<div>').attr('id','').attr(style="width: 300px;);
                        //var nuevaImagen = $('<img>').attr('src','data:image/png;base64,' + item.base).attr('alt', 'Imagen');

                        var divAdjunto = $('<div class="row"><div class="col-xl-12 col-md-12 mb-4  adjunto-div">' +
                            '    <div class="card border-left-info shadow h-100 py-2">' +
                            '        <div class="card-body">' +
                            '            <div class="row no-gutters align-items-center">' +
                            '                <div class="col-auto">' +
                            //'                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>' +
                            '                    <img class="img-thumbnail adjunto-icono" alt="' + item.nombre + '" id="' + item.id + '" src="data:image/png;base64,' + item.base + '" style="width: 100%;/* height: 200px; */"></div>' +
                            '                </div>' +
                            '                <div class="col mr-2">' +
                            '                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">' + item.nombre + '</div>' +
                            '                    <div class="row no-gutters align-items-center">' +

                            '                    </div>' +
                            '                </div>' +
                            '            </div>' +
                            '        </div>' +
                            '    </div>' +
                            '</div></div>');
                        $('#body-content').append(divAdjunto);
                    });

                    // $('#body-content').append(nuevoDiv);
                    setTimeout(function() {
                        // Oculta la pantalla de carga
                        $('#loading-overlay').hide();
                    }, 100);
                    $('#modalDetalle').modal('show');

                }, 'json')
                .fail(function(xhr, textStatus, errorThrown) {

                    console.log('Error en la solicitud:', textStatus, errorThrown);
                    $('#modal-title-head').addClass(' bg-gradient-danger text-white');
                    $('#title-modal-head').text('Error');
                    $('#modal-body-content-detalle').text('Se ha producido un error al obtener el detalle.');
                    setTimeout(function() {
                        // Oculta la pantalla de carga
                        $('#loading-overlay').hide();
                    }, 100);
                    $('#modalDetalle').modal('show');
                });


        });



        $('#buscar').click(function() {
            limpiarModal();
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo $_ENV['recaptchav3_key_site'] ?>', {
                        action: 'auth'
                    })
                    .then(function(token) {
                        $('#busquedaRut').prepend('<input type="hidden" name="token" value="' + token + '">');
                        $('#busquedaRut').prepend('<input type="hidden" name="action" value="auth">');
                        $('#busquedaRut').submit();
                    });
            });
        });
    });
</script>
</body>

</html>