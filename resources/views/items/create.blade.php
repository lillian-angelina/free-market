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
                    {{-- プレビュー表示 --}}
                    <img class="image-preview" id="preview" src="#" alt="画像プレビュー" style="max-width: 200px; display: none;">

                    {{-- カスタムボタンとしてlabel使用 --}}
                    <label for="image" class="image-select-label">
                        画像を選択する
                    </label>

                    {{-- 実際のファイル選択 input は非表示 --}}
                    <input class="image-select" type="file" name="image" id="image" accept="image/*"
                        onchange="previewImage(event)" style="display: none;">
                </div>
            </div>

            <!-- 商品の詳細 -->
            <div class="form-group">
                <p class="product-details">商品の詳細</p>
                <div class="category-group">
                    <input type="checkbox" name="categories[]" value="ファッション" id="cat-fashion">
                    <label for="cat-fashion">ファッション</label>

                    <input type="checkbox" name="categories[]" value="家電" id="cat-electronics">
                    <label for="cat-electronics">家電</label>

                    <input type="checkbox" name="categories[]" value="インテリア" id="cat-interior">
                    <label for="cat-interior">インテリア</label>

                    <input type="checkbox" name="categories[]" value="レディース" id="cat-ladies">
                    <label for="cat-ladies">レディース</label>

                    <input type="checkbox" name="categories[]" value="メンズ" id="cat-men">
                    <label for="cat-men">メンズ</label>

                    <input type="checkbox" name="categories[]" value="コスメ" id="cat-cosme">
                    <label for="cat-cosme">コスメ</label>

                    <input type="checkbox" name="categories[]" value="本" id="cat-books">
                    <label for="cat-books">本</label>

                    <input type="checkbox" name="categories[]" value="ゲーム" id="cat-game">
                    <label for="cat-game">ゲーム</label>

                    <input type="checkbox" name="categories[]" value="スポーツ" id="cat-sports">
                    <label for="cat-sports">スポーツ</label>

                    <input type="checkbox" name="categories[]" value="キッチン" id="cat-kitchen">
                    <label for="cat-kitchen">キッチン</label>

                    <input type="checkbox" name="categories[]" value="ハンドメイド" id="cat-handmade">
                    <label for="cat-handmade">ハンドメイド</label>

                    <input type="checkbox" name="categories[]" value="アクセサリー" id="cat-accessory">
                    <label for="cat-accessory">アクセサリー</label>

                    <input type="checkbox" name="categories[]" value="おもちゃ" id="cat-toy">
                    <label for="cat-toy">おもちゃ</label>

                    <input type="checkbox" name="categories[]" value="ベビー・キッズ" id="cat-baby">
                    <label for="cat-baby">ベビー・キッズ</label>
                </div>
            </div>


            <!-- 商品の状態 -->
            <div class="form-product-group">
                <label class="product-condition" for="condition">商品の状態</label><br>
                <select name="condition" id="condition" class="form-control">
                    <option value="選択してください" disabled selected>選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
            </div>

            <!-- 商品名と説明 -->
            <div class="form-group">
                <p class="product-details" for="name">商品名と説明</p>
            </div>

            <!-- 商品名 -->
            <div class="form-group">
                <label for="name">商品名</label><br>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="brand">ブランド名</label><br>
                <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}">
            </div>

            <div class="form-group">
                <label for="description">商品の説明</label><br>
                <textarea name="description" id="description" rows="5"
                    class="form-control">{{ old('description') }}</textarea>
            </div>

            <!-- 販売価格 -->
            <div class="form-group">
                <label for="price">販売価格</label><br>
                <div class="price-input">
                    <span class="yen-mark">¥</span>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
                </div>
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