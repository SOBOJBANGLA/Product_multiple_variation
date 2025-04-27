@extends('layouts.app')

@section('section')
<div class="container">
    <h2>Products</h2>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add New</a>

    @foreach($products as $product)
        <div class="card mb-4">
            <div class="card-body">
                <h4>{{ $product->name }} ({{ $product->sku }}) - ${{ $product->price }}</h4>

                <strong>Colors:</strong> 
                @foreach($product->colors as $color)
                    <span class="badge bg-info">{{ $color->color }}</span>
                @endforeach

                <br><strong>Sizes:</strong> 
                @foreach($product->sizes as $size)
                    <span class="badge bg-warning">{{ $size->size }}</span>
                @endforeach

                <div class="mt-3">
                    <strong>Images:</strong> 
                    <div class="d-flex flex-wrap mt-2">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/'.$image->image_path) }}" width="100" height="100" class="me-2 mb-2 rounded" alt="">
                        @endforeach
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
    
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure to delete?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
    
            </div>
        </div>
    @endforeach
</div>
@endsection
