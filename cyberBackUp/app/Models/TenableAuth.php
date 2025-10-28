<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenableAuth extends Model
{
    use HasFactory;
    protected $table = 'tenable_auth'; // Specify the table name

    protected $fillable = [
        'access_key',
        'secret_key',
        'api_url',
        'type_source',
        'offset',
        'end',
        'total',
        'severity',
        'idsAssetGroup'
    ];
}
