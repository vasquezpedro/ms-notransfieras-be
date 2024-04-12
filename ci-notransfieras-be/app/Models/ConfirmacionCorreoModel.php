<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfirmacionCorreoModel extends Model
{
    protected $table = 'confirmacion_correo';
    protected $primaryKey = 'id_confirmacion';
    protected $allowedFields = [
        'id_confirmacion', 'hash','code',  'usuario_id', 'fecha_expiracion','estado'
    ];

   

    public function findHash($hash)
    {
        $client = $this->asArray()->where(['hash' => $hash])->first();

        if (!$client) {
            throw new \Exception('Link no válido o caducado');
        }else if(!$client['estado']){
            throw new \Exception('correo ya confirmado');
        }

        // Verificar la fecha de expiración
        $fechaExpiracion = new \DateTime($client['fecha_expiracion']);
        $fechaActual = new \DateTime();

        if ($fechaExpiracion < $fechaActual) {
            throw new \Exception('El enlace ha caducado');
        }

        return $client;
    }

    public function findCode($code)
    {
        $client = $this->asArray()->where(['code' => $code])->first();

        if (!$client) {
            throw new \Exception('Codigo no valido');
        }else if(!$client['estado']){
            throw new \Exception('Ya has usado este codigo');
        }

        // Verificar la fecha de expiración
        $fechaExpiracion = new \DateTime($client['fecha_expiracion']);
        $fechaActual = new \DateTime();

        if ($fechaExpiracion < $fechaActual) {
            throw new \Exception('Codigo caducado');
        }

        return $client;
    }
}