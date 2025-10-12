<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
class ItemsToUser extends Model
{
    use HasFactory,Auditable;

    public $timestamps = false;
    protected $fillable = [
        'item_id',
        'user_id',
        'type'
    ];
}
