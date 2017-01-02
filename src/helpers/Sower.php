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
        $this->createCoaches();
    }

    public function createTeams() {
        if(!$this->schema->hasTable('teams')) {
            $this->schema->create('teams', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('name',100);
                $table->text('description')->nullable();
                $table->integer('coach')->nullable();
                $table->text('image')->nullable();
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
                $table->integer('team_id')->references('id')->on('teams');
                $table->string('profile_image')->nullable;
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function updatePlayers() {
        $this->schema->table('players', function ($table) {
            if(!$this->schema->hasColumn('players','team_id')) {
                $table->integer('team_id')->references('id')->on('teams');
            }
        });
    }

    public function createCoaches() {
        if(!$this->schema->hasTable('coaches')) {
            $this->schema->create('coaches', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('name',100);
                $table->string('last_name',100);
                $table->integer('team_id')->references('id')->on('teams');
                $table->string('profile_image')->nullable;
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}