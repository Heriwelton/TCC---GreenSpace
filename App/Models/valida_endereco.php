<?php

namespace App\Models;

use MF\Model\Model;

session_start();


class valida_endereco extends Model {

    private $EnderecoID;
    private $UserID;
    private $CEP;
    private $Logradouro;
    Private $Complemento;
    private $Bairro;
    private $Cidade;
    private $Estado;
    private $address;
    private $lat;
    private $lng;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }


    public function salvar() {

        $query = "insert into enderecos(UserID, CEP, Logradouro, Complemento, Bairro, Cidade, Estado, address, lat, lng)values(:UserID, :CEP, :Logradouro, :Complemento, :Bairro, :Cidade, :Estado, :address, :lat, :lng)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':UserID', $this->__get('UserID'));
        $stmt->bindValue(':CEP', $this->__get('CEP'));
        $stmt->bindValue(':Logradouro', $this->__get('Logradouro'));
        $stmt->bindValue(':Complemento', $this->__get('Complemento')); 
        $stmt->bindValue(':Bairro', $this->__get('Bairro')); 
        $stmt->bindValue(':Cidade', $this->__get('Cidade')); 
        $stmt->bindValue(':Estado', $this->__get('Estado'));     
        $stmt->bindValue(':address', $this->__get('address'));
        $stmt->bindValue(':lat', $this->__get('lat'));
        $stmt->bindValue(':lng', $this->__get('lng'));
        $stmt->execute();
        return $this;


        
    }



}

?>