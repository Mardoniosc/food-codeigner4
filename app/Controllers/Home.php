<?php

namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function email() {
        $email = Services::email();

        $email->setFrom('mardonio@live.com', 'Mardonio');
        $email->setTo('katya1071@uorak.com');
        $email->setCC('katya1071@uorak.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject('Teste de E-mail');
        $email->setMessage('Enviado o ultimo E-mail.');

        if($email->send()) {
            echo 'E-mail Enviado!';
        } else {
            echo $email->printDebugger();
        }
    }
}
