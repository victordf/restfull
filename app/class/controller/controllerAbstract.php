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
//            $method = $metodo == 'home' ? 'get' : 'post';
            $url = $metodo == 'home' ? '/' : $metodo;
            $this->con->post($url, function() use($app, $metodo){
                return $this->$metodo($app);
            });
        }

        return $this->con;
    }
}