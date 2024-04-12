<?php

 function adjuntoSnakeTocase(array $data):array{

    $dataAux=[];
    if($data!=null && !empty($data)){
        $dataAux=[
        'adjuntoID'=>$data["usu_fraudes_adjunto_id"],
        'nombre'=>$data["nombre"],
        'path'=>$data["path"],
         'base'=>$data["usu_fraudes_adjunto_file"]
    ];
}
return $dataAux; 

}

function adjuntolistToCamelCase($datos): array{
    return $datosEnCamelCase = array_map(function ($item) {
        return adjuntoSnakeTocase($item);
    }, $datos);

}

function rrssSnakeTocase($data):array{
    $dataAux=[];
    if($data!=null && !empty($data)){
        $dataAux=[
            'rrssID'=>$data["usu_rrss_id"],
            'tipo'=>$data["usu_rrss_tipo"],
            'nombre'=>$data["usu_rrss_nombre"],
            'userID'=>$data["usuario_id"],
            'fraudeID'=>$data["usu_fraude_id"]
        ];
    }
    return $dataAux; 

}

function rrsslistToCamelCase($datos): array{
    return $datosEnCamelCase = array_map(function ($item) {
        return rrssSnakeTocase($item);
    }, $datos);

}

function telSnakeTocase($data):array{

    $dataAux=[];
    if($data!=null && !empty($data)){
        $dataAux=[
        'telefonoID'=>$data["usu_tel_id"],
        'telefono'=>$data["usu_tel"],
        'userID'=>$data["rut_id"]
    ];
    }
    return $dataAux; 
}

function telefonoListToCamelCase($datos): array{
    return $datosEnCamelCase = array_map(function ($item) {
        return telSnakeTocase($item);
    }, $datos);

}