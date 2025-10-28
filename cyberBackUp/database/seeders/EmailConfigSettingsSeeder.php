<?php

namespace Database\Seeders;

use App\Models\EmailConfig;
use Illuminate\Database\Seeder;

class EmailConfigSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailConfig::insert([
            'id' => 1,
            'email_type' => 'smtp',
            'smtp_server' => 'smtp.sendgrid.net',
            'smtp_port' => '587',
            'smtp_username' => 'Sayid.A@dsshield.com',
            'smtp_password' => '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',
            'smtp_from_username' => 'apikey',
            'ssl_tls' => 'tls',
            'is_active' => 'yes',
        ]);
    }
}
