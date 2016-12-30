<?php

namespace Nextria\Controllers;

use Illuminate\Database\QueryException;
use Nextria\Models\Player;

class PlayerController {
    private $model;

    public function __construct() {
        $this->model = new Player();
    }

    public function get($player_id = null) {
        if(!$player_id) {
            return $this->model->get();
        }
        return $this->model->find($player_id);
    }

    public function add($player) {
        foreach ($player as $field => $value) {
            $this->model->$field = $value;
        }
        try {
            $this->model->save();
        } catch (QueryException $e) {
            return array("ERROR" => $e->getMessage());
        }
        return array("OK");
    }

    public function del($player_id) {
        try {
            $this->model->find($player_id)->delete();
        } catch (QueryException $e) {
            return array("ERROR" => $e->getMessage());
        }
        return array("Ok");
    }

}