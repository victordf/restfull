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
        'nome' => null,
        'user' => null,
        'senha' => null
    ];
}