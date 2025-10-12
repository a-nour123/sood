<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class UpdateNotifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Action::insert([
        //     ['id' => 75, 'name' => 'Asset_Notify_Before_Last_End_Date'],
        // ]);
        // Action::insert([
        //     ['id' => 76, 'name' => 'Documentation_Notify_Before_Last_End_Date'],
        // ]);
        // Action::insert([
        //     ['id' => 77, 'name' => 'Task_Add'],
        //     ['id' => 78, 'name' => 'Task_Update'],
        //     ['id' => 79, 'name' => 'Task_Delete'],
        //     ['id' => 80, 'name' => 'Task_Notify_Before_Last_Due_Date'],
        //     ['id' => 81, 'name' => 'Task_Employee_Change_Status']
        // ]);
        Action::insert([
            ['id' => 82, 'name' => 'Risk_Review_Notify_Before_Last_End_Date'],
        ]);
    }
}
