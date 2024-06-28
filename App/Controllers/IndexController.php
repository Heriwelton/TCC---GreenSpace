<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
use MF\Model\Model;

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

		$valida_cadastro->__set('Nome', $_POST['nome']);
		$valida_cadastro->__set('Email', $_POST['email']);
		$valida_cadastro->__set('Senha', md5($_POST['senha']));
		
		if($valida_cadastro->validarSenha()){
			if($valida_cadastro->validarTamanhoSenha()){
				if(count($valida_cadastro->getUsuarioPorEmail())== 0){
					$valida_cadastro->salvar();

					session_start();
					$_SESSION['UserID'] = $valida_cadastro->valida_cadastro();

					$this->render('redirecionar_cadastro_endereco');	

				}else{
					header('Location: cadastro?cadastro=error3');
				};			
			}
		}


	}


	public function valida_endereco() {
		
		$valida_endereco = Container::getModel('valida_endereco');
		
		$valida_endereco->__set('UserID', $_SESSION['UserID'] ?? null);
		$valida_endereco->__set('CEP',$_POST['cep']);
		$valida_endereco->__set('Logradouro',$_POST['logradouro']);
		$valida_endereco->__set('Complemento',$_POST['complemento']);
		$valida_endereco->__set('Bairro',$_POST['bairro']);
		$valida_endereco->__set('Cidade',$_POST['cidade']);
		$valida_endereco->__set('Estado',$_POST['estado']);

		$endereco_completo = $_POST['logradouro'] . ', ' . ' - ' . $_POST['bairro'] . ', ' . $_POST['cidade'] . ' - ' . $_POST['estado'];

		$valida_endereco->__set('address', $endereco_completo);

		$urlMapa ="https://maps.googleapis.com/maps/api/geocode/json?address=". rawurlencode($endereco_completo)."&key=AIzaSyAo34cRORfhOHvHhQfnm1lMb1nMYyxcVko";
		
		$dadosMapa = file_get_contents($urlMapa);

		$dadosMapaDecodificados = json_decode($dadosMapa);

		foreach($dadosMapaDecodificados->results as $geometria){

		}
		  
		foreach($geometria->geometry as $localizacao){
		
		  if(isset($localizacao->lat))$latitude = $localizacao->lat;
		  if(isset($localizacao->lng))$longitude = $localizacao->lng;
		
		} 
	
		$valida_endereco->__set('lat',number_format($latitude, 2, '.', ''));
		$valida_endereco->__set('lng',number_format($longitude, 2, '.', ''));
 
		$valida_endereco->salvar();

		
		session_destroy();
		$this->render('redirecionar_login');	
		
	}


	public function modulo_meu_jardim() {

		$this->render('modulo_meu_jardim');
	}

	public function redirecionar_login() {

		$this->render('redirecionar_login');
	}

	public function redirecionar_cadastro_endereco() {

		$this->render('redirecionar_cadastro_endereco');
	}

	public function cadastro_endereco() {

		$this->render('cadastro_endereco');
	}

	
}


?>