<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 15)->nullable();
            $table->string('name', 200)->unique('name');
            // $table->integer('value')->default(5);
            $table->foreignId('asset_value_id')->constrained('asset_values');
            // $table->integer('location');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->string('teams', 1000)->nullable();
            $table->longText('details')->nullable();
            $table->timestamp('created')->useCurrent();
            $table->tinyInteger('verified')->default(false);
            $table->date('start_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('alert_period')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
