<?php

namespace Nextria\Controllers;

use Nextria\Models\Team;

class TeamController extends SuperController {
    public function __construct()
    {
        parent::__construct(new Team());
    }
}