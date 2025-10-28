<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateFrameworkControlsDescriptionFormat extends Migration
{
    public function up()
    {
        Schema::table('framework_controls', function (Blueprint $table) {
            $table->longText('description')->change();
        });
        Schema::table('control_objectives', function (Blueprint $table) {
            $table->longText('description')->change();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->longText('question')->change();
        });
        Schema::table('assessment_answers', function (Blueprint $table) {
            $table->longText('answer')->change();
        });


        // Process records in batches
        DB::table('framework_controls')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where('description', 'NOT LIKE', '{%}')
            ->orderBy('id')
            ->chunkById(100, function ($controls) {
                foreach ($controls as $control) {
                    $jsonDescription = json_encode([
                        'en' => $control->description,
                        'ar' => $control->description
                    ], JSON_UNESCAPED_UNICODE);
                    DB::table('framework_controls')
                        ->where('id', $control->id)
                        ->update(['description' => $jsonDescription]);
                }
            });
        DB::table('control_objectives')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where('description', 'NOT LIKE', '{%}')
            ->orderBy('id')
            ->chunkById(100, function ($objectives) {
                foreach ($objectives as $obj) {
                    $jsonDescription = json_encode([
                        'en' => $obj->description,
                        'ar' => $obj->description
                    ], JSON_UNESCAPED_UNICODE);
                    DB::table('control_objectives')
                        ->where('id', $obj->id)
                        ->update(['description' => $jsonDescription]);
                }
            });

        DB::table('questions')
            ->whereNotNull('question')
            ->where('question', '!=', '')
            ->where('question', 'NOT LIKE', '{%}')
            ->orderBy('id')
            ->chunkById(100, function ($questions) {
                foreach ($questions as $question) {
                    $jsonDescription = json_encode([
                        'en' => $question->question,
                        'ar' => $question->question
                    ], JSON_UNESCAPED_UNICODE);
                    DB::table(table: 'questions')
                        ->where('id', $question->id)
                        ->update(['question' => $jsonDescription]);
                }
            });
        DB::table('assessment_answers')
            ->whereNotNull('answer')
            ->where('answer', '!=', '')
            ->where('answer', 'NOT LIKE', '{%}')
            ->orderBy('id')
            ->chunkById(100, function ($answers) {
                foreach ($answers as $answer) {
                    $jsonDescription = json_encode([
                        'en' => $answer->answer,
                        'ar' => $answer->answer
                    ], JSON_UNESCAPED_UNICODE);
                    DB::table(table: 'assessment_answers')
                        ->where('id', $answer->id)
                        ->update(['answer' => $jsonDescription]);
                }
            });
    }

    public function down()
    {
        // This migration cannot be easily reversed
        // You would need to implement logic to extract the English value
        // from the JSON if you want to rollback
    }
}