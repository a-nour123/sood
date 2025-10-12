<?php

namespace App\Models;

use App\Models\FrameworkControlMappings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class FrameworkControl extends Model
{
    use HasFactory;


    public $timestamps = false;

    public $guarded = [];

    protected $casts = [
        'description' => 'array',
    ];

    public function getDescriptionAttribute($value)
    {
        $descriptions = json_decode($value, true) ?? [];
        $locale = app()->getLocale(); // Get current language (en/ar)

        // Return the description in the current language, fallback to English
        return $descriptions[$locale] ?? $descriptions['en'] ?? '';
    }
    /**
     * Get the phone associated with the user.
     */
    public function FrameworkControlTest()
    {
        return $this->hasOne(FrameworkControlTest::class);
    }

    /**
     * Get the test that owns the Audit.
     */
    public function frameworkControlTestAudits()
    {
        return $this->hasMany(FrameworkControlTestAudit::class);
    }

    public function Frameworks()
    {
        return $this->belongsToMany(Framework::class, 'framework_control_mappings');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'control_id');
    }

    public function Family()
    {
        return $this->belongsTo(Family::class, 'family', 'id');
    }

    public function family_with_parent()
    {
        return $this->belongsTo(Family::class, 'family', 'id')->with('parentFamily:id,name');
    }

    public function parentFrameworkControl()
    {
        return $this->belongsTo(FrameworkControl::class, 'parent_id');
    }

    public function frameworkControls()
    {
        return $this->hasMany(FrameworkControl::class, 'parent_id');
    }

    public function FrameworkControlMappings()
    {
        return $this->belongsToMany(FrameworkControlMapping::class, 'framework_control_mappings');
    }

    public function owners()
    {
        return $this->hasMany("App\Models\ControlOwner", "id", "control_owner");
    }

    public function classes()
    {
        return $this->hasMany("App\Models\ControlClass", "id", "control_class");
    }

    public function phases()
    {
        return $this->hasMany("App\Models\ControlPhase", "id", "control_phase");
    }

    public function priorities()
    {
        return $this->hasMany("App\Models\ControlPriority", "id", "control_priority");
    }

    public function maturities()
    {
        return $this->hasMany("App\Models\ControlMaturity", "id", "control_maturity");
    }

    public function desiredMaturities()
    {
        return $this->hasMany("App\Models\ControlDesiredMaturity", "id", "desired_maturity");
    }

    public function families()
    {
        return $this->hasMany("App\Models\Family", "id", "family");
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'control_owner');
    }

    public function ControlDesiredMaturity()
    {
        return $this->belongsTo(ControlDesiredMaturity::class, 'desired_maturity');
    }

    public function ControlMaturity()
    {
        return $this->belongsTo(ControlMaturity::class, 'control_maturity');
    }

    public function ControlPhase()
    {
        return $this->belongsTo(ControlPhase::class, 'control_phase');
    }

    public function mitigations()
    {
        return $this->belongsToMany(Mitigation::class, 'mitigation_to_controls', 'mitigation_id', 'control_id');
    }

    public function phase()
    {
        return $this->belongsTo(ControlPhase::class, "control_phase");
    }

    public function priority()
    {
        return $this->belongsTo(ControlPriority::class, "control_priority");
    }

    public function maturity()
    {
        return $this->belongsTo(ControlMaturity::class, "control_maturity");
    }

    public function type()
    {
        return $this->belongsTo(ControlType::class, "control_type");
    }

    public function class()
    {
        return $this->belongsTo(ControlClass::class, "control_class");
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'control_owner');
    }

    /**
     * Get the test associated with the control.
     */
    public function custom_test()
    {
        return $this->hasOne(FrameworkControlTest::class)->with('UserTester:id,name');
    }

    public function objectives()
    {
        return $this->belongsToMany(ControlObjective::class, 'controls_control_objectives', 'control_id', 'objective_id')->withPivot('id', 'responsible_type', 'responsible_id', 'responsible_team_id', 'due_date');
    }

    public function extensions()
    {
        return $this->hasMany(FrameworkControlExtension::class, 'control_id');
    }

    public function extendedBy()
    {
        return $this->hasMany(FrameworkControlExtension::class, 'extend_control_id');
    }
}