<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}

	public function login() {

		$this->render('login');
	}

	public function cadastro() {

		$this->render('cadastro');
	}

	public function valida_cadastro() {
		
		$valida_cadastro = Container::getModel('valida_cadastro');

		$valida_cadastro->__set('Nome',$_POST['nome']);
		$valida_cadastro->__set('Email',$_POST['email']);
		$valida_cadastro->__set('Senha',$_POST['senha']);



		if($valida_cadastro->validarSenha()){
			if($valida_cadastro->validarTamanhoSenha()){
				if(count($valida_cadastro->getUsuarioPorEmail())== 0){
					$valida_cadastro->salvar();
				}else{
					header('Location: cadastro?cadastro=error3');
				};			
			}
		}


		
	}

	public function menu_inicial() {

		$this->render('menu_inicial');
	}
}


?>