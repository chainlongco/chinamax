@extends('layouts.master')
@section('title', 'My Customers')
@section('content')
<br>

<div class="container">
    <br>
    <h2 class="text-center">My Customers</h2>
    <br>
    
    <div id="customerslist">

    </div>
</div>
<br>

<script>
    $(document).ready(function(){
        $.ajax({
            type:'GET',
            url:'/customers-list',
            success: function(response) {
                $('#customerslist').html(response);
            }
        });
    });
</script>
@endsection