<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeCategoryToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->integer('type_category')
                  ->nullable()
                  ->comment('1: Standard, 2: Policy, 3: procedures, 4: Others');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropColumn('type_category');
        });
    }
}
