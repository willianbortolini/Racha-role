<?php
namespace app\models\dao;
use app\core\Model;

class Dao extends Model{   
    
    protected $table;
    
    public function getDBConnection(){
        return  $this->db;
    } 
    
    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->getDBConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function lista($tabela, $ordem){
        return  $this->all($this->db, $tabela, $ordem);
    }        
    /*public function get($tabela, $campo, $valor, $eh_lista, $ordem){
        return  $this->find($this->db,$campo, $valor, $tabela, $eh_lista, $ordem);
    } */

    public function colunasDaTabela($tabela){
        return  $this->colunas($this->db,$tabela);
    } 

    public function getEnumValues($tabela, $campo){
        return  $this->enumValues($this->db, $tabela, $campo);
    } 
    

    public function getJoin($tabela, $campo, $valor,$joins, $eh_lista){
        return  $this->findJoin($this->db,$campo, $valor, $tabela,$joins, $eh_lista);
    } 
    
    public function getGeral($tabela, $campo, $operador, $valor, $eh_lista){
        return  $this->findGeral($this->db,$campo,$operador, $valor, $tabela, $eh_lista);
    }    
    
    public function getEntre($tabela, $campo, $valor1, $valor2){
        return  $this->findEntre($this->db,$campo, $valor1, $valor2, $tabela);
    } 
    
    public function getLike($tabela, $campo, $valor, $eh_lista, $posicao){
        return  $this->findlike($this->db,$campo, $valor, $tabela, $eh_lista, $posicao);
    }
        
    public function getTotal($tabela, $campoAgregacao, $campo, $valor){
        return  $this->findAgrega($this->db, 'total', $campoAgregacao, $tabela,$campo, $valor);
    }
    
    public function getSoma($tabela, $campoAgregacao, $campo, $valor){
        return  $this->findAgrega($this->db, 'soma', $campoAgregacao, $tabela,$campo, $valor);
    }
    
    public function getMaximo($tabela, $campoAgregacao, $campo, $valor){
        return  $this->findAgrega($this->db, 'max', $campoAgregacao, $tabela,$campo, $valor);
    }
    
    public function getMinimo($tabela, $campoAgregacao, $campo, $valor){
        return  $this->findAgrega($this->db, 'min', $campoAgregacao, $tabela,$campo, $valor);
    }
    
    public function getMedia($tabela, $campoAgregacao, $campo, $valor){
        return  $this->findAgrega($this->db, 'media', $campoAgregacao, $tabela,$campo, $valor);
    }
    public function inserir( $valores, $tabela){
        return $this->add($this->db,  $valores, $tabela);
    }
    
    public function editar( $valores, $campo, $tabela){
        return $this->edit($this->db,  $valores,  $campo, $tabela);
    }
    
    public function excluir($tabela, $campo, $valor){
        return $this->del($this->db, $campo ,$valor , $tabela);
    }
}

