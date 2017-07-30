<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 17/07/17
 * Time: 22:08
 */

namespace app\controller;

use Silex\Application;
use app\controller;
use app\models\modelPaciente as Model;

require_once 'controllerAbstract.php';

class controllerPaciente extends controllerAbstract {

    public function action_get_home(){
        try {
            $params = func_get_args();
            $app = $params[0];
            $req = $_GET;
            $id = !isset($req['id']) ? null : $req['id'];

            $usuario = new Model($app);

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

            $usuario = new Model($app);
            $usuario->carregaDados($req);
            $usuario->save();

            return json_encode([
                'msg' => 'Paciente salvo com sucesso'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'erro' => $e->getMessage()
            ]);
        }
    }

}