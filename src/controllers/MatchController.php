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
        $currentDate = date('Y-m-d H:m:s');
        $log = new Logger();
        $log->getInstance()->addInfo('CurrentDate'.$currentDate);
        $matches = $this->model->where('match_time','<=', $currentDate)
            ->whereRaw("date_add(match_time, INTERVAL 1 hour) >= '".$currentDate."'")
            ->get();
        foreach ($matches as $match) {
            $match->details = $this->model->find($match->id)->details;
        }
        return $matches;
    }
}