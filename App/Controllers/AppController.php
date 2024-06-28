<?php

namespace App\Controllers;

session_start();

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function modulo_meu_jardim(){
        

        if($_SESSION['UserID'] != '' && $_SESSION['Nome'] != ''){
            $this->render('modulo_meu_jardim');

            

        } else{
            header('Location:login?login=error2');
        }
        
    }

    public function modulo_meu_comercio(){
        $this->render('modulo_meu_comercio');   

    }

    

    public function modulo_vendedores(){
        $this->render('modulo_vendedores');   

    }


    //Módulo meu jardim

    public function nova_plantacao() {
        header('location:modulo_meu_jardim?new_planting');
    }

    public function categoria_flores() {
        header('location:modulo_meu_jardim?category_flowers');
    }

    public function categoria_vegetais() {
        header('location:modulo_meu_jardim?category_vegetables');
    }

    public function categoria_frutas() {
        header('location:modulo_meu_jardim?category_fruit');
    }

    public function variante_flores_rosa() {
        header('location:modulo_meu_jardim?variante_flores_rosa');
    }

    public function variante_flores_margarida() {
        header('location:modulo_meu_jardim?variante_flores_margarida');
    }

    public function variante_flores_tulipa() {
        header('location:modulo_meu_jardim?variante_flores_tulipa');
    }

    public function variante_flores_jasmim() {
        header('location:modulo_meu_jardim?variante_flores_jasmim');
    }

    public function variante_flores_lirio() {
        header('location:modulo_meu_jardim?variante_flores_lirio');
    }

    public function variante_flores_girassol() {
        header('location:modulo_meu_jardim?variante_flores_girassol');
    }

    public function variante_flores_orquidea() {
        header('location:modulo_meu_jardim?variante_flores_orquidea');
    }

    public function variante_vegetais_berinjela() {
        header('location:modulo_meu_jardim?variante_vegetais_berinjela');
    }

    public function variante_vegetais_pepino() {
        header('location:modulo_meu_jardim?variante_vegetais_pepino');
    }

    public function variante_vegetais_abobora() {
        header('location:modulo_meu_jardim?variante_vegetais_abobora');
    }

    public function variante_vegetais_feijao() {
        header('location:modulo_meu_jardim?variante_vegetais_feijao');
    }

    public function variante_vegetais_pimentao() {
        header('location:modulo_meu_jardim?variante_vegetais_pimentao');
    }

    public function variante_vegetais_batata() {
        header('location:modulo_meu_jardim?variante_vegetais_batata');
    }

    public function variante_vegetais_cenoura() {
        header('location:modulo_meu_jardim?variante_vegetais_cenoura');
    }

    public function variante_frutas_acerola() {
        header('location:modulo_meu_jardim?variante_frutas_acerola');
    }

    public function variante_frutas_laranja() {
        header('location:modulo_meu_jardim?variante_frutas_laranja');
    }

    public function variante_frutas_limao() {
        header('location:modulo_meu_jardim?variante_frutas_limao');
    }

    public function variante_frutas_maca() {
        header('location:modulo_meu_jardim?variante_frutas_maca');
    }

    public function variante_frutas_abacaxi() {
        header('location:modulo_meu_jardim?variante_frutas_abacaxi');
    }

    public function variante_frutas_caqui() {
        header('location:modulo_meu_jardim?variante_frutas_caqui');
    }

    public function variante_frutas_carambola() {
        header('location:modulo_meu_jardim?variante_frutas_carambola');
    }

    public function salvar_item() {
        if(isset($_GET['nome']) && isset($_GET['imagem']) && isset($_GET['dica']) && isset($_GET['temp_recomendavel']) && isset($_GET['tempo_colheita']) && isset($_GET['tempo_regar'])) {   
            
            // formatando a colheita
            $tempo_colheita = $_GET['tempo_colheita'];
            $tempo_colheita_array = explode(',', $tempo_colheita);

            $tempo_colheita_visivel = $tempo_colheita_array[0];
            $tempo_colheita_api = $tempo_colheita_array[1];

            // Define o fuso horário para garantir que a data/hora esteja correta
            date_default_timezone_set('America/Sao_Paulo');

            // Cria um objeto DateTime com a data e hora atuais
            $dataAtual = new \DateTime();

            $dataCriacao = new \DateTime();

            // Adiciona três meses à data atual
            $dataAtual->modify($tempo_colheita_api);

            // Formata a data resultante no formato desejado
            $dataFutura = $dataAtual->format('d/m/Y');

            $data_formatada_bd = $tempo_colheita . "," . $dataCriacao->format('d/m/Y') . "," . $dataFutura;

            

            $item = Container::getModel('valida_plantacao');
            $item->__set('Nome', $_GET['nome']);
            $item->__set('Imagem',$_GET['imagem']);
            $item->__set('Dica', $_GET['dica']);
            $item->__set('temp_recomendavel', $_GET['temp_recomendavel']);
            $item->__set('tempo_colheita', $data_formatada_bd);
            $item->__set('tempo_regar', $_GET['tempo_regar']);
            $item->__set('UserID', $_SESSION['UserID']);
            $item->salvar();

            $item->seleciona_itens();
            $item->seleciona_itens_estoque();
            $item->oculta_item();

            $_SESSION['itens'] = $item->__get('itens'); 
            $_SESSION['produtoID_itens'] = $item->__get('produtoID_itens');
            $_SESSION['itens_estoque'] = $item->__get('itens_estoque');
    
            // Extrair ProdutoIDs de $_SESSION['produtoID_itens'] para um array simples
            $produtoIDs = array_map(function($produto) {
                return $produto['ProdutoID'];
            }, $_SESSION['produtoID_itens']);
    

            // Certifique-se de que $_SESSION['itens'] está definido antes de filtrar
            if (isset($_SESSION['itens'])) {
                $_SESSION['itens'] = array_filter($_SESSION['itens'], function($currentItem) use ($produtoIDs) {
                    return !in_array($currentItem['ProdutoID'], $produtoIDs);
                });
    
                // Reindexar o array para evitar problemas com índices não sequenciais
                $_SESSION['itens'] = array_values($_SESSION['itens']);
            }


            
            header('Location: /modulo_meu_jardim');
        }


    }

    public function excluir_item() {
        if(isset($_POST['ProdutoID'])){
            
            $item = Container::getModel('valida_plantacao');
            $item->__set('ProdutoID', $_POST['ProdutoID']);
            $item->__set('UserID', $_SESSION['UserID']);

            $item->excluir();
            $item->seleciona_itens();
            $_SESSION['itens'] = $item->__get('itens');

            
            if(empty($_SESSION['itens'])){
                header('Location: /modulo_meu_jardim?empty_flow');
            }else{
                header('Location: /modulo_meu_jardim');
            }
            
        }
    }

    public function excluir_item_estoque() {
        if (isset($_POST['EstoqueID'])) {
            
            $item = Container::getModel('valida_plantacao');
            $item->__set('EstoqueID', $_POST['EstoqueID']);
            $item->__set('UserID', $_SESSION['UserID']);
    
            // Executa a exclusão do item no estoque
            $item->excluir_estoque();
    
            // Atualiza a lista de itens no estoque e oculta itens se necessário
            $item->seleciona_itens_estoque();
            $item->oculta_item();
            
            // Atualiza as sessões com os itens de estoque atualizados
            $_SESSION['produtoID_itens'] = $item->__get('produtoID_itens');
            $_SESSION['itens_estoque'] = $item->__get('itens_estoque');
    
            // Extrai ProdutoIDs de $_SESSION['produtoID_itens'] para um array simples
            $produtoIDs = array_map(function($produto) {
                return $produto['ProdutoID'];
            }, $_SESSION['produtoID_itens']);
    
            // Verifica se $_SESSION['itens'] está definido antes de realizar a filtragem
            if (isset($_SESSION['itens'])) {
                // Filtra os itens para manter apenas aqueles que não têm ProdutoID presente em $produtoIDs
                $_SESSION['itens'] = array_filter($_SESSION['itens'], function($currentItem) use ($produtoIDs) {
                    return !in_array($currentItem['ProdutoID'], $produtoIDs);
                });
    
                // Reindexa o array para evitar problemas com índices não sequenciais
                $_SESSION['itens'] = array_values($_SESSION['itens']);
            }
    
            // Redireciona para evitar reenvio de formulário
            header('Location: /modulo_meu_comercio?user_stock');
            exit;
        }
    }
    
    
    

    //Módulo meu comércio

    public function processar_item() {
        if(isset($_POST['NomeProduto']) && isset($_POST['DataInicial']) && isset($_POST['ProdutoID'])){
            
            $item = Container::getModel('valida_plantacao');
            $item->__set('ProdutoID', $_POST['ProdutoID']);
            $item->__set('UserID', $_SESSION['UserID']);
            $item->__set('NomeProduto', $_POST['NomeProduto']);
            $item->__set('DataInicial', $_POST['DataInicial']);

            
        
            

        }
    }

    public function editar_item_estoque() {
        $_SESSION['item_estoque'] = [
            'produto' => $_POST['produto'],
            'quantidade' => $_POST['quantidade'],
            'dataPlantio' => $_POST['dataPlantio'],
            'EstoqueID' => $_POST['EstoqueID']
        ];

        header('Location: /modulo_meu_comercio?edit_stock');
    }

    public function salvar_estoque() {
        if (isset($_POST["produtoid"]) && isset($_POST["quantidade"]) && isset($_POST["data_plantio"]) && isset($_POST["ramo"]) && isset($_POST["produto"]) && isset($_SESSION["UserID"])) {
    
            $item = Container::getModel('valida_plantacao');
            $item->__set('ProdutoID', $_POST["produtoid"]);
            $item->__set('Quantidade', $_POST["quantidade"]);
            $item->__set('Data_plantio', $_POST["data_plantio"]);
            $item->__set('Ramo', $_POST["ramo"]);
            $item->__set('Produto', $_POST["produto"]);
            $item->__set('UserID', $_SESSION['UserID']);
    
            $item->salvar_item_estoque();
            $item->seleciona_vendedores();
            $item->seleciona_itens_estoque();
            $item->oculta_item();
            $_SESSION['vendedores'] = $item->__get('vendedores');
            $_SESSION['produtoID_itens'] = $item->__get('produtoID_itens');
            $_SESSION['itens_estoque'] = $item->__get('itens_estoque');
    
            // Extrair ProdutoIDs de $_SESSION['produtoID_itens'] para um array simples
            $produtoIDs = array_map(function($produto) {
                return $produto['ProdutoID'];
            }, $_SESSION['produtoID_itens']);
    

            // Certifique-se de que $_SESSION['itens'] está definido antes de filtrar
            if (isset($_SESSION['itens'])) {
                $_SESSION['itens'] = array_filter($_SESSION['itens'], function($currentItem) use ($produtoIDs) {
                    return !in_array($currentItem['ProdutoID'], $produtoIDs);
                });
    
                // Reindexar o array para evitar problemas com índices não sequenciais
                $_SESSION['itens'] = array_values($_SESSION['itens']);
            }
       
    
            // Redirecionar para evitar reenvio de formulário
            header('Location: /modulo_meu_comercio?user_stock');
            exit;
        }
    }


    public function editar_estoque() {
        
        if (isset($_POST["estoqueid"]) && isset($_POST["produto"]) && isset($_POST["quantidade"]) && isset($_POST["ramo"]) && isset($_POST["data_plantio"]) && isset($_SESSION["UserID"])) {
    
            $item = Container::getModel('valida_plantacao');
            $item->__set('EstoqueID', $_POST["estoqueid"]);
            $item->__set('Quantidade', $_POST["quantidade"]);
            $item->__set('Data_plantio', $_POST["data_plantio"]);
            $item->__set('Ramo', $_POST["ramo"]);
            $item->__set('Produto', $_POST["produto"]);
            $item->__set('UserID', $_SESSION['UserID']);
    
            $item->editar_item_estoque();

            $item->seleciona_itens_estoque();
            $item->oculta_item();
            $_SESSION['produtoID_itens'] = $item->__get('produtoID_itens');
            $_SESSION['itens_estoque'] = $item->__get('itens_estoque');
    
            $produtoIDs = array_map(function($produto) {
                return $produto['ProdutoID'];
            }, $_SESSION['produtoID_itens']);
    

            if (isset($_SESSION['itens'])) {
                $_SESSION['itens'] = array_filter($_SESSION['itens'], function($currentItem) use ($produtoIDs) {
                    return !in_array($currentItem['ProdutoID'], $produtoIDs);
                });
    
                $_SESSION['itens'] = array_values($_SESSION['itens']);
            }
       
            $_SESSION['alert_message'] = "Estoque editado com sucesso!";
    
            header('Location: /modulo_meu_comercio?user_stock');
            exit;
        }

    }
    
    
    

    //Módulo comunidade

    public function modulo_comunidade(){
        
        $this->validaAutenticacao();
        //recuperação das postagens
        $postagem = Container::getModel('postagens');

        $postagem->__set('UserID', $_SESSION['UserID']);

        $postagens = $postagem->getAll();


        $this->view->postagens = $postagens;

        $this->render('modulo_comunidade');   

         
    } 

    public function postagem() {

        $this->validaAutenticacao();
        
        $postagem = Container::getModel('postagens');

        $postagem->__set('Conteudo', $_POST['texto_postagem']);
        $postagem->__set('TipoPostagem', $_POST['tipo_postagem']);
        $postagem->__set('UserID', $_SESSION['UserID']);

        $postagem->salvar();

        header('location: /modulo_comunidade');

            
 
        
    }

    public function excluir_postagem(){

        $postagem = Container::getModel('postagens');

        $postagem->__set('PostagemID', $_POST['postagemid']);

        $postagem->deletar_postagem();

        header('location: /modulo_comunidade');
    }


    public function salvar_comentario(){
        $postagem = Container::getModel('postagens');
        $postagem->__set('PostagemID', $_POST['postagemid']);
        $postagem->__set('Conteudo', $_POST['texto_comentario']);
        $postagem->__set('UserID', $_SESSION['UserID']);

        $postagem->armazenar_comentario();

        header('location: /modulo_comunidade');

    }

    public function salvar_curtida(){
        $postagem = Container::getModel('postagens');
        $postagem->__set('PostagemID', $_POST['postagemid']);
        $postagem->__set('UserID', $_SESSION['UserID']);

        $postagem->armazenar_curtida();

        header('location: /modulo_comunidade');
    }

    public function validaAutenticacao(){
        

        if(!isset($_SESSION['UserID']) || $_SESSION['UserID'] == '' || !isset($_SESSION['Nome']) || $_SESSION['Nome'] == ''){
            header('Location:login?login=error2');
        } 
    }
}