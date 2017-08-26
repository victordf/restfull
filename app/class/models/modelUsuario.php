<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16/07/17
 * Time: 16:35
 */

namespace app\models;

require_once 'modelAbstract.php';

class modelUsuario extends modelAbstract {
    protected $tableName = 'usuario';
    protected $campoId = 'id';
    protected $arAtributos = [
        'id' => null,
        'nome' => null,
        'email' => null,
        'senha' => null
    ];

    public function getByEmailSenha($email, $senha){
        global $encoder;
//        $senha = md5($senha);
        $sql = <<<SQL
          SELECT * FROM {$this->tableName} WHERE email = '{$email}' AND senha = '$senha'
SQL;
        $retorno = $this->db->fetchAll($sql);
        return empty($retorno) ? [] : $retorno[0];
    }

    public function antesSave(){
        global $encoder;
//        $this->arAtributos['senha'] = $encoder->encodePassword($this->arAtributos['senha'], '');
        $this->arAtributos['senha'] = md5($this->arAtributos['senha']);
    }
}