<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id','nombre','apellido','username', 'email', 'password','avatar','email_confirmado'
    ];
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = password_hash($plaintextPassword, PASSWORD_BCRYPT);
        }

        return $data;
    }

    public function findUserByEmailAddress(string $emailAddress) {
        $user = $this->asArray()->where(['email' => $emailAddress])->first();

        if (!$user) {
            throw new Exception('El usuario no existe para la direcci¨®n de correo electr¨®nico especificada');
        }
        return $user;
    }

    public function findUserByEmailAddressNameUser(string $emailAddress,string $username) {
        $user = $this->asArray()->where(['email' => $emailAddress,'username' => $username])->first();

        if (!$user) {
            throw new Exception('El mail no existe para el usuario especificada');
        }
        return $user;
    }

    public function findUserByName(string $nameUser) {
        $user = $this->asArray()->where(['username' => $nameUser])->first();

        if (!$user) {
            throw new Exception('User or pass invalid');
        }
        return $user;
    }

    public function generaId()
    {
        $query = $this->db->query('SELECT UUID() as uuid');
        $row = $query->getRowArray();
        $idUUID = $row['uuid'];
        return $idUUID;
    }
}