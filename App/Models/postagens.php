<?php

namespace App\Models;

use MF\Model\Model;

class postagens extends Model {
    private $UserID;
    private $Conteudo;
    private $TipoPostagem;
    private $DataPostagem;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    //salvar

    public function salvar(){

        $query = "insert into postagens(UserID, Conteudo, TipoPostagem)values(:UserID, :Conteudo, :TipoPostagem)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));
        $stmt->bindValue(':Conteudo', $this->__get('Conteudo'));
        $stmt->bindValue(':TipoPostagem', $this->__get('TipoPostagem'));
        $stmt->execute();

        return $this;

    }


    //recuperar

    public function getAll(){

        $query = "
        select 
            p.PostagemID, p.UserID, p.Conteudo, u.Nome, p.TipoPostagem, DATE_FORMAT(p.DataPostagem, '%d/%m/%Y %H:%i') as data,
            r.Conteudo as Conteudo_Resposta, r.UserID as UserID_resposta, c.Nome as nome_resposta, DATE_FORMAT(r.DataResposta, '%d/%m/%Y %H:%i') as data_resposta
        from 
            postagens as p
            left join usuarios as u on (p.UserID = u.UserID)
            left join respostas as r on (p.PostagemID = r.PostagemID)
            left join usuarios as c on (r.UserID = c.UserID)
        order by
            p.DataPostagem desc
    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function deletar_postagem() {
        // Primeiro deletar registros da tabela 'respostas'
        $queryRespostas = "DELETE FROM respostas WHERE PostagemID = :PostagemID";
        $stmtRespostas = $this->db->prepare($queryRespostas);
        $stmtRespostas->bindValue(':PostagemID', $this->__get('PostagemID'));
        $stmtRespostas->execute();
    
        // Depois deletar registros da tabela 'postagens'
        $queryPostagens = "DELETE FROM postagens WHERE PostagemID = :PostagemID";
        $stmtPostagens = $this->db->prepare($queryPostagens);
        $stmtPostagens->bindValue(':PostagemID', $this->__get('PostagemID'));
        $stmtPostagens->execute();
    
        return $this;
    }
    
    

    public function armazenar_comentario(){
        $query = "insert into respostas(PostagemID, UserID, Conteudo)values(:PostagemID, :UserID, :Conteudo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':PostagemID', $this->__get('PostagemID'));
        $stmt->bindValue(':Conteudo', $this->__get('Conteudo'));
        $stmt->bindValue(':UserID', $this->__get('UserID'));
        $stmt->execute();

        return $this;
    }
}