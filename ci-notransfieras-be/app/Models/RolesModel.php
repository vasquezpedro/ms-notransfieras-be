<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
   protected $table = "user_roles";
   protected $primaryKey = 'id';
   protected $allowedFields =[
    'id',
    'nombre',
    'descripcion'
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
   
 public function findByNombre(string $nombre)
    {
        return $this->asArray()->where(['nombre' => $nombre])->first();
    }
    
    public function generaId()
    {
        $query = $this->db->query('SELECT UUID() as uuid');
        $row = $query->getRowArray();
        $idUUID = $row['uuid'];
        return $idUUID;
    }

    public function findAllByIdUsuario($userId)
    {
        return $this->select('user_roles.id,user_roles.nombre')
                    ->join('usu_rel_rol', 'usu_rel_rol.rol_id = user_roles.id')
                    ->where('usu_rel_rol.usuario_id', $userId)
                    ->findAll();
    }
}

?>