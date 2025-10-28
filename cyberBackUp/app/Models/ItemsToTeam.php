<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
class ItemsToTeam extends Model
{
    use HasFactory,Auditable;

    public $timestamps = false;
    protected $fillable = [
        'item_id',
        'team_id',
        'type'
    ];
}
