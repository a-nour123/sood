<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->longText('name')->change();
        });
                // Process records in batches
        DB::table('families')
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->where('name', 'NOT LIKE', '{%}')
            ->orderBy('id')
            ->chunkById(100, function ($controls) {
                foreach ($controls as $control) {
                    $jsonDescription = json_encode([
                        'en' => $control->name,
                        'ar' => $control->name
                    ], JSON_UNESCAPED_UNICODE);
                    DB::table('families')
                        ->where('id', $control->id)
                        ->update(['name' => $jsonDescription]);
                }
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('families', function (Blueprint $table) {
            //
        });
    }
}