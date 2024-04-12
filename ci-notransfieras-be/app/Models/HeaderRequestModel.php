<?php

namespace App\Models;

use CodeIgniter\Model;

class HeaderRequestModel extends Model
{
    protected $table = 'header_request';
    protected $allowedFields = [
        'id', 'ip', 'os','device_model','device_id','id_usuario','canal','bitacora','fecha_registro'
    ];


 
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data): array
    {
  
        return $data;
    }

 


    public function findClientById($id)
    {
        $client = $this->asArray()->where(['id' => $id])->first();

        if (!$client) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $client;
    }

    public function generaId()
    {
        $query = $this->db->query('SELECT UUID() as uuid');
        $row = $query->getRowArray();
        $idUUID = $row['uuid'];
        return $idUUID;
    }
}