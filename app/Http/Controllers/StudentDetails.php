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
        try {
            $getUserInfo = User::get();
            $getAllStudents = User::getAllStudents();
            return view('Students/index', ['students' => $getAllStudents, 'studentInfo' => $getUserInfo]);
        } catch (\Exception $e) {
            return view('404', ['error_message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $subjectList = Subject::getAllSubjectList();
            $subjectClass = StudentClass::getAllStudentClassList();
            return view('Students/add', ['subjectList' => $subjectList, 'subjectClass' => $subjectClass]);
        } catch (\Exception $e) {
            return view('404', ['error_message' => $e->getMessage()]);
        }
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
            'roll_no' => 'required|numeric|unique:users',
        ],
        [
            'student_name.required' => 'The Student Name field is required.',
            'roll_no.required' => 'The Roll No field is required.',
            'roll_no.unique' => 'Roll No  has already been taken.',
        ]);

        try {
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
        } catch (\Exception $e) {
            return view('404', ['error_message' => $e->getMessage()]);
        }
      

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
        try {
            $data = $request->all();
            $getUserInfo = User::get();
            $getFilterValue = User::getFilterValue($data);
            return view('Students/index', ['students' => $getFilterValue, 'studentInfo' => $getUserInfo]); 
        } catch (\Exception $e) {
            return view('404', ['error_message' => $e->getMessage()]);
        }
        
    }

    public function getStudents(){
        try{
            $userDetails = User::getAllStudentWithAPI();
            if (count($userDetails) > 0){
                foreach($userDetails as $key => $value){
                    $totalScore = 0;
                    foreach($value as $userdetail){
                        $totalScore += $userdetail->Scores;
                        $userdetail->profile = url('')."/image/".$userdetail->image_path;
                        unset($userdetail->image_path);
                    }
                    $userDetails[$key]['total_score'] = $totalScore;
                }
                
            } else {
                return response()->json(['error' => 'Student Details Not Found.'], 404);
            }
            $userDetails = collect($userDetails)->sortBy('total_score')->reverse()->toArray();

            return response()->json($userDetails);
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
        
    }
}
