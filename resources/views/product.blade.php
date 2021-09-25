@extends('layouts.master')
@section('title', 'Product')
@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php  $count = 0 ?>
                        @foreach ($products as $product)
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $count }}" class="{{ $count==0?'active':'' }}" aria-current="true" aria-label="Slide {{ $count }}"></button>
                            <?php $count++ ?>
                        @endforeach
                    </div>     
                    <div class="carousel-inner">     
                        @foreach ($products as $product)    
                            <div class="carousel-item {{ $product->id ==1?'active':''}}">
                                <a href="/detail/{{ $product->id }}">
                                    <img src="{{ asset('/images/' . $product->gallery)}}" class="d-block w-100" alt="Image not available">
                                </a>
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $product->name }}</h5>
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                        @endforeach   
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="trend-wraper">
        <div class="text-center">    
            <h2>Trending Product</h2> 
        </div>
        @foreach ($products as $product)
            <a href="/detail/{{ $product->id }}">
                <div class="trend-product">
                    <img src="{{ asset('/images/' . $product->gallery)}}" class="trend-img">
                    <div class="">
                        <h5>{{ $product->name }}</h5>
                    </div>
                </div>
            </a>
        @endforeach   
    </div>

    <br>
    <br>
@endsection