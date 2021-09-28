@extends('layouts.master')
@section('title', 'Order')
@section('content')

<?php
    require_once(public_path() ."/shared/component.php");
?>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 text-center">
                <div id="orderMenu">
                    <?php
                        //orderMenuElement($menus);
                    ?>
                    <h1>Menu</h1>
                    @foreach($menus as $menu)
                        <div class="eachMenu" id="eachMenu{{ $menu->id }}">
                            <div class="menuItem" id="menuItem{{ $menu->id }}">
                                <span class="menuItemName{{ $menu->id }}">{{ $menu->name }}</span>
                                <?php
                                    if ((string)($menu->price) !== '0') {
                                ?>
                                        <br>
                                        <span class="menuItemPrice">${{ $menu->price }}</span>
                                <?php        
                                    }
                                ?>
                                <br>            
                            </div>
                            <span class="menuItemDescription">{{ $menu->description }}</span>
                        </div>
                        <br>
                    @endforeach
                </div>    
            </div>
            <div class="col-md-9 text-center ">
                <h1>Choices</h1>
                
                    <div>
                        <div class="choiceItem">
                            Appetizers
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <br>

    <script>
        $(document).ready(function(){
            $(document).on('mouseover', '.eachMenu', function(e){
                e.preventDefault();
                var menuId = retrieveMenuId("eachMenu", this.id);
                $(".menuItemName" + menuId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.eachMenu', function(e){
                e.preventDefault();
                var menuId = retrieveMenuId("eachMenu", this.id)
                $(".menuItemName" + menuId).css("text-decoration","none");
            });
            $(document).on('click', '.eachMenu', function(e){
                e.preventDefault();
                var menuId = retrieveMenuId("eachMenu", this.id)
                //$(".menuItem").css("background-color","white");
                //$("#menuItem" + menuId).css("background-color","yellow");
                $(".menuItem").css("border","3px solid lightgray");
                $("#menuItem" + menuId).css("border","5px solid red");
            });
        });

        function retrieveMenuId(elementClass, elementClassId)
        {
            var lengthClass = elementClass.length;
            var lengthClassId = elementClassId.length;
            var menuId = elementClassId.substr(lengthClass, (lengthClassId-lengthClass));

            return menuId;
        }
    </script>
@endsection