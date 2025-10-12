<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlTestCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_test_comments', function (Blueprint $table) {
             $table->id();
             // $table->integer('test_audit_id');
             $table->foreignId('test_audit_id')->constrained('framework_control_test_audits')->onDelete('cascade'); // table name nust be framework_control_test_audit_id
             $table->timestamp('date')->useCurrent();
             $table->integer('user');
             $table->mediumText('comment');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('framework_control_test_comments');
    }
}
