<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayBookAction extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;



    public function playBooks()
    {
        return $this->belongsToMany(PlayBook::class,'play_book_action_play_books','play_book_action_id','play_book_id')->withPivot('category_type', 'category_id')
          ->withTimestamps();
    }

}