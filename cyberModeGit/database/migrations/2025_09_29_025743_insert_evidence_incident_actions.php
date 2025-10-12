<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertEvidenceIncidentActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            DB::table('actions')->insert([
                [
                    'id' => 153,
                    'name' => 'evidence_incident_created',

                ],
                [
                    'id' => 154,
                    'name' => 'evidence_incident_updated',

                ],
                [
                    'id' => 155,
                    'name' => 'evidence_incident_deleted',

                ],
                [
                    'id' => 156,
                    'name' => 'play_book_incident_action',

                ],
                [
                    'id' => 157,
                    'name' => 'play_book_sla_due_date',

                ],
                [
                    'id' => 158,
                    'name' => 'incident_deleted',

                ],


            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            //
        });
    }
}