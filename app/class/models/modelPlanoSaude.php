<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 17/07/17
 * Time: 21:59
 */

namespace app\models;

require_once 'modelAbstract.php';

class modelPlanoSaude extends modelAbstract {
    protected $tableName = 'planosaude';
    protected $campoId = 'idpla';
    protected $arAtributos = [
        'idpla' => null,
        'codigo' => null,
        'nome' => null
    ];
}