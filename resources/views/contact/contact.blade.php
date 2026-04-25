<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>お問い合わせフォーム</h1>
    <main>
        <form action="{{ route('contact.confirm') }}" method="POST">
            @csrf

            {{-- 名前 --}}
            <div>
                <label for="first_name">姓</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="last_name">名</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- 性別 --}}
            <div>
                <label for="gender">性別</label>
                <input type="radio" name="gender" id="gender" value="1" {{ old('gender') === '1' ? 'checked' : '' }}>男性
                <input type="radio" name="gender" id="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }}>女性
                <input type="radio" name="gender" id="gender" value="3" {{ old('gender') === '3' ? 'checked' : '' }}>その他
                @error('gender')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- 電話番号 --}}
            <div>

        </form>
    </main>
</body>

</html>