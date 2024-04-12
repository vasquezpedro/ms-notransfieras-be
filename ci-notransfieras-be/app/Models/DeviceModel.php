<?php

namespace App\Models;

use CodeIgniter\Model;

class DeviceModel extends Model
{
    protected $table = 'device';
    protected $allowedFields = [
        'id', 'id_usuario', 'nombre','telefono','correo'
    ];

    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';

    public function findClientById($id)
    {
        $client = $this->asArray()->where(['id' => $id])->first();

        if (!$client) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $client;
    }
}