@extends('layouts.master')
@section('title', ($customer)? "Edit Customer": "New Customer")
@section('content')
<br>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-center">
                    <h3>{{ ($customer)? "Edit Customer": "New Customer" }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer-submit') }}" id="customer_form">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ ($customer)? $customer->id: "" }}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" value="{{ ($customer)? $customer->first_name: "" }}">
                                <span class="text-danger error-text firstname_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" value="{{ ($customer)? $customer->last_name: "" }}">
                                <span class="text-danger error-text lastname_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <?php
                                    if ($customer != null) {
                                        if( preg_match('/^(\d{3})(\d{3})(\d{4})$/', $customer->phone,  $matches)) {
                                            $phoneNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                                        } else {
                                            $phoneNumber = $customer->phone;
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
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{ ($customer)? $customer->email: "" }}">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address1" class="form-label">Address 1</label>
                                <input type="text" class="form-control" name="address1" id="address1" value="{{ ($customer)? $customer->address1: "" }}">
                                <span class="text-danger error-text address1_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="address2" class="form-label">Address 2</label>
                                <input type="text" class="form-control" name="address2" id="address2" value="{{ ($customer)? $customer->address2: "" }}">
                                <span class="text-danger error-text address2_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" name="city" id="city" value="{{ ($customer)? $customer->city: "" }}">
                                <span class="text-danger error-text city_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" name="state" id="state" value="{{ ($customer)? $customer->state: "" }}">
                                <span class="text-danger error-text state_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="zip" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" name="zip" id="zip" value="{{ ($customer)? $customer->zip: "" }}">
                                <span class="text-danger error-text zip_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="card" class="form-label">Card Number</label>
                                <?php
                                    if ($customer != null) {
                                        if( preg_match('/^(\d{4})(\d{4})(\d{4})(\d{4})$/', $customer->card_number,  $matches)) {
                                            $cardNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3] . '-' .$matches[4];
                                        } else {
                                            $cardNumber = $customer->card_number;
                                        }
                                    } else {
                                        $cardNumber = "";
                                    }
                                ?>
                                <input type="text" class="form-control" name="card" id="card" value="{{ $cardNumber }}">
                                <input type="text" id="card1" class="form-control" style="display: none;">
                                <span class="text-danger error-text card_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="expired" class="form-label">Expiration Month/Year</label>
                                <?php
                                    if ($customer != null) {
                                        if( preg_match('/^(\d{2})(\d{2})$/', $customer->expired,  $matches)) {
                                            $expired = $matches[1] . '/' .$matches[2];
                                        } else {
                                            $expired = $customer->expired;
                                        }
                                    } else {
                                        $expired = "";
                                    }
                                ?>    
                                <input type="text" class="form-control" name="expired" id="expired" placeholder="MM/YY" value="{{ $expired }}">
                                <input type="text" id="expired1" class="form-control" style="display: none;">
                                <span class="text-danger error-text expired_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" name="cvv" id="cvv" value="{{ ($customer)? $customer->cvv: "" }}">
                                <span class="text-danger error-text cvv_error"></span>
                            </div>
                        </div>
                        <div style="float:right; display:block;">
                            <button type="submit" class="btn btn-primary" id="submitCustomer">Submit</button>
                            <button type="button" class="btn btn-secondary" id="cancelCustomer">Cancel</button>
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
        $('#customer_form').on('submit', function(e){
        //$(document).on('click','#submitCustomer', function(e){
            e.preventDefault();
            //alert($("#phone").val().replaceAll('-',''));
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
                    //alert(data.status);
                    if (data.status == 0){
                        $.each(data.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status == 2) {
                        alert(data.msg);
                    } else {
                        $('#customer_form')[0].reset();
                        alert(data.msg);
                        const base_path = '{{ url('/') }}\/';
                        window.location.href = base_path + 'customer/list';
                    }
                }
            });
        });

        $('#cancelCustomer').on('click', function(e){
            e.preventDefault();
            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'customer/list';
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

    // ***** Credit Card Number Start *****
    $("input[id='card']").on("input", function () {
        $("input[id='card1']").val(destroyMaskForCard(this.value));
        this.value = createMaskForCard($("input[id='card1']").val());
    })

    function createMaskForCard(string) {
        //console.log(string)
        return string.replace(/(\d{4})(\d{4})(\d{4})(\d{4})/, "$1-$2-$3-$4");
    }

    function destroyMaskForCard(string) {
        //console.log(string)
        return string.replace(/\D/g, '').substring(0, 16);
    }
    // ***** Credit Card Number End *****

    // ***** Expiration Date Start *****
    $("input[id='expired']").on("input", function () {
        $("input[id='expired1']").val(destroyMaskForExpiration(this.value));
        this.value = createMaskForExpiration($("input[id='expired1']").val());
    })

    function createMaskForExpiration(string) {
        //console.log(string)
        return string.replace(/(\d{2})(\d{2})/, "$1/$2");
    }

    function destroyMaskForExpiration(string) {
        //console.log(string)
        return string.replace(/\D/g, '').substring(0, 4);
    }
    // ***** Expiration Date End *****

    // ***** CVV Start *****
    $("input[id='cvv']").on("input", function () {
        $("input[id='cvv']").val(destroyMaskForCVV(this.value));
    })
    function destroyMaskForCVV(string) {
        //console.log(string)
        return string.replace(/\D/g, '').substring(0, 3);
    }
    // ***** CVV End *****
</script>
@endsection