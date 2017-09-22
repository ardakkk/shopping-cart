@extends('layouts.master')
@section('title')
    Shopping Cart
    @endsection
@section('content')
    @foreach($products as $product)
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="{{$product->imagePath}}" alt="A Game of thrones">
                <div class="caption clearfix">
                    <h3>{{$product->title}}</h3>
                    <p>{{$product->description}}</p>
                    <div class="pull-left">
                        <strong>{{$product->price}}$</strong>
                    </div>
                    <p><a href="{{route('product.addToCart',['id' => $product->id])}}" class="btn btn-success pull-right" role="button">Add to cart</a></p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endsection