@extends('layouts.app')

@section('content')
<style>
    .product-image-container {
        position: relative;
    }

    .add-to-cart-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        text-align: center;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .product-image-container:hover .add-to-cart-overlay {
        opacity: 1;
    }
</style>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="product-image-container">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="add-to-cart-overlay">
                            <button class="btn btn-light add-to-cart-btn" data-product-id="{{ $product->id }}">เพิ่มลงตะกร้า</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>ราคา:</strong> {{ $product->price }} บาท</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection