<?php
include "vendor/autoload.php";
include "config.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Nextria\Helpers\Logger as Logger;


/** Instancia de Slim */
$app = new \Slim\App(CONFIG);

/** Contenedor */
$container = $app->getContainer();

/** UserName */
$container['userName'] = function () {
    return $_SERVER['PHP_AUTH_USER'];
};

/** Password */
$container['password'] = function () {
    return $_SERVER['PHP_AUTH_PW'];
};

/** Database */
$container['db'] = function ($c) {
  return $c['settings']['db'];
};
$capsule = new CapsuleManager();
$capsule->addConnection($container->db);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//TODO añadir controlador de errores al contenedor

/** Logger */
$container['logger'] = function ($c) {
    $logger = new Logger($c['userName']);
    return $logger->getInstance();
};

//Dummy Table TODO remove
$app->get('/dummy', function (Request $request, Response $response) {
    $dummy = new \Nextria\Controllers\DummyController();
    return $response->withJson($dummy->getTwo());
});

//TODO instalador de la api para crear tablas etc

$app->run();