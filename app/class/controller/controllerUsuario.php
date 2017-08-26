<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16/07/17
 * Time: 13:23
 */

namespace app\controller;

use Silex\Application;
use app\controller;
use app\models\modelUsuario as modelUsuario;

require_once 'controllerAbstract.php';

class controllerUsuario extends controllerAbstract {

    public function home(){
        try {
            $params = func_get_args();
            $app = $params[0];
            $req = $_POST;
            $id = !isset($req['id']) ? null : $req['id'];

            $usuario = new modelUsuario($app);

            return json_encode($usuario->getById($id));
        } catch(\Exception $e) {
            return json_encode([
                'erro' => $e->getMessage()
            ]);
        }
    }

    public function login(){
        global $encoder;
        $params = func_get_args();
        $app = $params[0];
        $req = $_REQUEST;
        try {

            if(empty($req['email']) || !isset($req['email'])){
                throw new \Exception('O campo "email" não foi informado.');
            }
            
            if(empty($req['senha']) || !isset($req['senha'])){
                throw new \Exception('O campo "senha" não foi informado.');
            }

            $usuario = new modelUsuario($app);
            $usu = $usuario->getByEmailSenha($req['email'], $req['senha']);

            if(!empty($usu)){
                return $app->json(['usuario' => $usu]);
            } else {
                throw new \Exception('Erro ao logar');
            }
        } catch (\Exception $e) {
            return $app->json([ 'usuario' => [
                    'msg' => $e->getMessage()
                ]
            ]);
        }
    }

    public function cadastro(){
        $params = func_get_args();
        $app = $params[0];
        $req = $_REQUEST;
        try {

        } catch (\Exception $e) {
            return $app->json([
                'erro' => $e->getMessage()
            ]);
        }
    }

}