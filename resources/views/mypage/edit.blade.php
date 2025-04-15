@extends('layouts.guest')

@section('title')
    <title>プロフィール設定</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage-edit.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="edit-title">
            <p>プロフィール設定</p>
        </div>

        <div class="image-group">
            <div class="image-upload">
                {{-- プレビュー表示 --}}
                <img class="image-preview" id="preview" src="#" alt="#" style="max-width: 200px;">

                {{-- カスタムボタンとしてlabel使用 --}}
                <label for="image" class="image-select-label">
                    画像を選択する
                </label>

                {{-- 実際のファイル選択 input は非表示 --}}
                <input class="image-select" type="file" name="image" id="image" accept="image/*"
                    onchange="previewImage(event)" style="display: none;">
            </div>
        </div>

        <form method="POST" action="{{ route('mypage.edit') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', auth()->user()->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="zipcode">郵便番号</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control"
                    value="{{ old('zipcode', auth()->user()->zipcode) }}">
                @error('zipcode')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" class="form-control"
                    value="{{ old('address', auth()->user()->address) }}">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" class="form-control"
                    value="{{ old('building', auth()->user()->building) }}">
                @error('building')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-button">
                <button type="submit" class="btn btn-primary">更新する</button>
            </div>
        </form>
    </div>

    {{-- JavaScriptで画像プレビュー --}}
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