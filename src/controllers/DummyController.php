<?php
/**
 * Created by PhpStorm.
 * User: develpc
 * Date: 30/12/16
 * Time: 12:01 PM
 */

namespace Nextria\Controllers;


use Nextria\Models\Dummy;

class DummyController {
    private $model;
    public function __construct()
    {
        $this->model = new Dummy();
    }
    public function getOne() {
        return $this->model->find(1);
    }
    public function getTwo() {
        return $this->model->find(2);
    }
}