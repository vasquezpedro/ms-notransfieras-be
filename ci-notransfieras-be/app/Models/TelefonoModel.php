<?php

namespace App\Models;

use CodeIgniter\Model;

class TelefonoModel extends Model
{
   protected $table = "usu_telefonos_fraudes";
   protected $allowedFields =[
    'usu_tel_id',
    'usu_tel',
    'usuario_id'
   ];

   protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data): array
    {
  
        return $data;
    }

  
    public function findTelefonoByIdUser($id)
   {
      return $this->asArray()->where(['rut_id' => $id])->findAll();
   }

   
    public function generaId()
    {
        $query = $this->db->query('SELECT UUID() as uuid');
        $row = $query->getRowArray();
        $idUUID = $row['uuid'];
        return $idUUID;
    }

}

?>