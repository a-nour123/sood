<?php

namespace Database\Seeders;

use App\Models\FileType;
use Illuminate\Database\Seeder;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileType::create([
            "id" => 1,
            "name" => 'image/gif'
        ]);
        FileType::create([
            "id" => 2,
            "name" => 'image/jpg'
        ]);
        FileType::create([
            "id" => 3,
            "name" => 'image/png'
        ]);
        FileType::create([
            "id" => 4,
            "name" => 'image/x-png'
        ]);
        FileType::create([
            "id" => 5,
            "name" => 'image/jpeg'
        ]);
        FileType::create([
            "id" => 6,
            "name" => 'application/x-pdf'
        ]);
        FileType::create([
            "id" => 7,
            "name" => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);
        FileType::create([
            "id" => 8,
            "name" => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        FileType::create([
            "id" => 9,
            "name" => 'application/zip'
        ]);
        FileType::create([
            "id" => 10,
            "name" => 'text/rtf'
        ]);
        FileType::create([
            "id" => 11,
            "name" => 'application/octet-stream'
        ]);
        FileType::create([
            "id" => 13,
            "name" => 'text/xml'
        ]);
        FileType::create([
            "id" => 12,
            "name" => 'text/plain'
        ]);
        FileType::create([
            "id" => 14,
            "name" => 'text/comma-separated-values'
        ]);
        FileType::create([
            "id" => 15,
            "name" => 'application/vnd.ms-excel'
        ]);
        FileType::create([
            "id" => 16,
            "name" => 'application/msword'
        ]);
        FileType::create([
            "id" => 17,
            "name" => 'application/x-gzip'
        ]);
        FileType::create([
            "id" => 18,
            "name" => 'application/force-download'
        ]);
        FileType::create([
            "id" => 19,
            "name" => 'application/pdf'
        ]);
        FileType::create([
            "id" => 20,
            "name" => 'text/csv'
        ]);
        FileType::create([
            "id" => 21,
            "name" => 'application/csv'
        ]);
    }
}
