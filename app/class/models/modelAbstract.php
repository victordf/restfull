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

    protected $app;
    protected $db;

    public function __construct(\Silex\Application $app){
        $this->app = $app;
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
            $this->antesSave();
            $this->db->insert($this->tableName, $this->getCamposCarregados());
            $id = $this->db->lastInsertId();
            $this->arAtributos[$this->campoId] = $id;
        } else {
            $this->db->update($this->tableName, $this->getCamposCarregados(), [$this->campoId => $this->arAtributos[$this->campoId]]);
        }
        $this->depoisSave();
    }

    /**
     *  Função executada antes do salvar.
     */
    public function antesSave(){
        // Substituir esta função na classe filho
    }

    /**
     *  Função executada depois do salvar.
     */
    public function depoisSave(){
        // Substituir esta função na classe filho
    }

    public function getCamposCarregados(){
        $ar = [];
        foreach ($this->arAtributos as $key => $valor) {
            if(!empty($valor)){
                $ar[$key] = $valor;
            }
        }
        return $ar;
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
        $where = "";
        if(!empty($id)){
            $where = "WHERE {$this->campoId} = '{$id}'";
        }
        $sql = <<<SQL
          SELECT {$colunas} FROM {$this->tableName} {$where}
SQL;
        return $this->db->fetchAll($sql)[0];
    }

    /**
     *  Função que carrega as informações de um array nos campos da model.
     *
     * @param array $dados
     */
    public function carregaDados($dados = []){
        foreach ($dados as $key => $val) {
            if(array_key_exists($key, $this->arAtributos)) {
                $this->arAtributos[$key] = $val;
            }
        }
    }

}