@include('home.header');
<div class="container">
        <h1 class="text-center">Student Marksheet Information</h1>
        <hr />
        <div class="text-right container-header-button">
                <a href="\create" class="btn btn-info">+ Add</a>
        </div>
        <div class="container-header-button">
                <form action="{{ url('/searchStudent') }}" method="get">
                <div class="form-row">
                <div class="col">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <select class="form-control" name="student_id">
                                <option selected disabled>Select Student Name</option>
                        @if(!empty($studentInfo) && $studentInfo->count())
                                @foreach($studentInfo as $key => $student)
                                        <option value="{{ $student->id }}"
                                        <?php 
                                        if(isset($_GET['student_id']) && $student->id == $_GET['student_id']){
                                                echo 'selected';
                                        }
                                        ?>>{{ $student->student_name }}</option>
                                @endforeach
                        @endif
                        </select>
                </div>
                <div class="col">
                        <select class="form-control" name="roll_no">
                                <option selected disabled>Select Roll No</option>
                                @if(!empty($studentInfo) && $studentInfo->count())
                                @foreach($studentInfo as $key => $student)
                                        <option value="{{ $student->roll_no }}"  
                                        <?php 
                                        if(isset($_GET['roll_no']) && $student->roll_no == $_GET['roll_no']){
                                                echo 'selected';
                                        }
                                        ?>
                                        >{{ $student->roll_no }}</option>
                                @endforeach
                        @endif
                        </select>
                </div>
                <div class="col">
                        <input type="number" name="obtained_marks" class="form-control" placeholder="Marks Obtained In Any Subject"  value="{{ isset($_GET['obtained_marks']) ? $_GET['obtained_marks'] : '' }}"/>
                </div>
                <div class="col">
                        <input type="submit" class="btn btn-success" value="Search" />
                        <input type="reset" class="btn btn-primary" value="Reset" onclick="resetFun()"/>
                </div>
                </div>
                </form>
        </div>
      
        <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Roll No</th>
                        <th>Subject Details</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($students) && $students->count())
                
                @foreach($students as $key => $student)
                <tr>
                        @if(!empty($student->image_path))
                        <td><img src="{{ asset('Image/'.$student->image_path) }}" alt="Profile" title="Profile" height="140px" width="100px" class="table-profile-colm"></td>
                        @else
                        <td>-</td>
                        @endif
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->roll_no }}</td>
                        <td>
                                @if(!empty($student['subjectScore']) && $student['subjectScore']->count())
                                <table class="table">
                                        <tr>
                                                <th>Class</th>
                                                <th>Subject Name</th>
                                                <th>Score</th>
                                        </tr>
                                        @foreach($student['subjectScore'] as $subjectScore)
                                        <tr>
                                                <td>{{ $subjectScore['studentClass'][0]->class }}</td>
                                                <td>{{ $subjectScore['studentSubject'][0]->subject_name }}</td>
                                                <td>{{ $subjectScore->Scores }}</td>
                                        </tr>
                                        @endforeach
                                </table>
                                @else
                                        <p>Subject Score Search Not Found.</p>
                                @endif
                        </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
                @endif
                </tbody>
        </table>
        <div>{!! $students->links() !!}</div>
</div>
<script>
$(document).ready(function () {
    $('#example').DataTable({
        paging: false,
        ordering: false,
        info: false,
    });
    
});
function resetFun(){
   document.location.href = '/';
}
</script>
@include('home.footer');
