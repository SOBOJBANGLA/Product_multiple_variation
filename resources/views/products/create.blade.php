@extends('layouts.app')

@section('section')
<div class="container">
    <h2>Create Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>SKU</label>
            <input type="text" name="sku" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Images</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <div class="mb-3">
            <label>Colors (Comma Separated)</label>
            <input type="text" name="colors[]" class="form-control" placeholder="Red, Blue, Green">
        </div>

        <div class="mb-3">
            <label>Sizes (Comma Separated)</label>
            <input type="text" name="sizes[]" class="form-control" placeholder="S, M, L, XL">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
