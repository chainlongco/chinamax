@extends('layouts.master')
@section('title', 'Register')
@section('content')
<br>

<?php
    use Illuminate\Support\Facades\Session;
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h3>User Register</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/register/submit') }}" id="register_form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">User Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div>
                            <div style="float:left; display:block;">
                                <a href="{{ route('auth.login') }}">I already have an account, sign in</a>
                            </div>
                            <div style="float:right; display:block;">
                                <button type="submit" class="btn btn-primary" id="submitRegister">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>

<br>

<script>
    $(document).ready(function(){
        $('#register_form').on('submit', function(e){
        //$(document).on('click','#submitRegister', function(e){
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(data){
                    if (data.status == 0){
                        $.each(data.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $('#register_form')[0].reset();
                        alert(data.msg);
                        const base_path = '{{ url('/') }}\/';
                        window.location.href = base_path + 'login';
                    }
                }
            });
        });
    });
</script>
@endsection