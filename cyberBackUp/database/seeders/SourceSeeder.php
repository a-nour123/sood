<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Source::create([
            "id" => 1,
            "name" => 'People'
        ]);
        Source::create([
            "id" => 2,
            "name" => 'Process'
        ]);
        Source::create([
            "id" => 3,
            "name" => 'System'
        ]);
        Source::create([
            "id" => 4,
            "name" => 'External'
        ]);
    }
}
