<?php

namespace App\Models;

use MF\Model\Model;

class valida_plantacao extends Model {

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }
    
    public function salvar() {
        
        $query = "insert into produtos(NomeProduto, Imagem, Dica, Temp_recomendavel, Tempo_colheita, Tempo_regar, UserID)values(:Nome, :Imagem, :Dica, :Temp_recomendavel, :Tempo_colheita, :Tempo_regar, :UserID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':Nome', $this->__get('Nome'));
        $stmt->bindValue(':Imagem', $this->__get('Imagem'));
        $stmt->bindValue(':Dica', $this->__get('Dica'));     
        $stmt->bindValue(':Temp_recomendavel', $this->__get('temp_recomendavel')); 
        $stmt->bindValue(':Tempo_colheita', $this->__get('tempo_colheita')); 
        $stmt->bindValue(':Tempo_regar', $this->__get('tempo_regar')); 
        $stmt->bindValue(':UserID', $this->__get('UserID')); 
        $stmt->execute();
        return $this;

    }

    public function salvar_item_estoque() {
        $query = "insert into estoque(ProdutoID, Quantidade, DataPlantio, Ramo_principal, Produto_principal, UserID)values(:ProdutoID, :Quantidade, :Data_plantio, :Ramo, :Produto, :UserID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':ProdutoID', $this->__get('ProdutoID'));
        $stmt->bindValue(':Quantidade', $this->__get('Quantidade'));
        $stmt->bindValue(':Data_plantio', $this->__get('Data_plantio'));
        $stmt->bindValue(':Ramo', $this->__get('Ramo'));
        $stmt->bindValue(':Produto', $this->__get('Produto'));
        $stmt->bindValue(':UserID', $this->__get('UserID'));
        $stmt->execute();
        return $this;
    

    }

    public function editar_item_estoque(){

        $query ="UPDATE estoque
        SET 
            Quantidade = :Quantidade,
            DataPlantio = :DataPlantio,
            Ramo_principal = :Ramo,
            Produto_principal = :Produto
        WHERE EstoqueID = :EstoqueID AND UserID = :UserID";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':EstoqueID', $this->__get('EstoqueID'));
        $stmt->bindValue(':Quantidade', $this->__get('Quantidade'));
        $stmt->bindValue(':DataPlantio', $this->__get('Data_plantio'));
        $stmt->bindValue(':Ramo', $this->__get('Ramo'));
        $stmt->bindValue(':Produto', $this->__get('Produto'));
        $stmt->bindValue(':UserID', $this->__get('UserID'));
        $stmt->execute();
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

    public function oculta_item(){

        $query = "select ProdutoID from estoque where UserID = :UserID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));

        $stmt->execute();

        $itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->__set('produtoID_itens', $itens);


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

    public function excluir(){

        $query = "delete from produtos where ProdutoID = :ProdutoID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':ProdutoID', $this->__get('ProdutoID'));

        $stmt->execute();

        return $this;
    }

    public function excluir_estoque(){

        $query = "delete from estoque where EstoqueID = :EstoqueID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':EstoqueID', $this->__get('EstoqueID'));

        $stmt->execute();

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


}