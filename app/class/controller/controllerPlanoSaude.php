<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 30/07/17
 * Time: 13:04
 */

namespace app\controller;

use Silex\Application;
use app\controller;
use app\models\modelPlanoSaude as Model;

require_once 'controllerAbstract.php';

class controllerPlanoSaude extends controllerAbstract {

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

            if(empty($req['codigo']) || !isset($req['codigo'])){
                throw new \Exception('O campo "codigo" não foi informado.');
            }

            if(empty($req['nome']) || !isset($req['nome'])){
                throw new \Exception('O campo "nome" não foi informado');
            }

            $model = new Model($app);
            $model->carregaDados($req);
            $model->save();

            return json_encode([
                'msg' => 'Plano de saúde salvo com sucesso'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'erro' => $e->getMessage()
            ]);
        }
    }

}