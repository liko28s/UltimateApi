<?php

namespace Nextria\Controllers;

use Nextria\Models\MatchDetails;

class MatchDetailsController extends SuperController{
    public function __construct()
    {
        parent::__construct(new MatchDetails());
    }
}