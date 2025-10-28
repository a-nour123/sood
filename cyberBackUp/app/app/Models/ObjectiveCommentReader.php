<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectiveCommentReader extends Model
{
    protected $fillable = ['comment_id', 'user_id', 'is_read'];

    public function comment()
    {
        return $this->belongsTo(ObjectiveComment::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

