<?php
include "vendor/autoload.php";
include "config.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Nextria\Helpers\Logger as Logger;
use Nextria\Helpers\Sower as Sower;
use Nextria\Controllers\PlayerController as Player;
use Nextria\Controllers\TeamController as Team;
use Nextria\Controllers\GroupController as Group;
use Nextria\Controllers\MatchController as Match;
use Nextria\Controllers\UserController as User;
use Nextria\Controllers\MatchDetailsController as MatchDetails;

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

/** Ruta Imágenes */
$container['images_path'] = function () {
    return 'img/';
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
        $player = new Player();
        return $response->withJson(["coaches" => $player->get($args['coach_id'])]);
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

$app->group('/matches', function () {


    $this->get('/current', function (Request $request, Response $response){
        $matches = new Match();
        return $response->withJson(["matches" => $matches->getCurrent()]);
    });

    $this->get('[/{match_id}]', function (Request $request, Response $response, $args){
        $matches = new Match();
        return $response->withJson(["matches" => $matches->get($args['match_id'])]);
    });

    $this->post('', function (Request $request, Response $response) {
        $match = new Match();
        return $response->withJson($match->add($request->getParsedBody()));
    });

    $this->post('/{match_id}/event', function (Request $request, Response $response, $args) {
        $matchDetails = new MatchDetails();
        return $response->withJson($matchDetails->add($request->getParsedBody()));
    });

    $this->delete('/{match_id}', function (Request $request, Response $response, $args){
        $match = new Match();
        return $response->withJson($match->del($args['match_id']));
    });

});

$app->group('/arenas', function () {

    $this->get('[/{match_id}]', function (Request $request, Response $response, $args){
        $matches = new Match();
        return $response->withJson(["arenas" => $matches->get($args['match_id'])]);
    });

    $this->get('/current/', function (Request $request, Response $response, $args){
        //TODO este debe devolver los partidos que estan en curso
        $matches = new Match();
        return $response->withJson(["matches" => $matches->get($args['match_id'])]);
    });

    $this->post('', function (Request $request, Response $response) {
        $match = new Match();
        return $response->withJson($match->add($request->getParsedBody()));
    });

    $this->delete('/{match_id}', function (Request $request, Response $response, $args){
        $match = new Match();
        return $response->withJson($match->del($args['match_id']));
    });
});

/** Users */
$app->group('/users', function() {

    $this->get('[/{user_id}]', function (Request $request, Response $response, $args){
        $user = new User();
        return $response->withJson(["users" => $user->get($args['user_id'])]);
    });

    $this->post('', function (Request $request, Response $response) {
        $user = new User();
        return $response->withJson($user->add($request->getParsedBody()));
    });

    $this->delete('/{user_id}', function (Request $request, Response $response, $args){
        $user = new User();
        return $response->withJson($user->del($args['user_id']));
    });

});

/** Images */
$app->group('/images', function() {

    $this->get('/{folder:(?:profile|team)}/{id}', function (Request $request, Response $response, $args) {
        return $response->withBody(new \GuzzleHttp\Psr7\LazyOpenStream(
            $this->images_path.$args['folder'].'/'.$args['id'],'r'))
            ->withHeader('Content-Type','image');
    });

    $this->post('/{folder:(?:profile|team)}/{id}', function (Request $request, Response $response, $args) {
        $files = $request->getUploadedFiles();
        $image_path = $this->images_path.$args['folder'].'/'.$args['id'];

        foreach($files as $file) {
            $file->moveTo($image_path);
        }

        switch($args['folder']) {
            case 'profile':
                $controller = new User();
                break;
            case 'team':
                $controller = new Team();
        }

        return $response->withJson($controller->upd(['profile_image'=>$image_path], $args['id']));
    });
});

$app->run();