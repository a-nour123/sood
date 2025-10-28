<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactQuestionnaire extends Model
{
    use HasFactory;

    protected $table = 'contact_questionnaires';
    protected $guarded = [];
}
