<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 17/07/17
 * Time: 21:58
 */

namespace app\models;

require_once 'modelAbstract.php';

class modelEndereco extends modelAbstract {
    protected $tableName = 'endereco';
    protected $campoId = 'idend';
    protected $arAtributos = [
        'idend' => null,
        'idusu' => null,
        'cep' => null
    ];
}