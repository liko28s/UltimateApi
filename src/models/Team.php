<?php
/**
 * Created by PhpStorm.
 * User: develpc
 * Date: 30/12/16
 * Time: 04:01 PM
 */

namespace Nextria\Models;


class Team extends SuperModel
{
    public function players() {
        return $this->hasMany('Nextria\Models\Player');
    }

}