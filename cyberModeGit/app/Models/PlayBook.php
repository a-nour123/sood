<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayBook extends Model
{
    use HasFactory;
    public $guarded = [];

    public function teams(){
        return $this->belongsToMany(Team::class,'play_book_teams','playbook_id','team_id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'play_book_users','playbook_id','user_id');
    }
    public function actions(){
        return $this->belongsToMany(PlayBookAction::class,'play_book_action_play_books','play_book_id','play_book_action_id')->withPivot('category_type', 'category_id');
    }

    // Get containment actions
    public function containmentActions()
    {
        return $this->actions()->wherePivot('category_type', 'containments');
    }

    // Get eradication actions
    public function eradicationActions()
    {
        return $this->actions()->wherePivot('category_type', 'eradications');
    }

    // Get recovery actions
    public function recoveryActions()
    {
        return $this->actions()->wherePivot('category_type', 'recoveries');
    }

    
}
