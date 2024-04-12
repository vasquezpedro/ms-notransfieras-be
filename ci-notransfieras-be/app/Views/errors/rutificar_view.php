<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="<?php echo base_url('style.css'); ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="wiewport" content="width=device-width, initial-scale=1.0">
        <title>fake rut</title>
    </head>
    <body>


    <div class="wrap">
        <h1>Buscar rut</h1>
        <form action="<?=site_url('rutifica')?>" method="post">
        <h2><input type="text" name="rut" placeholder="ingresa un rut XX.XXX.XXX-X"/>
        </h2>
            <button>enviar</button>
        </form>
        
        <p><?php if (isset($rutificado) && array_key_exists('error', $rutificado)): ?>
            <pre><?= $rutificado["error"] ?></pre>
        
            <?php elseif(isset($rutificado) && array_key_exists('nombre', $rutificado)): ?></p>
               
                <pre><?= $rutificado["nombre"] ?></pre>
            <pre><?= $rutificado["rut"] ?></pre>
            <pre><?= $rutificado["sexo"] ?></pre>
            <pre style=" font-weight: bold;"><?= $rutificado["message"] ?></pre>
            <?php if(array_key_exists('fraudes', $rutificado)):?>
             
                <div class="list-group">
                <?php foreach ($rutificado['fraudes'] as $fraude): ?>
            <a href="#" class="list-group-item" id="<?= $fraude['usu_fraude_id']?>"><?= $fraude['usu_fraude_fecha_registro'].'-'.$fraude['usu_fraude_detalle'] ?></a>
        <?php endforeach; ?>
            <?php endif; ?>
<?php endif; ?></p>
    </div>
        
    </body>
</html>