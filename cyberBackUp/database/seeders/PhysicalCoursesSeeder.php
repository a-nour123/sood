<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\CourseRequest;
use App\Models\CourseGrade;
use App\Models\CourseAttendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PhysicalCoursesSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $instructors = User::take(5)->get();
            $students = User::take(20)->get();
            Course::factory()->count(3)->create()->each(function ($course) use ($instructors, $students) {
                $course->instructors()->attach($instructors->random(2));
                for ($i = 1; $i <= 5; $i++) {
                    $course->schedules()->create([
                        'session_date' => now()->addDays($i * 3)->toDateString(),
                        'session_time' => now()->setTime(10 + $i, 0)->format('H:i:s'),
                    ]);
                }

                $approvedStudents = $students->random(10);
                foreach ($approvedStudents as $student) {
                    CourseRequest::create([
                        'course_id' => $course->id,
                        'user_id' => $student->id,
                        'status' => 'approved',
                    ]);

                    foreach ($course->schedules as $schedule) {
                        CourseAttendance::create([
                            'course_id' => $course->id,
                            'course_schedule_id' => $schedule->id,
                            'user_id' => $student->id,
                            'attended' => rand(0, 1),
                        ]);
                    }

                    CourseGrade::create([
                        'course_id' => $course->id,
                        'user_id' => $student->id,
                        'grade' => rand(50, 100),
                    ]);
                }

                $pendingStudents = $students->diff($approvedStudents)->random(5);
                foreach ($pendingStudents as $student) {
                    CourseRequest::create([
                        'course_id' => $course->id,
                        'user_id' => $student->id,
                        'status' => 'pending',
                    ]);
                }

                $rejectedStudents = $students->diff($approvedStudents)->diff($pendingStudents)->random(3);
                foreach ($rejectedStudents as $student) {
                    CourseRequest::create([
                        'course_id' => $course->id,
                        'user_id' => $student->id,
                        'status' => 'canceled',
                    ]);
                }
            });
        });
    }
}
