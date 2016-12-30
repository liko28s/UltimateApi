<?php
include "vendor/autoload.php";
include "config.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Nextria\Helpers\Logger as Logger;
use Nextria\Controllers\PlayerController as Player;
use Nextria\Controllers\TeamController as Team;

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
//TODO si codigo 42S02 (tabla no existe) llamar a creacion de tablas
//TODO hacer creador de tablas
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

/**************
 * MIDDLEWARE *
 **************/
/** Content Type */
$app->add(function(Request $request, Response $response, $next){
    $contentType = 'application/json';
    if(($request->isPost() || $request->isPut()) && $request->getContentType() !== $contentType) {
        return $next($request->withHeader('Content-Type',$contentType),$response);
    }
    return $next($request,$response);
});

//Dummy Table TODO remove
$app->get('/dummy', function (Request $request, Response $response) {
    $dummy = new \Nextria\Controllers\DummyController();
    return $response->withJson($dummy->getTwo());
});

//TODO instalador de la api para crear tablas etc

/** Players */
$app->group('/players', function() {

    $this->get('', function (Request $request, Response $response) {
        $players = new Player();
        return $response->withJson($players->get());
    });

    $this->get('/{player_id}', function (Request $request, Response $response, $args){
        $player = new Player();
        return $response->withJson($player->get($args['player_id']));
    });

    $this->post('', function (Request $request, Response $response) {
        $player = new Player();
        return $response->withJson($player->add($request->getParsedBody()));
    });

    $this->delete('/{player_id}', function (Request $request, Response $response, $args){
        $player = new Player();
        return $response->withJson($player->del($args['player_id']));
    });

});

$app->group('/teams', function () {
   $this->get('', function (Request $request, Response $response){
       $teams = new Team();
       return $response->withJson($teams->get());
   });

    $this->get('/{team_id}', function (Request $request, Response $response, $args){
        $team = new Team();
        return $response->withJson($team->get($args['team_id']));
    });

    $this->post('', function (Request $request, Response $response) {
        $team = new Team();
        return $response->withJson($team->add($request->getParsedBody()));
    });

    $this->delete('/{team_id}', function (Request $request, Response $response, $args){
        $team = new Team();
        return $response->withJson($team->del($args['team_id']));
    });
});
$app->run();