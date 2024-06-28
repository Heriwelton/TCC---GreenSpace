<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {


	public function valida_login() {
		$usuario = Container::getModel('valida_cadastro');
	
		$usuario->__set('Email', $_POST['email']);
		$usuario->__set('Senha', md5($_POST['senha']));
	
		$usuario->valida_login();
		$usuario->seleciona_lgn_lat();
		$usuario->seleciona_itens();
		$usuario->seleciona_itens_estoque();
		$usuario->seleciona_vendedores();
		$usuario->oculta_item(); 
	
		if ($usuario->__get('UserID') != '' && $usuario->__get('Nome') != '') {
			echo 'autenticado';
			
			session_start();
	
			$_SESSION['UserID'] = $usuario->__get('UserID');
			$_SESSION['Nome'] = $usuario->__get('Nome');
			$_SESSION['itens'] = $usuario->__get('itens');
			$_SESSION['produtoID_itens'] = $usuario->__get('produtoID_itens');
			$_SESSION['itens_estoque'] = $usuario->__get('itens_estoque');
			$_SESSION['vendedores'] = $usuario->__get('vendedores');
			// Extrai ProdutoIDs de $_SESSION['produtoID_itens'] para um array simples
			$produtoIDs = array_map(function($produto) {
				return $produto['ProdutoID'];
			}, $_SESSION['produtoID_itens']);
	
			// Certifique-se de que $_SESSION['itens'] está definido antes de filtrar
			if (isset($_SESSION['itens'])) {
				// Filtra os itens para remover aqueles que têm ProdutoID presente em $produtoIDs
				$_SESSION['itens'] = array_filter($_SESSION['itens'], function($currentItem) use ($produtoIDs) {
					return !in_array($currentItem['ProdutoID'], $produtoIDs);
				});
	
				// Reindexa o array para evitar problemas com índices não sequenciais
				$_SESSION['itens'] = array_values($_SESSION['itens']);
			}
	
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
			
			if (!$_SESSION['itens']) {
				header('Location: /modulo_meu_jardim?empty_flow');
			} else {
				header('Location: /modulo_meu_jardim');
			}
	
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