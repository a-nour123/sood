<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;
use App\Models\NextStep;

// use App\Events\MgmtreviewCreated;
class MgmtReview extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    // protected $dispatchesEvents=[
    //     'created'=>MgmtreviewCreated::class
    // ];

    public function reviews()
    {
        return $this->belongsTo('App\Models\Review', 'review');
    }
    public function reviewers()
    {
        return $this->belongsTo('App\Models\User', 'reviewer');
    }
    public function nextStep()
    {
        return $this->belongsTo('App\Models\NextStep', 'next_step_id');
    }
}
