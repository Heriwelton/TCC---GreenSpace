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

		$routes['menu_inicial'] = array(
			'route' => '/menu_inicial',
			'controller' => 'indexController',
			'action' => 'menu_inicial'
		);

		$routes['valida_cadastro'] = array(
			'route' => '/valida_cadastro',
			'controller' => 'indexController',
			'action' => 'valida_cadastro'
		);

		$this->setRoutes($routes);
	}

}

?>