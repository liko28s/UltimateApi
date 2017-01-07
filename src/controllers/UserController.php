<?php

namespace Nextria\Controllers;

use Nextria\Models\User;

class UserController extends SuperController {
    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * @Override
     */
    public function get($id = null) {
        if(!$id) {
            $users = $this->model->get();
            foreach ($users as $user) {
                $user->player = $this->model->find($user->id)->player();
            }
            return $users;
        }
        $users = $this->model->find($id);
        $users->player = $this->model->find($id)->player();
        return $users;
    }
}