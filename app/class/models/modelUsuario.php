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
    protected $campoId = 'idusu';
    protected $arAtributos = [
        'idusu' => null,
        'email' => null,
        'senha' => null,
        'tipo' => null
    ];

    public function antesSave(){
        global $encoder;
        $this->arAtributos['senha'] = $encoder->encodePassword($this->arAtributos['senha'], '');
    }
}