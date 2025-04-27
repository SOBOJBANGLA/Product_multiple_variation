@extends('layouts.app')

@section('section')
<div class="container">
    <h2>Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label>SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="mb-3">
            <label>Upload New Images (optional)</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <div class="mb-3">
            <label>Colors</label>
            <input type="text" name="colors[]" class="form-control" value="{{ implode(',', $product->colors->pluck('color')->toArray()) }}">
        </div>

        <div class="mb-3">
            <label>Sizes</label>
            <input type="text" name="sizes[]" class="form-control" value="{{ implode(',', $product->sizes->pluck('size')->toArray()) }}">
        </div>

        <div class="mb-3">
            <label>Existing Images</label><br>
            @foreach($product->images as $image)
                <img src="{{ asset('storage/'.$image->image_path) }}" width="100" class="me-2 mb-2" alt="">
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
