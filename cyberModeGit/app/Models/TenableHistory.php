<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenableHistory extends Model
{
    use HasFactory;

    protected $table = 'tenable_histories'; // Explicitly specify the table name if it doesn't follow Laravel's naming convention

    protected $fillable = [
        'vuln_id',
        'asset_id',
        'severity',
        'status',
        'created_at',
        'updated_at',
    ];

 
}