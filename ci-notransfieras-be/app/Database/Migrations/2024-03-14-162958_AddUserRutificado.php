<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserRutificado extends Migration
{
    public function up()
    {
       $this->forge->addField([
            'usuario_id' =>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false
            ],
            'rut' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'null' => false,
                'unique'=> true
            ],
            'sexo' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
                'null' => false
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false
            ],
            'comuna' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false
            ],
            'fake' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default'=> false
            ],
            'fecha_registro' => [
                'type' => 'DATE',
                'constraint' => '100',
                'defautl' => 'current_timestamp'
            ]
       ]);
       $this->forge->addPrimaryKey('usuario_id');
        $this->forge->createTable('usuario_rutificado');
    }

    public function down()
    {
        $this->forge->dropTable('usuario_rutificado');
    }
}
