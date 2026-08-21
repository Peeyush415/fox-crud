<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h2>Add Product</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input
				type="text"
				name="name"
				class="form-control"
				value="{{ old('name') }}"
			>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea
				name="description"
				class="form-control"
			>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input
				type="number"
				step="0.01"
				name="price"
				class="form-control"
				value="{{ old('price') }}"
			>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input
				type="number"
				name="stock"
				class="form-control"
				value="{{ old('stock') }}"
			>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
</body>
</html>
