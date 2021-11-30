@extends('layouts.master')
@section('title', 'Customer Sign up')
@section('content')
<br>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Customer Sign up</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer-signup-submit') }}" id="customer_signup_form">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname">
                                <span class="text-danger error-text firstname_error"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname">
                                <span class="text-danger error-text lastname_error"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                            <input type="text" id="phone1" class="form-control" style="display: none;">
                            <span class="text-danger error-text phone_error"></span>
                        </div> 
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="text-danger error-text password_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitCustomerSignup">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>

<br>

<script>
    $(document).ready(function(){
        // ***** Phone Start *****
        $("input[id='phone']").on("input", function () {
            $("input[id='phone1']").val(destroyMaskForPhone(this.value));
            this.value = createMaskForPhone($("input[id='phone1']").val());
        })

        function createMaskForPhone(string) {
            console.log(string)
            return string.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
        }

        function destroyMaskForPhone(string) {
            console.log(string)
            return string.replace(/\D/g, '').substring(0, 10);
        }
        // ***** Phone End *****

        $('#customer_signup_form').on('submit', function(e){
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
                        $('#customer_signup_form')[0].reset();
                        //alert(data.msg);
                        const base_path = '{{ url('/') }}\/';
                        window.location.href = base_path + 'order';
                    }
                }
            });
        });
    });
</script>
@endsection