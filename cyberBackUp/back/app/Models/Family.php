<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlTest;

class Family extends Model
{
    use HasFactory;

    public $timestamps = false;
    public static $frameworkControlIds = null;
    public static $testControlNumber = null;
    protected $table = 'families';

    protected $guarded = [];
    public function frameworkControls()
    {
        return $this->hasMany(FrameworkControl::class, 'family')->with('frameworkControls');
    }

    public function custom_frameworkControls()
    {
        return $this->hasMany(FrameworkControl::class, 'family');
    }

    public function families()
    {
        // return $this->hasMany(Family::class, 'parent_id')->with('frameworkControls');
        return $this->hasMany(Family::class, 'parent_id')->orderBy('families.order')->with(["frameworkControls" => function ($q) {
            if (!is_null(self::$frameworkControlIds))
                $q->whereIn('id', self::$frameworkControlIds);
            $q->whereNull('parent_id');
        }]);
    }

    public function familiesOlny()
    {
        return $this->hasMany(Family::class, 'parent_id');
    }

    public function custom_families()
    {
        // return $this->hasMany(Family::class, 'parent_id')->with('frameworkControls');
        if (!is_null(self::$frameworkControlIds))
            return $this->hasMany(Family::class, 'parent_id')->orderBy('families.order')
                ->with(["custom_frameworkControls" => function ($q) {
                    $q->whereIn('id', self::$frameworkControlIds);
                    $q->whereNull('parent_id');
                    $q->select('control_status', 'family');
                }]);

        else
            return $this->hasMany(Family::class, 'parent_id')->orderBy('families.order')->with(["custom_frameworkControls:control_status,family"]);
    }

    public function custom_families_framework()
    {
        return $this->hasMany(Family::class, 'parent_id');
    }

    public function parentFamily()
    {
        return $this->belongsTo(Family::class, 'parent_id');
    }

    public function custom_families_report_time()
    {
        // return $this->hasMany(Family::class, 'parent_id')->with('frameworkControls');
        if (!is_null(self::$frameworkControlIds))
            return $this->hasMany(Family::class, 'parent_id')->orderBy('families.order')
                ->with(["custom_frameworkControls" => function ($q) {
                    $q->whereIn('id', self::$frameworkControlIds);
                    $q->whereNull('parent_id');
                    $q->select('family');
                }]);

        else
            return $this->hasMany(Family::class, 'parent_id')->orderBy('families.order')->with(["custom_frameworkControls:control_status,family"]);
    }

    public function frameworkControlTestAudits()
    {
        return $this->hasMany(FrameworkControlTestAudit::class);
    }

}
