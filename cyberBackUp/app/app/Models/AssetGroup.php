<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssetGroup extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
    public $timestamps = false;

    /**
     * Get all of the assets for the asset group.
     */
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_asset_groups');
    }
}
