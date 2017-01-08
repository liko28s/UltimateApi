<?php

namespace Nextria\Controllers;

use Nextria\Models\Group;
use Nextria\Models\Match;
use Nextria\Models\MatchDetails;

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
                foreach ($group->teams as $team){
                    $team->pj = Match::where('team_one',$team->id)
                        ->where('match_time','<','current_timestamp')
                        ->orWhere(function ($query){
                            global $team;
                            $query->where('team_two',$team->id)->where('match_time','<','current_timestamp');
                        })
                        ->count();
                    $team->pg = 0;
                    $details = MatchDetails::where('team_id',$team->id)->get();
                    $matches = array();
                    foreach ($details as $detail) {
                        if($detail->event == 2) {
                            if($detail->team_id == $team->id){
                                $matches[$detail->match_id]['self']+=1;
                            } else {
                                $matches[$detail->match_id]['opponent']+=1;
                            }
                        }
                    }
                    foreach ($matches as $match){
                        if($match['self']>$match['opponent']) {
                            $team->pg++;
                        }
                    }
                }
                $teams = $group->teams->toArray();
                usort($teams,function($one, $two) {
                        return $two['pg'] - $one['pg'];
                });
                $group->teams = $teams;
            }


            return $groups;
        }
        $groups = $this->model->find($id);
        $groups->teams = $this->model->find($id)->teams;
        return $groups;
    }
}