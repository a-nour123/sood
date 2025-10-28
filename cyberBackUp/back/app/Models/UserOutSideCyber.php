<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOutSideCyber extends Model
{
    use HasFactory;
    protected $table = 'user_out_side_cybers';
    public $timestamps = true;
    protected $fillable=['username','email'];
}
