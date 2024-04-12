<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRutificadoModel extends Model
{
   protected $table = "usuario_rutificado";
    protected $primaryKey = 'usuario_id';
   protected $allowedFields =[
    'usuario_id', 'nombre', 'rut', 'sexo', 'direccion', 'comuna', 'fake', 'fecha_registro'
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

   public function findClientByRut($rut)
   {
      return $this->asArray()->where(['rut' => $rut])->first();
   }
   
    public function verificar_existencia($rut) {
         return $this->asArray()->where(['rut' => $rut])->num_rows() > 0;
    }

   public function findClientById($idUsuario)
   {
      return $this->asArray()->where(['usuario_id' => $idUsuario])->first();
   }

   
}

?>