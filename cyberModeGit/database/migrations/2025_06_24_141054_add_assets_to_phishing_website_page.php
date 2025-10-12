<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssetsToPhishingWebsitePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phishing_website_pages', function (Blueprint $table) {
            $table->longText('scraped_assets')->nullable()->after('html_code');
            $table->longText('spa_html_code')->nullable()->after('scraped_assets');
            $table->boolean('is_spa')->default(false)->after('spa_html_code');

            $table->boolean('download_css')->default(true)->after('is_spa');
            $table->boolean('download_images')->default(true)->after('download_css');
            $table->boolean('download_js')->default(true)->after('download_images');
            $table->boolean('download_fonts')->default(true)->after('download_js');
            $table->boolean('download_json')->default(true)->after('download_fonts');
            $table->boolean('download_other_assets')->default(true)->after('download_json');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phishing_website_pages', function (Blueprint $table) {
            $table->dropColumn(['scraped_assets', 'spa_html_code', 'is_spa']);
        });
    }
}
