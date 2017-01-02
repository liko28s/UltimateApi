<?php

namespace Nextria\Controllers;

use Nextria\Models\Coach;

class CoachController extends SuperController{
    public function __construct()
    {
        parent::__construct(new Coach());
    }
}