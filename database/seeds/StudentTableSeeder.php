<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('student')->insert([
            'title' => 'นาย',
            'fname' => 'ทดสอบ',
            'lname' => 'ระบบ',
            'room' => 39,
            'number' => 33,
            'citizen_id' => 1111111111119,
            'student_id' => 12345,
            'year' => 2560,
        ]);
    }
}
