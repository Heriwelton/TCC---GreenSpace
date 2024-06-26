<?php

namespace App\Models;

use MF\Model\Model;

class valida_cadastro extends Model {

    private $UserID;
    private $Nome;
    private $Email;
    Private $Senha;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function salvar() {
        
        $query = "insert into usuarios(Nome, Email, Senha)values(:Nome, :Email, :Senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':Nome', $this->__get('Nome'));
        $stmt->bindValue(':Email', $this->__get('Email'));
        $stmt->bindValue(':Senha', $this->__get('Senha'));     
        $stmt->execute();
        return $this;

    }

    //Confere se 'senha' e 'confirmar_senha' estão iguais
    public function validarSenha(){
        $valido = true;

        if(!($this->__get('Senha') == md5($_POST["confirmar_senha"]))){
            header('Location: cadastro?cadastro=error1');
        }

        return $valido;
    }

    //verifica se a senha digita contem no minimo 8 caracteres

    public function validarTamanhoSenha(){
        $valido = true;

        if(strlen($this->__get('Senha')) < 9){
            header('Location: cadastro?cadastro=error2');
        }

        return $valido;
    }

    /*recuperar um usuário por email*/

    public function getUsuarioPorEmail(){
        $query = "select Nome, Email from usuarios where email = :Email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':Email', $this->__get('Email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function valida_login(){

        $query = "
        select 
            UserID, Nome, Email from usuarios 
        where 
            email = :Email and Senha = :Senha";

            
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':Email', $this->__get('Email'));
        $stmt->bindValue(':Senha', $this->__get('Senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['UserID'] != '' && $usuario['Nome'] != '' ){
            $this->__set('UserID', $usuario['UserID']);
            $this->__set('Nome', $usuario['Nome']);
        }

        return $this;
    }

    public function seleciona_lgn_lat(){

        $query = "select lat, lng from enderecos where UserID = :UserID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));

        $stmt->execute();

        $geocalizacao = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($geocalizacao['lat'] != '' && $geocalizacao['lng'] != ''){
            $this->__set('lat', $geocalizacao['lat']);
            $this->__set('lng', $geocalizacao['lng']);
        }

        return $this;
    }

    public function seleciona_itens(){
        // Query para selecionar os itens do usuário
        $query = "SELECT 
                    ProdutoID, 
                    NomeProduto, 
                    Imagem, 
                    Dica, 
                    Temp_recomendavel, 
                    Tempo_colheita, 
                    Tempo_regar 
                FROM 
                    produtos 
                WHERE 
                    UserID = :UserID";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));
        $stmt->execute();
        $itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        // Query para selecionar um conteúdo aleatório de postagens do tipo "curiosidade" do mesmo usuário
        $subquery = "SELECT 
                        conteudo 
                    FROM 
                        postagens 
                    WHERE 
                        TipoPostagem = 'curiosidade' 
                        AND UserID = :UserID 
                    ORDER BY 
                        RAND() 
                    LIMIT 1";
    
        $stmt_sub = $this->db->prepare($subquery);
        $stmt_sub->bindValue(':UserID', $this->__get('UserID'));
        $stmt_sub->execute();
        $conteudo_curiosidade = $stmt_sub->fetchColumn();
    
        // Adiciona o conteúdo de curiosidade aos itens do usuário
        foreach ($itens as &$item) {
            $item['Dica_forum'] = $conteudo_curiosidade;
        }
    
        // Define os itens e retorna o objeto
        $this->__set('itens', $itens);
        return $this;
    }

    public function seleciona_itens_estoque(){

        $query = "select EstoqueID, ProdutoID, Quantidade, DataPlantio, Ramo_principal, Produto_principal from estoque where UserID = :UserID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));

        $stmt->execute();

        $itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->__set('itens_estoque', $itens);

        return $this;
    }


    public function seleciona_vendedores() {
        // Consulta unificada para obter dados de estoque, usuários e imagem do produto
        $query = "
            SELECT 
                e.EstoqueID, 
                e.ProdutoID, 
                e.Quantidade, 
                e.DataPlantio, 
                e.Ramo_principal, 
                e.Produto_principal,
                p.Imagem, 
                u.Nome, 
                u.Email 
            FROM estoque e
            JOIN usuarios u ON e.UserID = u.UserID
            JOIN produtos p ON e.ProdutoID = p.ProdutoID
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Armazenar o resultado na propriedade 'vendedores'
        $this->__set('vendedores', $itens);
        
        return $this;
    }
    
    
    


    public function valida_cadastro(){

        $query = "SELECT UserID FROM usuarios WHERE Email = :Email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':Email', $this->__get('Email'));
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result['UserID'];
        } else {
            return null; 
        }
    }

    public function oculta_item(){

        $query = "select ProdutoID from estoque where UserID = :UserID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));

        $stmt->execute();

        $itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->__set('produtoID_itens', $itens);


        return $this;
    }

}

?>