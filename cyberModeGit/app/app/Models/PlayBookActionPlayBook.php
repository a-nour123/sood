<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayBookActionPlayBook extends Model
{
    use HasFactory;
    public $guarded = [];

    public function playBookAction()
    {
        return $this->belongsTo(PlayBookAction::class, 'play_book_action_id');
    }

 
}
