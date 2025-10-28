<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeInPhishingWebsitePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE phishing_website_pages MODIFY html_code LONGTEXT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE phishing_website_pages MODIFY html_code TEXT');
    }
}
