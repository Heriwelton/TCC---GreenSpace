<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {


	public function valida_login() {
		
		$usuario = Container::getModel('valida_cadastro');

		$usuario->__set('Email', $_POST['email']);
		$usuario->__set('Senha', $_POST['senha']);

		$usuario->valida_login();
		$usuario->seleciona_lgn_lat();

		if($usuario->__get('UserID') != '' && $usuario->__get('Nome') != '') {
			echo 'autenticado';
			
			session_start();

			$_SESSION['UserID'] = $usuario->__get('UserID');
			$_SESSION['Nome'] = $usuario->__get('Nome');

			$clima = "https://api.openweathermap.org/data/2.5/weather?lat=". $usuario->__get('lat') ."&lon=". $usuario->__get('lng') ."&appid=c0435d94084bcfaef0212200c478d902&lang=pt_br&units=metric";	
			$dadosClima = file_get_contents($clima);
			$dados_decodificados_clima = json_decode($dadosClima);

			$description = $dados_decodificados_clima->weather[0]->description;
			$icone = $dados_decodificados_clima->weather[0]->icon;
			$cidade = $dados_decodificados_clima->name;
			(float)$temperatura = $dados_decodificados_clima->main->temp;



			$_SESSION['cidade'] = $cidade;
			$_SESSION['clima'] = $description;
			$_SESSION['icone'] = $icone;
			$_SESSION['temperatura'] = number_format($temperatura, 0);


			header('Location: /modulo_meu_jardim');

			
		} else {
			echo 'erro na autenticaçao';
			header('Location: login?login=error1');
		}

	}

	public function sair() {
		session_start();
		session_destroy();
		header('Location: /');
	}
}