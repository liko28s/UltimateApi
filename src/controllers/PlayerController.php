<?php

namespace Nextria\Controllers;

use Nextria\Models\Player;

class PlayerController extends SuperController{
    public function __construct()
    {
        parent::__construct(new Player());
    }
}