<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "id" => 1,
            "name" => 'Gestión de Acceso'
        ]);
        Category::create([
            "id" => 2,
            "name" => 'La Resistencia Ambiental'
        ]);
        Category::create([
            "id" => 3,
            "name" => 'Vigilancia'
        ]);
        Category::create([
            "id" => 4,
            "name" => 'Seguridad Física'
        ]);
        Category::create([
            "id" => 5,
            "name" => 'Politica y Procedimiento'
        ]);
        Category::create([
            "id" => 6,
            "name" => 'Gestión de datos sensibles'
        ]);
        Category::create([
            "id" => 7,
            "name" => 'Gestión de Tecnica de Vulnerabilidades'
        ]);
        Category::create([
            "id" => 8,
            "name" => 'Gestión de Terceros'
        ]);
    }
}
