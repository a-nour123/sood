<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassificationAtThirdPartyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_profiles', function (Blueprint $table) {
            // Remove the 'classification' column
            $table->dropColumn('classification');

            // Add the new foreign key 'third_party_classification_id' column
            $table->foreignId('third_party_classification_id')
                ->after('contract_term') // This will place the new column after 'contract_term'
                ->constrained('third_party_classifications') // This references the 'id' in 'third_party_classifications' table
                ->cascadeOnDelete(); // Cascade on delete to remove related rows
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('third_party_profiles', function (Blueprint $table) {
            //
        });
    }
}
