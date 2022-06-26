<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $table  = "subjects";

    public static function getAllSubjectList() {
        return Subject::all(['id', 'subject_name']);
    }

    public static function getAllSubjectId() {
        return Subject::all(['id']);
    }
}
