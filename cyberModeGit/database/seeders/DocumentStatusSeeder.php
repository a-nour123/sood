<?php

namespace Database\Seeders;

use App\Models\DocumentStatus;
use Illuminate\Database\Seeder;

class DocumentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentStatus::create([
            "id" => 1,
            "name" => 'Draft'
        ]);
        DocumentStatus::create([
            "id" => 2,
            "name" => 'In Review'
        ]);
        DocumentStatus::create([
            "id" => 3,
            "name" => 'Approved'
        ]);
    }
}
