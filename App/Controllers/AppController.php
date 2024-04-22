<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function modulo_meu_jardim(){
        
        session_start();

        if($_SESSION['UserID'] != '' && $_SESSION['Nome'] != ''){
            $this->render('modulo_meu_jardim');


        } else{
            header('Location:login?login=error2');
        }
        

    }

}