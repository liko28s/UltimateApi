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
        $this->createPlayers();
        $this->createCoaches();
        $this->createGroups();
        $this->createMatches();
        $this->createMatchDetails();

        $this->updateTeams();
        $this->updatePlayers();
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
                $table->integer('group_id')->references('id')->on('groups');
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
                $table->string('nick_name',100)->nullable();
                $table->integer('team_id')->references('id')->on('teams');
                $table->string('identification',100)->nullable();
                $table->string('eps',100)->nullable();
                $table->string('number',4)->nullable();
                $table->tinyInteger('vegetarian')->nullable();
                $table->tinyInteger('camping')->nullable();
                $table->text('profile_image')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function updatePlayers() {
    }

    public function createCoaches() {
        if(!$this->schema->hasTable('coaches')) {
            $this->schema->create('coaches', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('name',100);
                $table->string('last_name',100);
                $table->integer('team_id')->references('id')->on('teams');
                $table->string('profile_image')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function createGroups() {
        if(!$this->schema->hasTable('groups')) {
            $this->schema->create('groups', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('name',100);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function createMatches() {
        if(!$this->schema->hasTable('matches')) {
            $this->schema->create('matches', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->timestamp('match_time');
                $table->integer('arena_id')->references('id')->on('arenas');
                $table->integer('team_one')->references('id')->on('teams');
                $table->integer('team_two')->references('id')->on('teams');
                $table->integer('status');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
    public function createMatchDetails() {
        if(!$this->schema->hasTable('match_details')) {
            $this->schema->create('match_details', function ($table){
                $table->engine = 'MyIsam';
                $table->integer('match_id');
                $table->integer('team_id')->references('id')->on('teams');
                $table->integer('player_id')->references('id')->on('players');
                $table->integer('type');
                $table->integer('status');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function createUsers() {
        if(!$this->schema->hasTable('users')) {
            $this->schema->create('users', function ($table){
                $table->engine = 'MyIsam';
                $table->increments('id');
                $table->string('identification',100)->nullable();
                $table->string('name',100);
                $table->string('last_name',100);
                $table->string('email',100);
                $table->text('profile_image')->nullable();
                $table->integer('player_id')->references('id')->on('players')->nullable();
                $table->text('id_token')->nullable();
                $table->text('web_client_id')->nullable();
                $table->text('server_auth_code')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

}