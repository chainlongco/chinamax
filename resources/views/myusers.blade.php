@extends('layouts.master')
@section('title', 'My Users')
@section('content')

<br>

<div class="container">
    <br>
    <h2 class="text-center">My Users</h2>
    <br>

    <div id="userslist">

    </div>
</div>

<div class="modal" id="userModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="userModalBody">
        </div>
    </div>
</div>

<br>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

        $(document).on('click', '.usersave', function(e){
            e.preventDefault();
            var id = retrieveId("usersave", this.id);
            var admin = $('#roleadmin' + id).is(":checked");
            var manager = $('#rolemanager' + id).is(":checked");
            var employee = $('#roleemployee' + id).is(":checked");
            $.ajax({
                type:'GET',
                url:'/user-edit',
                data: {'id':id, 'admin': admin, 'manager':manager, 'employee':employee},
                success: function(response) {
                    //swal(response.msg);
                    alert(response.msg);
                }
            });
        });

        $(document).on('click', '.userdelete', function(e){
            e.preventDefault();
            var id = retrieveId("userdelete", this.id);
            $.ajax({
                type:'GET',
                url:'/user-delete',
                data: {'id':id},
                success: function(response) {
                    $('#userslist').html(response.html);
                    //alert(response.msg);  // Match delete in Customer, Order List - no alert after delete
                }
            });
        });

    });
</script>
@endsection