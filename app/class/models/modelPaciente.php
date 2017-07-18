<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 17/07/17
 * Time: 22:00
 */

namespace app\models;

require_once 'modelAbstract.php';
require_once 'modelUsuario.php';
require_once 'modelEndereco.php';

class modelPaciente extends modelAbstract {
    protected $tableName = 'paciente';
    protected $campoId = 'cpf';
    protected $arAtributos = [
        'cpf' => null,
        'idusu' => null,
        'nome' => null,
        'datanascimento' => null,
        'rg' => null,
        'telres' => null,
        'telcel' => null,
        'telcom' => null,
        'idend' => null,
        'idpla' => null
    ];

    /**
     *  Função que salva as informações na tabela
     */
    public function save(){
        $paciente = $this->getById($this->arAtributos[$this->campoId]);
        if(empty($paciente)){
            $this->antesSave();
            $this->db->insert($this->tableName, $this->getCamposCarregados());
            $id = $this->db->lastInsertId();
            $this->arAtributos[$this->campoId] = $id;
        } else {
            $this->db->update($this->tableName, $this->getCamposCarregados(), [$this->campoId => $this->arAtributos[$this->campoId]]);
        }
        $this->depoisSave();
    }

    public function antesSave() {
        $data = explode('/', $this->arAtributos['datanascimento']);
        $this->arAtributos['datanascimento'] = $data[2].'-'.$data[1].'-'.$data[0];

        $email = $_REQUEST['email'];
        $senha = $_REQUEST['senha'];
        $usuario = new modelUsuario($this->app);
        $usuario->carregaDados([
            'email' => $email,
            'senha' => $senha,
            'tipo' => 'pac'
        ]);
        $usuario->save();
        $this->arAtributos['idusu'] = $usuario->idusu;

        $cep = $_REQUEST['cep'];
        $endereco = new modelEndereco($this->app);
        $endereco->carregaDados([
            'idusu' => $usuario->idusu,
            'cep' => $cep
        ]);
        $endereco->save();
        $this->arAtributos['idend'] = $endereco->idend;
    }
}