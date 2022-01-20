@extends('layouts.master')
@section('title', 'Checkout')
@section('content')

<?php
    require_once(public_path() ."/shared/component.php");
?>

<br>
<div id="mycheckout">
    <div class="container-fluid">
        <form method="POST" action="{{ route('place-order-submit') }}" id="place_order_form">
            @csrf
            <div class="row px-5">
                <div class="col-md-6">
                    <div class="py-4">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    $title = "Checkout";
                                    if (Session::has('cart')) {
                                        $orderId = Session::get('cart')->orderId;
                                        if ($orderId != null) {
                                            $title = "Checkout (From Order History)";
                                        }
                                    }
                                ?>
                                <h4>{{ $title }}</h4>
                            </div>
                            <?php
                                $customer = null;
                                $phoneNumber = "";
                                $cardNumber = "";
                                $expired = "";
                                if (Session::has('customer')) {
                                    $customer = Session::get('customer');
                                
                                    if( preg_match('/^(\d{3})(\d{3})(\d{4})$/', $customer->phone,  $matches)) {
                                        $phoneNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                                    } else {
                                        $phoneNumber = $customer->phone;
                                    }

                                    if( preg_match('/^(\d{4})(\d{4})(\d{4})(\d{4})$/', $customer->card_number,  $matches)) {
                                        $cardNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3] . '-' .$matches[4];
                                    } else {
                                        $cardNumber = $customer->card_number;
                                    }

                                    if( preg_match('/^(\d{2})(\d{2})$/', $customer->expired,  $matches)) {
                                        $expired = $matches[1] . '/' .$matches[2];
                                    } else {
                                        $expired = $customer->expired;
                                    }
                                }
                            ?>
                            <div class="col-md-6 text-center">
                                <button style="width: 40%" type="button" class="btn btn-primary" id="customerlogin" {{ $customer?"disabled":"" }}>Login</button>
                                <button style="width: 40%" type="button" class="btn btn-primary" id="customersignup" {{ $customer?"disabled":"" }}>Signup</button>
                            </div>
                        </div>

                        <div class="py-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h5>Guess Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="mb-3 col-md-6">
                                            <label for="firstname" class="form-label">First Name*</label>            
                                            <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $customer?$customer->first_name:"" }}">
                                            <span class="text-danger error-text firstname_error"></span>  
                                        </div>
                                        <div class="mb-3 col-md-6">     
                                            <label for="lastname" class="form-label">Last Name*</label>                                
                                            <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $customer?$customer->last_name:"" }}">
                                            <span class="text-danger error-text lastname_error"></span>
                                        </div>       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone*</label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $customer?$phoneNumber:"" }}">
                                            <input type="text" id="phone1" class="form-control" style="display: none;">
                                            <span class="text-danger error-text phone_error"></span>
                                        </div> 
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address*</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $customer?$customer->email:"" }}">
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h5>Credit Card Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="card" class="form-label">Card Number*</label>
                                            <input type="text" class="form-control" name="card" id="card" value="{{ $customer?$cardNumber:"" }}">
                                            <input type="text" id="card1" class="form-control" style="display: none;">
                                            <span class="text-danger error-text card_error"></span>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="expired" class="form-label">Expiration Month/Year*</label>
                                            <input type="text" class="form-control" name="expired" id="expired" value="{{ $customer?$expired:"" }}">
                                            <input type="text" id="expired1" class="form-control" style="display: none;">
                                            <span class="text-danger error-text expired_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="cvv" class="form-label">CVV*</label>
                                            <input type="text" class="form-control" name="cvv" id="cvv" value="{{ ($customer)?$customer->cvv:"" }}">
                                            <span class="text-danger error-text cvv_error"></span>
                                        </div> 
                                        <div class="col-md-6">
                                            <label for="zip" class="form-label">Zip Code*</label>
                                            <input type="text" class="form-control" name="zip" id="zip" value="{{ ($customer)?$customer->zip:"" }}">
                                            <span class="text-danger error-text zip_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="orderlist">
                                <?php
                                    orderListDivElementForCheckout();             
                                ?>
                            </div>
                            <div id="ordernote">
                                <?php
                                    orderNoteDivElementForCheckout();
                                ?>
                            </div>
                            <div id="pricedetail">
                                <?php 
                                    priceDetailDivElementForCheckout();
                                ?>
                            </div>
                            <br>
                            <div class="text-center">
                                <button style="width: 60%" type="submit" class="btn btn-primary" id="placeorder" {{ (Session::has('cart'))?"":"disabled" }}>Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#place_order_form').on('submit', function(e){
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
                    //alert(data.status);
                    if (data.status == 0){
                        $.each(data.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $('#place_order_form')[0].reset();
                        alert(data.msg);
                        const base_path = '{{ url('/') }}\/';
                        if (data.editOrder) {
                            window.location.href = base_path + 'order';
                        } else {
                            window.location.href = base_path + 'checkout';
                        }       
                    }
                }
            });
        });

        $('#customerlogin').on('click', function(){
            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'customerLogin';
        });
        $('#customersignup').on('click', function(){
            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'customerSignup';
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
            return string.replace(/\D/g, '').substring(0, 17);
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
    });
</script>
@endsection