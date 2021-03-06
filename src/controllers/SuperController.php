<?php

namespace Nextria\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class SuperController {

    protected $model;
    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function get($id = null) {
        if(!$id) {
            return $this->model->get();
        }
        return $this->model->find($id);
    }

    public function add($row) {
        foreach ($row as $field => $value) {
            $this->model->$field = $value;
        }
        try {
            $this->model->save();
        } catch (QueryException $e) {
            return array("ERROR" => $e->getMessage());
        }
        return array("OK");
    }

    public function del($id) {
        try {
            $this->model->find($id)->delete();
        } catch (QueryException $e) {
            return array("ERROR" => $e->getMessage());
        }
        return array("Ok");
    }

    public function upd($row, $id) {
        foreach ($row as $field => $value) {
            $record = $this->model->find($id);
            if($record) {
                try {
                    $record->$field = $value;
                    $record->save();
                } catch (QueryException $e) {
                    return array("ERROR" => $e->getMessage());
                }
            } else {
                return array("ERROR" => "NO SE ENCONTRÓ EL REGISTRO $id EN {$this->model->getTable()}");
            }
        }
        return array("OK");
    }

}