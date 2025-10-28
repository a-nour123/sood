<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = ['No Priority', 'Low', 'Normal', 'High', 'Urgent'];
        for ($i = 1; $i <= 10; $i++) {
            $task = Task::create([
                'title' => 'title ' . $i,
                'description' => 'description ' . $i,
                'priority' => $priorities[($i - 1) % 5],
                'start_date' => '2022-06-' . $i,
                'due_date' => '2022-06-' . ($i * 2),
                'completed' => $i % 2,
                'assignable_id' => 1,
                'assignable_type' => ($i % 3) ? 'App\Models\User' : 'App\Models\Team',
                'created_by' => 1,
            ]);
            if ($i == 1) {
                $task->files()->create([
                    'task_id' => 1,
                    'display_name' => 'image1.png',
                    'unique_name' => 'task/1/aPyqSQJoKkGGBrghLXA7lV25wW8DOiGE9WPN1ude.png'
                ]);
                $task->files()->create([
                    'task_id' => 1,
                    'display_name' => 'image2.png',
                    'unique_name' => 'task/1/LD9pe8s3hnVfV3zKjLU5J3GItQaY9LNecEOc7dei.png'
                ]);
            }
        }
    }
}
