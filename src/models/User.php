<?php

namespace Nextria\Models;



class User extends SuperModel {
    public function player() {
        return $this->belongsTo('Nextria\Models\Player');
    }
}