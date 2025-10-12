<?php

namespace Database\Seeders;

use App\Models\DocumentExceptionsStatus;
use Illuminate\Database\Seeder;

class DocumentExceptionsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentExceptionsStatus::create([
            "id" => 1,
            "name" => 'Open'
        ]);
        DocumentExceptionsStatus::create([
            "id" => 2,
            "name" => 'Closed'
        ]);
    }
}
