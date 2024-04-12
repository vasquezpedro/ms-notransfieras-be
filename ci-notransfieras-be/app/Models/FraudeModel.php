<?php

namespace App\Models;

use CodeIgniter\Model;

class FraudeModel extends Model
{
   protected $table = "usu_fraude";
   protected $primaryKey = 'usu_fraude_id';
   protected $allowedFields =[
      'usu_fraude_id',
      'usu_fraude_detalle',
    'usu_fraude_fecha_registro',
    'rut_id',
    'id_user_registra'
   ];

   protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data): array
    {
  
        return $data;
    }

    public function findFunasByIdUser($idUsuario)
    {
       return $this->asArray()->where(['rut_id' => $idUsuario])->findAll();
    }

    public function findUsuFraudeId($idFraude)
   {
      return $this->asArray()->where(['usu_fraude_id' => $idFraude])->first();
   }
}

?>