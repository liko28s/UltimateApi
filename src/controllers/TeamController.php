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
                $team->coach = $this->model->find($team->id)->coach;
            }
            return $teams;
        }
        $teams = $this->model->find($id);
        $teams->players = $this->model->find($id)->players;
        $teams->coach = $this->model->find($id)->coach;
        return $teams;
    }
}