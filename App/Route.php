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

		$routes['modulo_meu_comercio'] = array(
			'route' => '/modulo_meu_comercio',
			'controller' => 'AppController',
			'action' => 'modulo_meu_comercio'
		);

		$routes['modulo_comunidade'] = array(
			'route' => '/modulo_comunidade',
			'controller' => 'AppController',
			'action' => 'modulo_comunidade'
		);

		$routes['modulo_vendedores'] = array(
			'route' => '/modulo_vendedores',
			'controller' => 'AppController',
			'action' => 'modulo_vendedores'
		);

		$routes['nova_plantacao'] = array(
			'route' => '/nova_plantacao',
			'controller' => 'AppController',
			'action' => 'nova_plantacao'
		);

		$routes['categoria_flores'] = array(
			'route' => '/categoria_flores',
			'controller' => 'AppController',
			'action' => 'categoria_flores'
		);

		$routes['categoria_vegetais'] = array(
			'route' => '/categoria_vegetais',
			'controller' => 'AppController',
			'action' => 'categoria_vegetais'
		);

		$routes['categoria_frutas'] = array(
			'route' => '/categoria_frutas',
			'controller' => 'AppController',
			'action' => 'categoria_frutas'
		);

		$routes['variante_flores_rosa'] = array(
			'route' => '/variante_flores_rosa',
			'controller' => 'AppController',
			'action' => 'variante_flores_rosa'
		);

		$routes['variante_flores_margarida'] = array(
			'route' => '/variante_flores_margarida',
			'controller' => 'AppController',
			'action' => 'variante_flores_margarida'
		);

		$routes['variante_flores_tulipa'] = array(
			'route' => '/variante_flores_tulipa',
			'controller' => 'AppController',
			'action' => 'variante_flores_tulipa'
		);

		$routes['variante_flores_jasmim'] = array(
			'route' => '/variante_flores_jasmim',
			'controller' => 'AppController',
			'action' => 'variante_flores_jasmim'
		);

		$routes['variante_flores_lirio'] = array(
			'route' => '/variante_flores_lirio',
			'controller' => 'AppController',
			'action' => 'variante_flores_lirio'
		);

		$routes['variante_flores_girassol'] = array(
			'route' => '/variante_flores_girassol',
			'controller' => 'AppController',
			'action' => 'variante_flores_girassol'
		);

		$routes['variante_flores_orquidea'] = array(
			'route' => '/variante_flores_orquidea',
			'controller' => 'AppController',
			'action' => 'variante_flores_orquidea'
		);

		$routes['variante_vegetais_berinjela'] = array(
			'route' => '/variante_vegetais_berinjela',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_berinjela'
		);

		$routes['variante_vegetais_pepino'] = array(
			'route' => '/variante_vegetais_pepino',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_pepino'
		);

		$routes['variante_vegetais_abobora'] = array(
			'route' => '/variante_vegetais_abobora',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_abobora'
		);

		$routes['variante_vegetais_feijao'] = array(
			'route' => '/variante_vegetais_feijao',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_feijao'
		);

		$routes['variante_vegetais_pimentao'] = array(
			'route' => '/variante_vegetais_pimentao',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_pimentao'
		);

		$routes['variante_vegetais_batata'] = array(
			'route' => '/variante_vegetais_batata',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_batata'
		);

		$routes['variante_vegetais_cenoura'] = array(
			'route' => '/variante_vegetais_cenoura',
			'controller' => 'AppController',
			'action' => 'variante_vegetais_cenoura'
		);

		$routes['variante_frutas_acerola'] = array(
			'route' => '/variante_frutas_acerola',
			'controller' => 'AppController',
			'action' => 'variante_frutas_acerola'
		);

		$routes['variante_frutas_laranja'] = array(
			'route' => '/variante_frutas_laranja',
			'controller' => 'AppController',
			'action' => 'variante_frutas_laranja'
		);

		$routes['variante_frutas_limao'] = array(
			'route' => '/variante_frutas_limao',
			'controller' => 'AppController',
			'action' => 'variante_frutas_limao'
		);

		$routes['variante_frutas_maca'] = array(
			'route' => '/variante_frutas_maca',
			'controller' => 'AppController',
			'action' => 'variante_frutas_maca'
		);

		$routes['variante_frutas_abacaxi'] = array(
			'route' => '/variante_frutas_abacaxi',
			'controller' => 'AppController',
			'action' => 'variante_frutas_abacaxi'
		);

		$routes['variante_frutas_caqui'] = array(
			'route' => '/variante_frutas_caqui',
			'controller' => 'AppController',
			'action' => 'variante_frutas_caqui'
		);

		$routes['variante_frutas_carambola'] = array(
			'route' => '/variante_frutas_carambola',
			'controller' => 'AppController',
			'action' => 'variante_frutas_carambola'
		);

		$routes['salvar_item'] = array(
			'route' => '/salvar_item',
			'controller' => 'AppController',
			'action' => 'salvar_item'
		);

		$routes['excluir_item'] = array(
			'route' => '/excluir_item',
			'controller' => 'AppController',
			'action' => 'excluir_item'
		);

		$routes['processar_item'] = array(
			'route' => '/processar_item',
			'controller' => 'AppController',
			'action' => 'modulo_meu_comercio'
		);

		$routes['salvar_estoque'] = array(
			'route' => '/salvar_estoque',
			'controller' => 'AppController',
			'action' => 'salvar_estoque'
		);

		$routes['excluir_item_estoque'] = array(
			'route' => '/excluir_item_estoque',
			'controller' => 'AppController',
			'action' => 'excluir_item_estoque'
		);

		$routes['postagem'] = array(
			'route' => '/postagem',
			'controller' => 'AppController',
			'action' => 'postagem'
		);

		$routes['excluir_postagem'] = array(
			'route' => '/excluir_postagem',
			'controller' => 'AppController',
			'action' => 'excluir_postagem'
		);

		$routes['salvar_comentario'] = array(
			'route' => '/salvar_comentario',
			'controller' => 'AppController',
			'action' => 'salvar_comentario'
		);

		$routes['editar_item_estoque'] = array(
			'route' => '/editar_item_estoque',
			'controller' => 'AppController',
			'action' => 'editar_item_estoque'
		);

		$routes['editar_estoque'] = array(
			'route' => '/editar_estoque',
			'controller' => 'AppController',
			'action' => 'editar_estoque'
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