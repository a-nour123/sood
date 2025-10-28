<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            "id" => 1,
            "name" => 'en',
            "full" => 'English'
        ]);
        /*Language::create([
            "id" => 2,
            "name" => 'bp',
            "full" => 'Brazilian Portuguese'
        ]);
        Language::create([
            "id" => 3,
            "name" => 'es',
            "full" => 'Espanol'
        ]);*/ // Delete for live
        Language::create([
            "id" => 4,
            "name" => 'ar',
            "full" => 'Arabic'
        ]);
        /*Language::create([
            "id" => 5,
            "name" => 'ca',
            "full" => 'Catalan'
        ]);
        Language::create([
            "id" => 6,
            "name" => 'cs',
            "full" => 'Czech'
        ]);
        Language::create([
            "id" => 7,
            "name" => 'da',
            "full" => 'Danish'
        ]);
        Language::create([
            "id" => 8,
            "name" => 'de',
            "full" => 'German'
        ]);
        Language::create([
            "id" => 9,
            "name" => 'el',
            "full" => 'Greek'
        ]);
        Language::create([
            "id" => 10,
            "name" => 'fi',
            "full" => 'Finnish'
        ]);
        Language::create([
            "id" => 11,
            "name" => 'fr',
            "full" => 'French'
        ]);
        Language::create([
            "id" => 12,
            "name" => 'he',
            "full" => 'Hebrew'
        ]);
        Language::create([
            "id" => 13,
            "name" => 'hi',
            "full" => 'Hindi'
        ]);
        Language::create([
            "id" => 14,
            "name" => 'hu',
            "full" => 'Hungarian'
        ]);
        Language::create([
            "id" => 15,
            "name" => 'it',
            "full" => 'Italian'
        ]);
        Language::create([
            "id" => 16,
            "name" => 'ja',
            "full" => 'Japanese'
        ]);
        Language::create([
            "id" => 17,
            "name" => 'ko',
            "full" => 'Korean'
        ]);
        Language::create([
            "id" => 18,
            "name" => 'nl',
            "full" => 'Dutch'
        ]);
        Language::create([
            "id" => 19,
            "name" => 'no',
            "full" => 'Norwegian'
        ]);
        Language::create([
            "id" => 20,
            "name" => 'pl',
            "full" => 'Polish'
        ]);
        Language::create([
            "id" => 21,
            "name" => 'pt',
            "full" => 'Portuguese'
        ]);
        Language::create([
            "id" => 22,
            "name" => 'ro',
            "full" => 'Romanian'
        ]);
        Language::create([
            "id" => 23,
            "name" => 'ru',
            "full" => 'Russian'
        ]);
        Language::create([
            "id" => 24,
            "name" => 'sr',
            "full" => 'Serbian'
        ]);
        Language::create([
            "id" => 25,
            "name" => 'sv',
            "full" => 'Swedish'
        ]);
        Language::create([
            "id" => 26,
            "name" => 'tr',
            "full" => 'Turkish'
        ]);
        Language::create([
            "id" => 27,
            "name" => 'uk',
            "full" => 'Ukranian'
        ]);
        Language::create([
            "id" => 28,
            "name" => 'vi',
            "full" => 'Vietnamese'
        ]);
        Language::create([
            "id" => 29,
            "name" => 'zh-CN',
            "full" => 'Chinese Simplified'
        ]);
        Language::create([
            "id" => 30,
            "name" => 'zh-TW',
            "full" => 'Chinese Traditional'
        ]);
        Language::create([
            "id" => 31,
            "name" => 'bg',
            "full" => 'Bulgarian'
        ]);
        Language::create([
            "id" => 32,
            "name" => 'sk',
            "full" => 'Slovak'
        ]);
        Language::create([
            "id" => 33,
            "name" => 'mn',
            "full" => 'Mongolian'
        ]);
        Language::create([
            "id" => 34,
            "name" => 'si',
            "full" => 'Sinhala'
        ]);*/ // Delete for live
    }
}
