<?php

use App\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjectList = [
            ['subject_name' => 'PHP'],
            ['subject_name' => 'Python'],
            ['subject_name' => 'C#'],
            ['subject_name' => 'Mathematics'],
            ['subject_name' => 'Science']
        ];

        foreach($subjectList as $subject){
            Subject::create($subject);
        }
    }
}
