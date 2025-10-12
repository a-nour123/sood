<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlObjective extends Model
{
    use HasFactory;

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
    
    public function controls()
    {
        return $this->belongsToMany(FrameworkControl::class, 'controls_control_objectives', 'objective_id', 'control_id')->withPivot('id');
    }

    public function controlObjectives()
    {
        return $this->hasMany(ControlControlObjective::class, 'objective_id');
    }

    public function evidences()
    {
        return $this->hasManyThrough(Evidence::class, ControlControlObjective::class, 'objective_id', 'control_control_objective_id', 'id', 'id');
    }
    
    public function hasRelations()
    {
        $relations = [
            'Linked Controls' => $this->controls()->count(),
        ];

        // Filter out empty relations
        return array_filter($relations, fn($count) => $count > 0);
    }
}