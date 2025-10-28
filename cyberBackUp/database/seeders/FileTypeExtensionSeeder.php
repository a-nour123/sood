<?php

namespace Database\Seeders;

use App\Models\FileTypeExtension;
use Illuminate\Database\Seeder;

class FileTypeExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileTypeExtension::create([
            "id" => 12,
            "name" => 'csv'
        ]);
        FileTypeExtension::create([
            "id" => 14,
            "name" => 'doc'
        ]);
        FileTypeExtension::create([
            "id" => 16,
            "name" => 'dot'
        ]);
        FileTypeExtension::create([
            "id" => 6,
            "name" => 'dotx'
        ]);
        FileTypeExtension::create([
            "id" => 1,
            "name" => 'gif'
        ]);
        FileTypeExtension::create([
            "id" => 15,
            "name" => 'gz'
        ]);
        FileTypeExtension::create([
            "id" => 4,
            "name" => 'jpeg'
        ]);
        FileTypeExtension::create([
            "id" => 2,
            "name" => 'jpg'
        ]);
        FileTypeExtension::create([
            "id" => 5,
            "name" => 'pdf'
        ]);
        FileTypeExtension::create([
            "id" => 3,
            "name" => 'png'
        ]);
        FileTypeExtension::create([
            "id" => 9,
            "name" => 'rtf'
        ]);
        FileTypeExtension::create([
            "id" => 10,
            "name" => 'txt'
        ]);
        FileTypeExtension::create([
            "id" => 18,
            "name" => 'xla'
        ]);
        FileTypeExtension::create([
            "id" => 13,
            "name" => 'xls'
        ]);
        FileTypeExtension::create([
            "id" => 7,
            "name" => 'xlsx'
        ]);
        FileTypeExtension::create([
            "id" => 17,
            "name" => 'xlt'
        ]);
        FileTypeExtension::create([
            "id" => 11,
            "name" => 'xml'
        ]);
        FileTypeExtension::create([
            "id" => 8,
            "name" => 'zip'
        ]);
    }
}
