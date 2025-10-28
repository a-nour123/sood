<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = ['#557B83', '#39AEA9', '#A2D5AB', '#E5EFC1', '#46244C', '#C74B50', '#D49B54', '#712B75', '#332FD0', '#F0A500', '#874356', '#019267', '#9ADCFF', '#008E89', '#313552', '#FF5959', '#161853', '#544179', '#125C13', '#557B83', '#90AACB'];
        // Departments 
        // for ($i = 1; $i <= 10; $i++) {
        //     Department::create([
        //         'name' => 'Department' . $i,
        //         'code' => '#' . $i . $i . $i . $i . $i,
        //         'required_num_emplyees' => random_int(1, 50)
        //         'color_id' =>ac,
        //         'vision' => 'vision vision vision vision vision' . $i,
        //         'message' => 'message message message message message' . $i,
        //         'mission' => 'mission mission mission mission mission' . $i,
        //         'objectives' => 'objectives objectives objectives objectives objectives' . $i,
        //         'responsibilities' => 'responsibilities responsibilities responsibilities responsibilities responsibilities' . $i,
        //     ]);
        // }
        // // Departments under department (child)
        // for ($i = 11; $i <= 25; $i++) {
        //     Department::create([
        //         'name' => 'Department' . $i,
        //         'code' => '#' . $i . $i . $i . $i . $i,
        //         'required_num_emplyees' => random_int(1, 50)
        //         'color_id' =>79,
        //         'vision' => 'vision vision vision vision vision' . $i,
        //         'message' => 'message message message message message' . $i,
        //         'mission' => 'mission mission mission mission mission' . $i,
        //         'objectives' => 'objectives objectives objectives objectives objectives' . $i,
        //         'responsibilities' => 'responsibilities responsibilities responsibilities responsibilities responsibilities' . $i,
        //         'parent_id' => ($i % 10) ? ($i % 10) : 10, // [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        //     ]);
        // }

        Department::create([
            'id' => 1,
            'name' => 'الرئيس التنفيذى',
            'code' => '#000001',
            // 'required_num_emplyees' => random_int(1, 50),
            'color_id' => 1,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
        ]);

        Department::create([
            'id' => 2,
            'name' => 'اﻹدارة العامة ﻷمن المعلومات',
            'code' => '#000002',
            // 'required_num_emplyees' => random_int(1, 50),
            'color_id' => 2,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 1
        ]);


        Department::create([
            'id' => 3,
            'name' => 'نائب المدير العام',
            'code' => '#000003',
            // 'required_num_emplyees' => random_int(1, 50),
            'color_id' => 3,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 2
        ]);

        Department::create([
            'id' => 4,
            'name' => 'المكتب اﻹدارى',
            'code' => '#000004',
            'required_num_emplyees' => 6,
            'color_id' => 4,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 2
        ]);

        Department::create([
            'id' => 5,
            'name' => 'الحوكمة والمخاطر والالتزام',
            'code' => '#000005',
            'required_num_emplyees' => 21,
            'color_id' => 5,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 2
        ]);

        Department::create([
            'id' => 6,
            'name' => 'المراقبة اﻷمنية والاستجابة والتحليل',
            'code' => '#000006',
            'required_num_emplyees' => 43,
            'color_id' => 6,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 2
        ]);

        Department::create([
            'id' => 7,
            'name' => 'إدارة الحلول اﻷمنية',
            'code' => '#000007',
            'required_num_emplyees' => 11,
            'color_id' => 7,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 2
        ]);

        Department::create([
            'id' => 8,
            'name' => 'المعمارية والتخطيط',
            'code' => '#000008',
            'required_num_emplyees' => 8,
            'color_id' => 8,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 2
        ]);

        Department::create([
            'id' => 9,
            'name' => 'الحوكمة',
            'code' => '#000009',
            // 'required_num_emplyees' => 21,
            'color_id' => 9,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 5
        ]);

        Department::create([
            'id' => 10,
            'name' => 'المخاطر',
            'code' => '#000010',
            // 'required_num_emplyees' => 21,
            'color_id' => 10,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 5
        ]);

        Department::create([
            'id' => 11,
            'name' => 'الالتزام',
            'code' => '#000011',
            // 'required_num_emplyees' => 21,
            'color_id' => 11,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 5
        ]);

        Department::create([
            'id' => 12,
            'name' => 'المراقبة اﻷمنية',
            'code' => '#000012',
            // 'required_num_emplyees' => 43,
            'color_id' => 12,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 6
        ]);

        Department::create([
            'id' => 13,
            'name' => 'التحليل الرقمى والاستجابة للحوادث',
            'code' => '#000013',
            // 'required_num_emplyees' => 43,
            'color_id' => 13,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 6
        ]);

        Department::create([
            'id' => 14,
            'name' => 'المعلومات الاستخباراتية والتهديدات',
            'code' => '#000014',
            // 'required_num_emplyees' => 43,
            'color_id' => 14,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 6
        ]);

        Department::create([
            'id' => 15,
            'name' => 'تحليل التهديدات والثغرات',
            'code' => '#000015',
            // 'required_num_emplyees' => 43,
            'color_id' => 15,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 6
        ]);

        Department::create([
            'id' => 16,
            'name' => 'إدارة الضوابط التقنية اﻷمنية',
            'code' => '#000016',
            // 'required_num_emplyees' => 11,
            'color_id' => 16,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 7
        ]);

        Department::create([
            'id' => 17,
            'name' => 'تطوير واختبار الحلول اﻷمنية',
            'code' => '#000017',
            // 'required_num_emplyees' => 11,
            'color_id' => 17,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 7
        ]);

        Department::create([
            'id' => 18,
            'name' => 'إدارة الهويات والصلاحيات',
            'code' => '#000018',
            // 'required_num_emplyees' => 11,
            'color_id' => 18,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 7
        ]);

        Department::create([
            'id' => 19,
            'name' => 'التخطيط والتطوير',
            'code' => '#000019',
            // 'required_num_emplyees' => 8,
            'color_id' => 19,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 8
        ]);

        Department::create([
            'id' => 20,
            'name' => 'المعمارية اﻷمنية',
            'code' => '#000020',
            // 'required_num_emplyees' => 8,
            'color_id' => 20,
            'vision' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رؤية"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'message' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"رسالة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'mission' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مهمة"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'objectives' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"أهداف"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',

            'responsibilities' => '{"ops":[{"attributes":{"color":"#5e5873","bold":true},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"},{"attributes":{"color":"#5e5873"},"insert":"مسئوليات"},{"attributes":{"list":"bullet"},"insert":"\n"}]}',
            'parent_id' => 8
        ]);
    }
}
