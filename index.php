<?php

ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../tmp'));

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use Illuminate\Database\Capsule\Manager as Capsule;
use app\controller\controllerUsuario as Usuario;
use app\controller\controllerPaciente as Paciente;

require_once 'vendor/autoload.php';
require_once 'funcoes.php';

$app = new Application();
$encoder = new BCryptPasswordEncoder(4);


autolooad([
    'app/class/controller/',
    'app/class/models/'
]);

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'      => 'pdo_mysql',
        'host'        => "localhost",
        'dbname'      => "agendamento",
        'user'        => "root",
        'password'    => "123456",
        'charset'     => 'utf8mb4'
    )
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\RoutingServiceProvider());

$app->mount('usuario', new Usuario());
$app->mount('paciente', new Paciente());

$app->get('/', function() use($app){
    throw new Exception('Método não especificado');
});

$app->run();