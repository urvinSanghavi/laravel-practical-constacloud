<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    public $table = "class";

    public static function getAllStudentClassList(){
        return StudentClass::all(['id', 'class']);
    }
}
