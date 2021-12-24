@extends('layouts.master')
@section('title', 'My Users')
@section('content')

<?php
    require_once(public_path() ."/shared/component.php");
?>

<br>

<div class="container">
    <br>
    <h2 class="text-center">My Users</h2>
    <br>

    <div id="userslist">

    </div>
</div>
<br>

<script>
    $(document).ready(function(){
        $("#usersDatatable").DataTable({
            //scrollY: "530px",
            scrollCollapse: true,
            "columnDefs": [{
                targets: [6],
                orderable: false
            }]
        });

        $.ajax({
            type:'GET',
            url:'/users-list',
            success: function(response) {
                $('#userslist').html(response);
            }
        });

        $(document).on('click', '.usersave', function(){
            var id = retrieveId("usersave", this.id);
            var admin = $('#roleadmin' + id).is(":checked");
            var owner = $('#roleowner' + id).is(":checked");
            var manager = $('#rolemanager' + id).is(":checked");
            var employee = $('#roleemployee' + id).is(":checked");
            $.ajax({
                type:'GET',
                url:'/user-edit',
                data: {'id':id, 'admin': admin, 'owner':owner, 'manager':manager, 'employee':employee},
                success: function(response) {
                    //$('#userslist').html(response);
                    alert(response.msg);
                }
            });
        });

        $(document).on('click', '.userdelete', function(){
            var id = retrieveId("userdelete", this.id);
            $.ajax({
                type:'GET',
                url:'/user-delete',
                data: {'id':id},
                success: function(response) {
                    $('#userslist').html(response);
                }
            });
        });

    });
</script>
@endsection