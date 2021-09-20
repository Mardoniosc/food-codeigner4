<?php

namespace App\Database\Seeds;

use App\Models\UsuarioModel;
use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run() {
        
        $usuarioModel = new UsuarioModel;

        $usuario = [
            'nome' => 'Mardonio Costa',
            'email' => 'admin@admin.com',
            'telefone' => '(61) 9 8888-4444'
        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'Maria Santos',
            'email' => 'user@user.com',
            'telefone' => '(61) 5 4444-2222'
        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());
    }
}
