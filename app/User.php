<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_name', 'roll_no', 'image_path',
    ];

    public $table = 'users';

    public function subjectScore(){
        return $this->hasMany(SubjectScore::class, 'student_id', 'id');
    }

    // public function studentSubject(){
    //     return $this->belongsToMany(Subject::class, 'subject_scores', 'student_id', 'subject_id');
    // }

    // public function studentClass(){
    //     return $this->belongsToMany(StudentClass::class, 'subject_scores', 'student_id', 'class_id');
    // }

    public static function addStudents($students){
        return User::create($students);
    }

    public static function getAllStudents(){
        // return User::with('subjectScore', 'studentSubject', 'studentClass')->paginate(10);
        return User::with('subjectScore.studentSubject', 'subjectScore.studentClass')->paginate(10);
    }

    public static function getFilterValue($data){
        $query = User::with('subjectScore.studentSubject', 'subjectScore.studentClass');
        if(isset($data['student_id'])){
            $query->where('id', $data['student_id']);
        }
        if(isset($data['roll_no'])){
            $query->where('roll_no', $data['roll_no']);
        }
        if(isset($data['obtained_marks'])){
            $score = $data['obtained_marks'];
            $query->with(
                [
                    'subjectScore' => function (HasMany $query) use ($score) {
                        $query->where('Scores', '=', $score);
                    }
                ]
            );
        }
        return $query->paginate(10);
        
    }
}

