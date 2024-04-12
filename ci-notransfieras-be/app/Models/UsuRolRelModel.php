<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuRolRelModel extends Model
{
   protected $table = "usu_rel_rol";
   protected $primaryKey = 'id';
   protected $allowedFields =[
    'id',
    'rol_id',
    'usuario_id'
   ];

   protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data): array
    {
        return $data;
    }

    protected function beforeUpdate(array $data): array
    {
        return $data;
    }
   

    
}

?>