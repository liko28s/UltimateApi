<?php

namespace Nextria\Helpers;

class Sower {
    public $schema;

    public function __construct($schema) {
        $this->schema = $schema;

    }

    public function init() {
        $this->createTeam();
        $this->updateTeam();
    }

    public function createTeam() {
        if(!$this->schema->hasTable('teams')) {
            $this->schema->create('teams', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('name',100);
                $table->text('description');
                $table->integer('coach');
                $table->text('image_url');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function updateTeam() {
        $this->schema->table('teams', function ($table) {
            if($this->schema->hasColumn('teams','another_field')) {
                $table->dropColumn('another_field');
            }
            if($this->schema->hasColumn('teams','email')) {
                $table->dropColumn('email');
            }
        });
    }
}