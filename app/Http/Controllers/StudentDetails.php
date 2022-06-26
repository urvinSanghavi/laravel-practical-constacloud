<?php

namespace App\Http\Controllers;

use App\StudentClass;
use App\Subject;
use App\SubjectScore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentDetails extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getUserInfo = User::get();
        $getAllStudents = User::getAllStudents();
        return view('Students/index', ['students' => $getAllStudents, 'studentInfo' => $getUserInfo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjectList = Subject::getAllSubjectList();
        $subjectClass = StudentClass::getAllStudentClassList();
        return view('Students/add', ['subjectList' => $subjectList, 'subjectClass' => $subjectClass]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'student_name' => 'required',
            'roll_no' => 'required|numeric',
        ],
        [
            'student_name.required' => 'The Student Name field is required.',
            'roll_no.required' => 'The Roll No field is required.',
        ]);


        $getSubjectId = Subject::getAllSubjectId();
        $data = $request->all();
        //image upload
        if($request->file('image_path')){
            $file= $request->file('image_path');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('Image'), $filename);
        } else {
            $filename = "";
        }

        $students = [
            'student_name' => trim($data['student_name']),
            'roll_no' => $data['roll_no'],
            'image_path' => $filename
        ];

        $user = User::addStudents($students);
        foreach($getSubjectId as $subjectId){
            $subjectScore = [
                            'student_id' => $user->id,
                            'class_id' => $data['class'],
                            'subject_id' => $subjectId->id,
                            'Scores' => $data['scores_'.$subjectId->id],
                        ];
            SubjectScore::addSubjectScore($subjectScore);
        }
      
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchStudent(Request $request){
        $data = $request->all();
        $getUserInfo = User::get();
        $getFilterValue = User::getFilterValue($data); 
        // echo "<pre>";print_r($getUserInfo);  exit;
        return view('Students/index', ['students' => $getFilterValue, 'studentInfo' => $getUserInfo]);
    }
}
