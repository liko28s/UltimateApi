<?php

namespace Nextria\Controllers;

use Nextria\Models\Match;

class MatchController extends SuperController{
    public function __construct()
    {
        parent::__construct(new Match());
    }

    public function get($id = null)
    {
        if(!$id) {
            $matches = $this->model->get();
            foreach ($matches as $match) {
                $match->details = $this->model->find($match->id)->details;
            }
            return $matches;
        }
        $matches = $this->model->find($id);
        $matches->details = $this->model->find($id)->details;
        return $matches;
    }
}