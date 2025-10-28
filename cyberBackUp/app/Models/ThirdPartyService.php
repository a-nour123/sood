<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThirdPartyService extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function requests(): HasMany
    {
        return $this->hasMany(ThirdPartyRequest::class);
    }
}
