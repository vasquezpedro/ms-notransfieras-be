<?php

namespace App\Models;

use CodeIgniter\Model;

class AdjuntosModel extends Model
{
   protected $table = "usu_fraudes_adjunto";
   protected $primaryKey = 'usu_fraudes_adjunto_id';
   protected $allowedFields =[
    'usu_fraudes_adjunto_id',
    'usu_fraudes_adjunto_file',
    'usu_fraude_id',
    'nombre',
    'path',
    'ext'
   ];

   protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data): array
    {
  
        return $data;
    }

  
   public function findAdjuntoByIdFraude($idFraude)
   {
      $query =$this->select('usu_fraudes_adjunto_id,nombre,path,usu_fraudes_adjunto_file')
                     ->where(['usu_fraude_id' => $idFraude])
                     ->findAll();
            foreach ($query as &$row) {
               $row['usu_fraudes_adjunto_file'] = base64_encode($row['usu_fraudes_adjunto_file']);
            }
      return $query;
   }
}

?>