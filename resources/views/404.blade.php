@include('Home/header')
<div class="container">
    <h1 class="text-center md-2 pd-2">404 Not Found.</h1>
    @if(isset($error_message))
    <p>
        {{ $error_message }}
    </p>
    @endif
</div>
@include('Home/footer')