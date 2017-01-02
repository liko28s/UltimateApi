<?php
include "vendor/autoload.php";
include "config.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Nextria\Helpers\Logger as Logger;
use Nextria\Helpers\Sower as Sower;
use Nextria\Controllers\PlayerController as Player;
use Nextria\Controllers\CoachController as Coach;
use Nextria\Controllers\TeamController as Team;
use Nextria\Controllers\GroupController as Group;

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
$container['db'] = function ($c) {
    return $c['settings']['db'];
};
/** Instancia DB */
$capsule = new \Nextria\Helpers\Db($container->db);
/** Sembrador de Tablas */
$sower = new Sower($capsule->getSchema());
$sower->init();

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
    if($request->getContentType() !== $contentType) {
        return $next($request->withHeader('Content-Type',$contentType),$response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'));
    }
});

/** Players */
$app->group('/players', function() {

    $this->get('[/{player_id}]', function (Request $request, Response $response, $args){
        $player = new Player();
        return $response->withJson(["players" => $player->get($args['player_id'])]);
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

/** Coaches */
$app->group('/coaches', function() {

    $this->get('[/{coach_id}]', function (Request $request, Response $response, $args){
        $coach = new Coach();
        return $response->withJson(["coaches" => $coach->get($args['coach_id'])]);
    });

    $this->post('', function (Request $request, Response $response) {
        $coach = new Coach();
        return $response->withJson($coach->add($request->getParsedBody()));
    });

    $this->delete('/{coach_id}', function (Request $request, Response $response, $args){
        $coach = new Coach();
        return $response->withJson($coach->del($args['coach_id']));
    });

});

$app->group('/teams', function () {

    $this->get('[/{team_id}]', function (Request $request, Response $response, $args){
        $team = new Team();
        return $response->withJson(["teams" => $team->get($args['team_id'])]);
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

$app->group('/groups', function () {

    $this->get('[/{group_id}]', function (Request $request, Response $response, $args){
        $groups = new Group();
        return $response->withJson(["groups" => $groups->get($args['group_id'])]);
    });

    $this->post('', function (Request $request, Response $response) {
        $group = new Group();
        return $response->withJson($group->add($request->getParsedBody()));
    });

    $this->delete('/{group_id}', function (Request $request, Response $response, $args){
        $group = new Group();
        return $response->withJson($group->del($args['group_id']));
    });
});
$app->run();