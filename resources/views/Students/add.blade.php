@include('home/header')
<style>
	canvas {
	height: 150px;
	border-radius: 50%;
	}
	.req-color{
		color: red;
	}
</style>


<div class="container">
	<h1 class="text-center">Add Marksheet</h1>
	<hr />
	@if (count($errors) > 0)
	<div class = "alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
	@endif
	<form enctype='multipart/form-data' method="post" action="/" autocomplete="off">
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label>Student Name<i class='req-color'>*</i></label>
					<input type="text" class="form-control"  placeholder="Student Name" name="student_name" required>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label>Roll No.<i class='req-color'>*</i></label>
					<input type="number" class="form-control" placeholder="Roll No." name="roll_no" min="0" required>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label>Class<i class='req-color'>*</i></label>
					<select class="form-control" name="class" required>
						<option disabled selected>Select Class</option>
						@foreach($subjectClass as $class)
							<option value="{{ $class->id }}">{{ $class->class }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<table class="table">
			<tr>
				<th>Subject</th>
				<th>Scores</th>
			</tr>
			
			@foreach($subjectList as $subject)
			<tr>
				<td>
					<label>{{ $subject->subject_name }}</label>
				</td>
				<td><input type="number" class="form-control" placeholder="Scores" name="scores_{{ $subject->id }}" min="0" required></td>
			</tr>
			@endforeach				
		</table>
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label>Profile</label><br />
					<input type="file" multiple="false" accept="image/*" id=finput onchange="upload()" name="image_path">
				</div>
			</div>
			<div class="col">
				<canvas id= "canv1" ></canvas>
			</div>
			<div class="col">
				<input type="submit" value="Save" class="btn btn-primary" style="margin-top:30px;">
			</div>
			
		</div>
	</form>
</div>


<script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>
<script>
	function upload(){
		var imgcanvas = document.getElementById("canv1");
		var fileinput = document.getElementById("finput");
		var image = new SimpleImage(fileinput);
		image.drawTo(imgcanvas);
	}
</script>
@include('home/footer')