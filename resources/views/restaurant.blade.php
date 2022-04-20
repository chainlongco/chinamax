@extends('layouts.master')
@section('title', 'Restaurant Information')
@section('content')
<br>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Restaurant Information</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('restaurant-submit') }}" id="restaurant_form">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ ($restaurant)? $restaurant->id: "" }}">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ ($restaurant)? $restaurant->name: "" }}">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="yearfounded" class="form-label">Year Founded</label>
                                <input type="text" class="form-control numericOnly" name="yearfounded" id="yearfounded" value="{{ ($restaurant)? $restaurant->year_founded: "" }}">
                                <span class="text-danger error-text yearfounded_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="taxrate" class="form-label">Tax Rate</label>
                                <input type="text" class="form-control float-numbers" name="taxrate" id="taxrate" value="{{ ($restaurant)? $restaurant->tax_rate: "" }}">
                                <span class="text-danger error-text taxrate_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <?php
                                    if ($restaurant != null) {
                                        if( preg_match('/^(\d{3})(\d{3})(\d{4})$/', $restaurant->phone,  $matches)) {
                                            $phoneNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                                        } else {
                                            $phoneNumber = $restaurant->phone;
                                        }
                                    } else {
                                        $phoneNumber = "";
                                    }
                                ?>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ $phoneNumber }}">
                                <input type="text" id="phone1" class="form-control" style="display: none;">
                                <span class="text-danger error-text phone_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{ ($restaurant)? $restaurant->email: "" }}">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address1" class="form-label">Address 1</label>
                                <input type="text" class="form-control" name="address1" id="address1" value="{{ ($restaurant)? $restaurant->address1: "" }}">
                                <span class="text-danger error-text address1_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="address2" class="form-label">Address 2</label>
                                <input type="text" class="form-control" name="address2" id="address2" value="{{ ($restaurant)? $restaurant->address2: "" }}">
                                <span class="text-danger error-text address2_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" name="city" id="city" value="{{ ($restaurant)? $restaurant->city: "" }}">
                                <span class="text-danger error-text city_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" name="state" id="state" value="{{ ($restaurant)? $restaurant->state: "" }}">
                                <span class="text-danger error-text state_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="zip" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" name="zip" id="zip" value="{{ ($restaurant)? $restaurant->zip: "" }}">
                                <span class="text-danger error-text zip_error"></span>
                            </div>
                        </div>
                        <div style="float:right; display:block;">
                            <button type="submit" class="btn btn-primary" id="submitRestaurant">Submit</button>
                            <button type="button" class="btn btn-secondary" id="cancelRestaurant">Cancel</button>
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
        $('#restaurant_form').on('submit', function(e){
            //alert("go 1");
        //$(document).on('click','#submitRestaurant', function(e){
            e.preventDefault();
            //alert($("#phone").val().replaceAll('-',''));
            $.ajax({
                //alert("go 2");
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
                    //alert(data.status);
                    if (data.status == 0){
                        $.each(data.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status == 2) {
                        alert(data.msg);
                    } else {
                        $('#restaurant_form')[0].reset();
                        alert(data.msg);
                        const base_path = '{{ url('/') }}\/';
                        window.location.href = base_path + 'restaurant';
                    }
                }
            });
        });

        $('#cancelRestaurant').on('click', function(e){
            e.preventDefault();
            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'menu';
        });

        $(".numericOnly").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9.]/g)) return false;
        });

        $('.float-numbers').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    });

    // ***** Phone Start *****
    $("input[id='phone']").on("input", function () {
        $("input[id='phone1']").val(destroyMaskForPhone(this.value));
        this.value = createMaskForPhone($("input[id='phone1']").val());
    })

    function createMaskForPhone(string) {
        //console.log(string)
        return string.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
    }

    function destroyMaskForPhone(string) {
        //console.log(string)
        return string.replace(/\D/g, '').substring(0, 10);
    }
    // ***** Phone End *****
</script>
@endsection