<?php

namespace Nextria\Models;



class Player extends SuperModel {
    public function team() {
        return $this->belongsTo('Nextria\Models\Team');
    }
}