<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use  Notific;
class NotificationsTableDataSeeder extends Seeder
{
    protected $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=0;$i<15;$i++){
            Notific::notify( 
                1, 
                $this->faker->text($maxNbChars = 200), 
                $this->faker->randomElement(['create', 'edit','delete']),  
                [
                    'link'=>$this->faker->url,
                    'order'=>'ASC',
            ],
                date('d F Y') );
        }
    }
}
