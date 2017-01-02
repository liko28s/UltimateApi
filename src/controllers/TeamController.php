<?php

namespace Nextria\Controllers;

use Nextria\Models\Team;

class TeamController extends SuperController {
    public function __construct()
    {
        parent::__construct(new Team());
    }

    /** @override */
    public function get($id = null) {

        if(!$id) {
            $teams = $this->model->get();
            foreach ($teams as $team) {
                $team->players = $this->model->find($team->id)->players;
            }
            return $teams;
        }
        $teams = $this->model->find($id);
        $players = $this->model->find($id)->players;
        $teams->players = $players;
        return $teams;
    }
}