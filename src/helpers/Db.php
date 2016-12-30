<?php

namespace Nextria\Helpers;

use Illuminate\Database\Capsule\Manager;

class Db {
    protected $capsule;
    protected $schema;

    public function __construct($db) {
        $this->capsule = new Manager();
        $this->capsule->addConnection($db);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
        $this->schema = $this->capsule->schema();
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

}