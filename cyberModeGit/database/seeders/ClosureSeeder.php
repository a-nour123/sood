<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Closure;
class ClosureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=1;$i<21;$i++){
            Closure::create([
                 'id'=>$i,
                 'risk_id' =>$this->faker->unique()->numberBetween(1, 20),
                 'user_id' => 1,
                 'close_reason' => $this->faker->randomElement([1,2,3,4,5]),
                 'note' => 'asd',
                 'closure_date' =>  now(),
             ]);
        }
    }
}
