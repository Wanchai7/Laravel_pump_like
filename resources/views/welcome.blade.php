@extends('layouts.main')

@section('content')
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>ราคา:</strong> {{ $product->price }} บาท</p>
                        <a href="#" class="btn btn-primary">เพิ่มลงตะกร้า</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection