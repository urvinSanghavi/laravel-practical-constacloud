<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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

    public static function addStudents($students){
        return User::create($students);
    }

    public static function getAllStudents(){
        return User::with('subjectScore.studentSubject', 'subjectScore.studentClass')->orderBy('created_at', 'DESC')->paginate(10);
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

    public static function getAllStudentWithAPI(){
        return User::join(
            'subject_scores as ss', 'users.id', '=', 'ss.student_id'
        )->join(
            'subjects as sub', 'sub.id', '=', 'ss.subject_id'
        )->join(
            'class as cls', 'cls.id', '=', 'ss.class_id'
        )
        ->get(['student_name', 'roll_no', 'image_path', 'class', 'subject_name', 'Scores'])->groupBy('student_name');
    }
}

