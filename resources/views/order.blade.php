@extends('layouts.master')
@section('title', 'Order')
@section('content')

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 text-center">
                <div id="orderMenu">
                    <h1>Menu</h1>
                    <div class="eachMenuForCombo" id="eachMenuForCombo{{ $comboArray['menu']->id }}">
                        <div class="menuItem" id="menuItem{{ $comboArray['menu']->id }}">
                            <span class="menuItemName{{ $comboArray['menu']->id }}">{{ $comboArray['menu']->name }}</span>
                            <p class="menuItemDescription">{{ $comboArray['menu']->description }}</p>
                            @foreach($comboArray['products'] as $product)
                                <div class="productItem" id="productItem{{ $product->id }}">
                                    <span class="productItemName{{ $product->id }}">{{ $product->name }}</span>
                                    <br>
                                    <span class="productItemDescription">{{ $product->description }} -- </span> 
                                    <span class="productItemPrice">${{ $product->price }}</span>           
                                </div>
                            @endforeach         
                        </div>      
                    </div>
                    <br>

                    @foreach($menus as $menu)
                        <div class="eachMenu" id="eachMenu{{ $menu->id }}">
                            <div class="menuItem" id="menuItem{{ $menu->id }}">
                                <span class="menuItemName{{ $menu->id }}">{{ $menu->name }}</span>
                                <!--<br>-->
                                <p class="menuItemDescription">{{ $menu->description }}</p>            
                            </div>      
                        </div>
                        <br>
                    @endforeach

                    <div class="eachMenuForSingle" id="eachMenuForSingle{{ $singleArray['menu']->id }}">
                        <div class="menuItem" id="menuItem{{ $singleArray['menu']->id }}">
                            <span class="menuItemName{{ $singleArray['menu']->id }}">{{ $singleArray['menu']->name }}</span>
                            <p class="menuItemDescription">{{ $singleArray['menu']->description }}</p>
                            @foreach($singleArray['singles'] as $single)
                                <div class="singleItem" id="singleItem{{ $single->id }}">
                                    <span class="singleItemName{{ $single->id }}">{{ $single->name }}</span>
                                    <br>
                                    <span class="singleItemDescription">{{ $single->description }}</span>           
                                </div>
                            @endforeach
                        </div>      
                    </div>

                </div>    
            </div>
            <div class="col-md-9 text-center ">
                <div class="orderChoices">
                    
                    
                </div>
            </div>
        </div>
    </div>
    <br>



    <script>
        $(document).ready(function(){
            $("#productItem13").trigger('click');
        });
    </script>
@endsection