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

        if(!($this->__get('Senha') == $_POST["confirmar_senha"])){
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

}

?>