<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControlTestAudit;
class TestStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',

    ];
    public $timestamps = false;

   
}
