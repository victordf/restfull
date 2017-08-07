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

    public function action_get_home(){
        try {
            $params = func_get_args();
            $app = $params[0];
            $req = $_GET;
            $id = !isset($req['id']) ? null : $req['id'];

            $usuario = new modelUsuario($app);

            return json_encode($usuario->getById($id));
        } catch(\Exception $e) {
            return json_encode([
                'erro' => $e->getMessage()
            ]);
        }
    }

    public function action_post_home(){
        try {
            $params = func_get_args();
            $app = $params[0];
            $req = $_REQUEST;

            if(empty($req['email']) || !isset($req['email'])){
                throw new \Exception('O campo "email" não foi informado.');
            }

            if(empty($req['senha']) || !isset($req['senha'])){
                throw new \Exception('O campo "senha" não foi informado.');
            }

            if(empty($req['tipo']) || !isset($req['tipo'])){
                throw new \Exception('O campo "tipo" não foi informado.');
            }

            $usuario = new modelUsuario($app);
            $usuario->carregaDados($req);
            $usuario->save();

            return json_encode([
                'mes' => 'Usuário salvo com sucesso'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'erro' => $e->getMessage()
            ]);
        }
    }

}