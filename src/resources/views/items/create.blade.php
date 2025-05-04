@extends('layouts.app')

@section('title')
    <title>商品出品</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items-create.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>商品を出品する</h1>

        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- 商品画像 -->
            <div class="form-image-group">
                <label class="form-image" for="image">商品画像</label>
                <div class="form-image-upload">
                    <img class="image-preview" id="preview" src="#" alt="画像プレビュー" style="max-width: 200px; display: none;">
                    <label for="image" class="image-select-label">画像を選択する</label>
                    <input class="image-select" type="file" name="image" id="image" accept="image/*"
                        onchange="previewImage(event)" style="display: none;">
                </div>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <!-- 商品の詳細 -->
            <div class="form-group">
                <p class="product-details">商品の詳細</p>
                <div class="category-group">
                    @foreach ($categories as $category)
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}">
                        <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                    @endforeach
                </div>
                @error('categories')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>



            <!-- 商品の状態 -->
            <div class="form-product-group">
                <label class="product-condition" for="condition">商品の状態</label><br>
                <select name="condition" id="condition" class="form-control">
                    <option value="" disabled selected>選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
                @error('condition')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <!-- 商品名と説明 -->
            <div class="form-group">
                <p class="product-details" for="name">商品名と説明</p>
            </div>

            <!-- 商品名 -->
            <div class="form-group">
                <label for="name">商品名</label><br>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand">ブランド名</label><br>
                <input type="text" name="brand_name" id="brand" class="form-control" value="{{ old('brand_name') }}">
                @error('brand')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">商品の説明</label><br>
                <textarea name="description" id="description" rows="5"
                    class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- 販売価格 -->
            <div class="form-group">
                <label for="price">販売価格</label><br>
                <div class="price-input">
                    <span class="yen-mark">¥</span>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
                </div>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- 出品ボタン -->
            <div class="form-button">
                <button type="submit" class="btn btn-primary">出品する</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection