<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceFile extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'ref_id',
        'ref_type',
        'name',
        'unique_name',
        'type',
        'size',
        'timestamp',
        'user',
        'content',
        'version',
    ];
}
