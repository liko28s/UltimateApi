<?php

namespace Nextria\Helpers;

class Sower {
    public $schema;

    public function __construct($schema) {
        $this->schema = $schema;
        $this->init();
    }

    public function init() {
        $this->createTeams();
        $this->updateTeams();
        $this->createPlayers();
        $this->updatePlayers();
    }

    public function createTeams() {
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

    public function updateTeams() {
    }

    public function createPlayers() {
        if(!$this->schema->hasTable('players')) {
            $this->schema->create('players', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('name',100);
                $table->string('last_name',100);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function updatePlayers() {
        $this->schema->table('players', function ($table) {
            //Modificar al gusto para crear o eliminar campos
            if($this->schema->hasColumn('players','another_field')) {
                $table->dropColumn('another_field');
            }
        });
    }
}