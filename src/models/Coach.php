<?php

namespace Nextria\Models;

class Coach extends SuperModel {
    public function team() {
        return $this->belongsTo('Nextria\Models\Team');
    }
}