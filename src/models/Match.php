<?php

namespace Nextria\Models;

class Match extends SuperModel {
    public function details() {
        return $this->hasMany('Nextria\Models\MatchDetails')->orderBy('date_time','desc');
    }

}