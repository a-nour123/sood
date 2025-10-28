<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControl;

class Framework extends Model
{
    use HasFactory;

    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
        'regulator_id'
    ];

    public function FrameworkControls()
    {
        return $this->belongsToMany(FrameworkControl::class, 'framework_control_mappings');
    }

    public function only_parent_controls()
    {
        return $this->belongsToMany(FrameworkControl::class, 'framework_control_mappings')->whereNull('parent_id');
    }

    public function FrameworkControlsFrameworks()
    {
        return $this->belongsToMany(FrameworkControl::class, 'framework_control_mappings')->doesntHave('parentFrameworkControl')->with('Frameworks:name');
    }

    public function families()
    {
        return $this->belongsToMany(Family::class, 'framework_families');
    }

    public function only_families()
    {
        return $this->belongsToMany(Family::class, 'framework_families')->whereNull('parent_id');
    }

    public function only_sub_families()
    {
        return $this->belongsToMany(Family::class, 'framework_families')->whereNotNull('parent_id');
    }


    public function FrameworkControlsWithoutChilds()
    {
        return $this->belongsToMany(FrameworkControl::class, 'framework_control_mappings')->doesntHave('frameworkControls')->with('FrameworkControlTest');
    }

    public function regulator(){
         return $this->belongsTo(Regulator::class);
    }
}
