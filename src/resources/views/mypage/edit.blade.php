@extends('layouts.app')

@section('title')
    <title>プロフィール設定</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage-edit.css') }}">
@endsection

@section('content')

    @php
        $shipping = \App\Models\Address::where('user_id', auth()->id())->first();
    @endphp

    <div class="container">
        <div class="edit-title">
            <p>プロフィール設定</p>
        </div>
        <form method="POST" action="{{ route('mypage.edit') }}" enctype="multipart/form-data">
            @csrf

            <div class="image-group">
                <div class="image-upload">
                    <img class="image-preview" id="preview"
                        src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : '#' }}"
                        alt="プロフィール画像" style="max-width: 200px;"
                        onerror="this.onerror=null; this.src='data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs='" />

                    <label for="image" class="image-select-label">
                        画像を選択する
                    </label>

                    <input class="image-select" type="file" name="image" id="image" accept=".jpeg,.jpg,.png"
                        onchange="previewImage(event)" style="display: none;">
                </div>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', auth()->user()->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code" class="form-control"
                    value="{{ old('postal_code', auth()->user()->postal_code) }}">
                @error('postal_code')
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