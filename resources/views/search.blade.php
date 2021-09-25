@extends('layouts.master')
@section('title', 'Search Result')
@section('content')
    <br>
    <div class="trend-wraper">
        <div class="text-center">    
            <h2>Search Result</h2> 
        </div>
        @foreach ($products as $product)
            <a href="detail/{{ $product->id }}">
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