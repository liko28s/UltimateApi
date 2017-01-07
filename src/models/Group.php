<?php

namespace Nextria\Models;

class Group extends SuperModel {
    public function teams() {
        return $this->hasMany('Nextria\Models\Team');
    }

}