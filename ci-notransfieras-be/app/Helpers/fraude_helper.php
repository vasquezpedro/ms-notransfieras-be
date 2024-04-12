<?php



function listToCamelCase($datos): array{
    return $datosEnCamelCase = array_map(function ($item) {
        return snakeTocamel($item);
    }, $datos);

}

function snakeTocamel($item)
{
    return [
        'id' => $item['usu_fraude_id'],
        'detalle' => $item['usu_fraude_detalle'],
        'fechaRegistro' => $item['usu_fraude_fecha_registro'],
        'fechaCreacion' => $item['usu_fraude_fecha_crea'],
        'usuarioID' => $item['rut_id']
    ];
}