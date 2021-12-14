@extends('layouts.master')
@section('title', 'My Orders')
@section('content')
<br>

<h2 class="text-center">My Orders</h2>
<br>
<div id="orderslist" style="padding:20px">
</div>


<br>

<script>
    $(document).ready(function(){
        $.ajax({
            type:'GET',
            url:'/orders-list',
            success: function(response) {
                $('#orderslist').html(response);
            }
        });
    });
</script>
@endsection