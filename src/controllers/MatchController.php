<?php

namespace Nextria\Controllers;

use Nextria\Helpers\Logger;
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

    public function getCurrent() {
        $matches = $this->model->whereRaw('match_time <= now()')
            ->whereRaw("date_add(match_time, INTERVAL 2 hour) >= now()")
            ->orderBy('match_time','DESC')
            ->get();
        foreach ($matches as $match) {
            $match->details = $this->model->find($match->id)->details;
        }
        return $matches;
    }

    public function getPhases($phase) {
        $matches = $this->model->where('phase',(int)$phase)
            ->orderBy('match_time','DESC')
            ->get();
        foreach ($matches as $match) {
            $match->details = $this->model->find($match->id)->details;
        }
        return $matches;
    }
}