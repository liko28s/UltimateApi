<?php

namespace Nextria\Controllers;

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

}