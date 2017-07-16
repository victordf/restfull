<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16/07/17
 * Time: 16:23
 */

namespace app\models;

abstract class modelAbstract {

    /**
     * @var string - Nome da tabela
     */
    protected $tableName;

    /**
     * @var string - Campo ID da tabela
     */
    protected $campoId;

    /**
     * @var array - Atributos da tabela
     */
    protected $arAtributos;

    protected $db;

    public function __construct(\Silex\Application $app){
        $this->db = $app['db'];
    }

    public function __set($name, $value){
        if(isset($this->arAtributos[$name])) {
            $this->arAtributos[$name] = $value;
        }
    }

    public function __get($name) {
        return $this->arAtributos[$name];
    }

    /**
     *  Função que salva as informações na tabela
     */
    public function save(){
        if(!$this->arAtributos[$this->campoId]){
            $this->db->insert($this->tableName, $this->arAtributos);
            $id = $this->db->lastInsertId();
            $this->arAtributos[$this->campoId] = $id;
        } else {
            $this->db->update($this->tableName, $this->arAtributos, [$this->campoId => $this->arAtributos[$this->campoId]]);
        }
    }

    /**
     *  Retorna o registro pelo ID
     *
     * @param null $id
     * @return mixed
     */
    public function getById($id = null){
        $colunas = implode(', ',array_keys($this->arAtributos));
        $id = empty($id) ? $this->arAtributos[$this->campoId] : $id;
        $sql = <<<SQL
          SELECT {$colunas} FROM {$this->tableName} WHERE {$this->campoId} = {$id}
SQL;
        return $this->db->fetchAll($sql);
    }

    /**
     *  Função que carrega as informações de um array nos campos da model.
     *
     * @param array $dados
     */
    public function carregaDados($dados = []){
        foreach ($dados as $key => $val) {
            $this->arAtributos[$key] = $val;
        }
    }

}