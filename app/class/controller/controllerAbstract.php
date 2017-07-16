<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16/07/17
 * Time: 13:18
 */

namespace app\controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

abstract class controllerAbstract implements ControllerProviderInterface {
    protected $con;
    protected $app;

    public function connect(Application $app){
        $metodos = get_class_methods($this);
        $this->con = $app['controllers_factory'];
        $this->app = $app;

        foreach ($metodos as $metodo) {
            $arName = explode('_', $metodo);
            if($arName[0] == 'action'){
                $type = $arName[1];
                $name = $arName[2] == 'home' ? '/' : $arName[2];

                $this->con->$type($name, function() use($app, $metodo){
                    return $this->$metodo($app);
                });

            }
        }

        return $this->con;
    }
}