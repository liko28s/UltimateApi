<?php

namespace Nextria\Controllers;

use Nextria\Models\Group;

class GroupController extends SuperController{
    public function __construct()
    {
        parent::__construct(new Group());
    }

    /** @override */
    public function get($id = null) {

        if(!$id) {
            $groups = $this->model->get();
            foreach ($groups as $group) {
                $group->teams = $this->model->find($group->id)->teams;
            }
            return $groups;
        }
        $groups = $this->model->find($id);
        $groups->teams = $this->model->find($id)->teams;
        return $groups;
    }
}