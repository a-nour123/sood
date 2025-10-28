<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostRegion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','host_region_id'];
    protected $table = 'host_regions';

    public function hosts()
    {
        return $this->belongsToMany(Asset::class, 'asset_host_region');
    }
}
