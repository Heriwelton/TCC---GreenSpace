<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'indexController',
			'action' => 'login'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'cadastro'
		);

		$routes['valida_cadastro'] = array(
			'route' => '/valida_cadastro',
			'controller' => 'indexController',
			'action' => 'valida_cadastro'
		);

		$routes['valida_endereco'] = array(
			'route' => '/valida_endereco',
			'controller' => 'indexController',
			'action' => 'valida_endereco'
		);

		$routes['redirecionar_login'] = array(
			'route' => '/redirecionar_login',
			'controller' => 'indexController',
			'action' => 'redirecionar_login'
		);

		$routes['redirecionar_cadastro_endereco'] = array(
			'route' => '/redirecionar_cadastro_endereco',
			'controller' => 'indexController',
			'action' => 'redirecionar_cadastro_endereco'
		);


		$routes['cadastro_endereco'] = array(
			'route' => '/cadastro_endereco',
			'controller' => 'indexController',
			'action' => 'cadastro_endereco'
		);

		$routes['valida_login'] = array(
			'route' => '/valida_login',
			'controller' => 'AuthController',
			'action' => 'valida_login'
		);

		$routes['modulo_meu_jardim'] = array(
			'route' => '/modulo_meu_jardim',
			'controller' => 'AppController',
			'action' => 'modulo_meu_jardim'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$this->setRoutes($routes);
	}

}

?>