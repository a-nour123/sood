<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nda extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
    ];
    
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

        // NDA can go to many users
    public function receivers()
    {
        return $this->belongsToMany(User::class, 'nda_receivers', 'nda_id', 'user_id')
                    ->withTimestamps();
    }

    // NDA has many results
    public function results()
    {
        return $this->hasMany(NdaResult::class, 'nda_id');
    }

    // Helper method to get content in specific language
    public function getContent($lang = 'en')
    {
        return $this->content[$lang] ?? '';
    }

    // Helper method to set content for specific language
    public function setContent($lang, $value)
    {
        $content = $this->content ?? [];
        $content[$lang] = $value;
        $this->content = $content;
    }
    
}