<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactQuestionnaireAnswer extends Model
{
    use HasFactory;

    protected $table = 'contact_questionnaire_answers';
    protected $guarded = [];

    /*protected $casts = [
        'approved_status' => ApprovedStatusEnum::class
    ];*/


    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function contact()
    {
        return $this->belongsTo(User::class, 'contact_id', 'id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(ContactQuestionnaireAnswerResult::class)->orderBy('id');
    }


}
