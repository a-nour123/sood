<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlMailContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'content',
        'subject'
    ];
    protected $table = 'control_mail_contents';
}
