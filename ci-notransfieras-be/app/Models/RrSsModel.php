<?php

namespace App\Models;

use CodeIgniter\Model;

class RrSsModel extends Model
{
   protected $table = "usu_rss_contacto";
   protected $allowedFields =[
    'usu_rrss_id',
    'usu_rrss_tipo',
    'usu_rrss_nombre',
    'usuario_id',
    'usu_fraude_id'
   ];

   protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data): array
    {
  
        return $data;
    }

  
    public function findRRSSByIdFraude($id)
   {
      return $this->asArray()->where(['usu_fraude_id' => $id])->findAll();
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