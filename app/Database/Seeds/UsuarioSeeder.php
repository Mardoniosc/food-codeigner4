<?php

namespace App\Database\Seeds;

use App\Models\UsuarioModel;
use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run() {
        
        $usuarioModel = new UsuarioModel;

        $usuario = [
            'nome'      => 'Thomas Diego Sales',
            'email'     => 'thomasdiegosales..thomasdiegosales@jovempanfmtaubate.com.br',
            'telefone'  => '(84) 3812-2134',
            'cpf'       => '863.075.953-45'
        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome'      => 'Aparecida Andreia Julia Barbosa',
            'email'     => 'aparecidaandreiajuliabarbosa@supercarioca.com',
            'telefone'  => '(21) 3961-8815',
            'cpf'       => '790.056.517-50'
        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());
    }
}
