<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaUsuarios extends Migration
{
    public function up() {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'cpf' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'is_admin' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
            ],
            'ativo' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'ativacao_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'reset_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'password_expira_em' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null
            ],
            'criado_em' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null
            ],
            'atualizado_em' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null
            ],
            'deletado_em' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null
            ],
            
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('usuarios');
    }

    public function down() {
        $this->forge->dropTable('usuarios');
    }
}