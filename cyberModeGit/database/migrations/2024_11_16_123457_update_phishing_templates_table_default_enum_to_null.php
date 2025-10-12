<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdatePhishingTemplatesTableDefaultEnumToNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `phishing_templates` MODIFY `payload_type` ENUM('website', 'data_entry', 'attachment') NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `phishing_templates` MODIFY `email_difficulty` ENUM('easy', 'modrate', 'hard') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `phishing_templates` MODIFY `payload_type` ENUM('website', 'data_entry', 'attachment') NOT NULL");
        DB::statement("ALTER TABLE `phishing_templates` MODIFY `email_difficulty` ENUM('easy', 'modrate', 'hard') NOT NULL");
    }
}
