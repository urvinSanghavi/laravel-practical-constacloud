<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectScore extends Model
{
    public $table = 'subject_scores';

    protected $fillable = [
        'student_id', 'class_id', 'subject_id', 'Scores',
    ];

    public static function addSubjectScore($subjectScore){
        return SubjectScore::create($subjectScore);
    }
    
    public function studentSubject(){
        return $this->hasMany(Subject::class, 'id', 'subject_id');
    }

    public function studentClass(){
        return $this->hasMany(StudentClass::class, 'id', 'class_id');
    }
}
