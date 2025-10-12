<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(1);
            $table->boolean('lockout')->default(0);
            $table->string('type', 20)->default('grc');
            $table->string('username')->unique();
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->string('salt', 20)->nullable();
            $table->string('password', 60);
            $table->dateTime('last_login')->nullable();
            $table->timestamp('last_password_change_date')->useCurrent();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('lang', 5)->nullable();
            $table->boolean('admin')->default(0);
            $table->integer('multi_factor')->default(1);
            $table->string('ldap_department')->nullable();
            $table->boolean('change_password')->default(0);
            $table->string('custom_display_settings', 1000)->default('');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->foreignId('job_id')->nullable()->constrained('jobs');
            $table->string('custom_plan_mitigation_display_settings', 2000)->default('{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n');
            $table->string('custom_perform_reviews_display_settings', 2000)->default('{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n');
            $table->string('custom_reviewregularly_display_settings', 2000)->default('{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["days_open","1"]],"review_colums":[["management_review","0"],["review_date","0"],["next_step","0"],["next_review_date","1"],["comments","0"]]}');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
