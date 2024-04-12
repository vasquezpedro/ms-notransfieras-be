<?php

use Symfony\Component\DomCrawler\Crawler;


function validarRut($rut) {
    if($rut===null && isset($rut)){
        throw new Exception('el rut no puede ser vacio.');
    }
    // Eliminar puntos y guión del RUT y convertir todo a mayúsculas
    $rut = strtoupper(str_replace(['.', '-'], '', $rut));

    // Separar el RUT del dígito verificador
    $rutSinVerificador = substr($rut, 0, -1);
    $verificador = substr($rut, -1);

    // Validar el formato del RUT
    if (!preg_match('/^[0-9]{1,8}$/', $rutSinVerificador)) {
        return false; // El RUT no tiene el formato correcto
    }

    // Calcular el dígito verificador esperado
    $factor = 2;
    $suma = 0;
    for ($i = strlen($rutSinVerificador) - 1; $i >= 0; $i--) {
        $suma += $rutSinVerificador[$i] * $factor;
        $factor = $factor == 7 ? 2 : $factor + 1;
    }
    $resto = $suma % 11;
    $digitoEsperado = ($resto == 0) ? '0' : (($resto == 1) ? 'K' : (11 - $resto));


    // Comparar el dígito verificador calculado con el proporcionado
    return $digitoEsperado == $verificador;
}

function cleanRut($rut): string{
    $rutAux = str_ireplace(['k', 'K'], '0', $rut);
    return preg_replace('/[^0-9Kk]/', '', $rutAux);
}

function traduceFake($fake):bool{
    if($fake==='0'){
        return false;
    }else{
        return true;
    }
}


function getRutificador($rut): array {
  
    // Verificar si 'term' está presente en la URL
    if (empty($rut)) {
        return array("error" => "El parámetro 'rut' es obligatorio.");
    }

    $responseData = array();
    // Obtener datos del RUT
    $url = env('URL_RUTIFICADOR');
    $response = file_get_contents($url . $rut);
    //log_message('error',  $response );
    if ($response === FALSE) {
        // Error al obtener los datos
        return array("error" => "Error al obtener los datos.");
    }

    // Crear una instancia de Crawler y cargar el HTML
    $crawler = new Crawler($response);

    // Buscar la tabla con la clase 'table.table.table-hover'
    $tabla = $crawler->filter('table.table.table-hover')->first();

    // Verificar si se encontró la tabla
    if ($tabla->count() > 0) {
        // Obtener todos los elementos <tr> dentro de la tabla
        $filas = $tabla->filter('tbody tr');

        // Verificar si hay al menos una fila
        if ($filas->count() > 0) {
            // Obtener la primera fila de datos
            $primer_fila = $filas->first();

            // Obtener los datos de la primera fila
            $nombre = $primer_fila->filter('td')->eq(0)->text();
            $rut = $primer_fila->filter('td')->eq(1)->text();
            $sexo = $primer_fila->filter('td')->eq(2)->text();
            $direccion = $primer_fila->filter('td')->eq(3)->text();
            $comuna = $primer_fila->filter('td')->eq(4)->text();

            // Asignar los valores al array asociativo
            $responseData=[
                'nombre'=> $nombre,
                'rut'=>preg_replace("/[^0-9]/", "", $rut),
                'sexo'=> $sexo,
                'direccion'=>$direccion,
                'comuna'=> $comuna];
        
            //log_message('restorno del rutificador:', json_encode($responseData) );
            // Retornar los datos
            return $responseData;
        } else {
            return array("error" => "No se encontraron filas de datos en la tabla.");
        }
    } else {
        return array("error" => "No se encontró la tabla con la clase 'table.table.table-hover'.");
    }
}


function domainToResponse( $userRut): array{
    $responseData = array();
    $responseData['id'] = $userRut['usuario_id'];
    $responseData['nombre'] =$userRut['nombre'];
    $responseData['rut'] = $userRut['rut'];
    $responseData['sexo'] = $userRut['sexo'];
    $responseData['direccion'] = $userRut['direccion'];
    $responseData['comuna'] = $userRut['comuna'];
    $responseData['isFake'] =traduceFake($userRut['fake']);
    return $responseData;
}

function getRutificadorNombre($nombreFind): array {
  try{
    // Verificar si 'term' está presente en la URL
    if (empty($nombreFind)) {
        return array("error" => "El parámetro 'rut' es obligatorio.");
    }

    $responseData = array();
    // Obtener datos del RUT
    $url = env('URL_RUTIFICADOR_NOMBRE');
    $response = file_get_contents($url . $nombreFind);
    //log_message('error',  $response );
    if ($response === FALSE) {
        // Error al obtener los datos
        return array("error" => "Error al obtener los datos.");
    }

    // Crear una instancia de Crawler y cargar el HTML
    $crawler = new Crawler($response);

    // Buscar la tabla con la clase 'table.table.table-hover'
    $tabla = $crawler->filter('table.table.table-hover')->first();
    $responseData=[];
    // Verificar si se encontró la tabla
    if ($tabla->count() > 0) {
        // Obtener todos los elementos <tr> dentro de la tabla
        $filas = $tabla->filter('tbody tr');
        log_message('info', 'Rutifica nombre - '. $filas->count());
        // Verificar si hay al menos una fila
        if ($filas->count() > 0) {
            // Obtener la primera fila de datos
            foreach ($filas as $indice => $fila) {
                $crawlerFila = new Crawler($fila);
                $nombre = $crawlerFila->filter('td')->eq(0)->text();
                $rut = $crawlerFila->filter('td')->eq(1)->text();
                $sexo = $crawlerFila->filter('td')->eq(2)->text();
                $direccion = $crawlerFila->filter('td')->eq(3)->text();
                $comuna = $crawlerFila->filter('td')->eq(4)->text();
                $responseData[$indice]= [
                    'nombre'=> $nombre,
                    'rut'=>preg_replace("/[^0-9]/", "", $rut),
                    'sexo'=> $sexo,
                    'direccion'=>$direccion,
                    'comuna'=> $comuna];
            }

            

        
            //log_message('restorno del rutificador:', json_encode($responseData) );
            // Retornar los datos
            return $responseData;
        } else {
            return array("error" => "No se encontraron filas de datos en la tabla.");
        }
    } else {
        return array("error" => "No se encontró la tabla con la clase 'table.table.table-hover'.");
    }
  }catch(\Exception $e){
    log_message('error', 'error al registrar - '. $e);
    return array("error" => $e->getMessage());
  }
    
}


function tdGetValueIdx($tds,$idx)
{
    if($tds->count() >= $idx){
        return $tds->eq($idx)->text();
    }else{
        return "";
    }
}
