@extends('layouts.master')
@section('title', 'Product Detail')
@section('content')
    <br>
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('/images/' . $product->gallery) }}">
                </div>
                <div class="col-md-6 ">
                    <a href="/products">Go Back to Products</a>
                    <br>
                    <h5>
                        Name: {{ $product->name }}
                        <br>
                        Price: ${{ $product->price }}
                    </h5>
                    <p>
                        Detail: ${{ $product->description }}
                        <br>
                        Category: {{ $product->category }}
                    </p>
                    <a href="/cart/{{ $product->id }}" class="btn btn-primary">Add to Cart</a>
                    <button class="btn btn-success">Checkout</button>
                </div>
            </div>
        </div>
    <br>
@endsection
