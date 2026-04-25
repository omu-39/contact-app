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
                <label for="tel">電話番号</label>
                <input type="text" name="tel1" id="tel1" value="{{ old('tel1') }}"> -
                <input type="text" name="tel2" id="tel2" value="{{ old('tel2') }}"> -
                <input type="text" name="tel3" id="tel3" value="{{ old('tel3') }}">
                @error('tel')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- 住所 --}}
            <div>
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}">
                @error('address')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div>
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building') }}">
                @error('building')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- お問い合わせの種類 --}}
            <div>
                <label for="category_id">お問い合わせの種類</label>
                <select name="category_id" id="category_id">
                    <option value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- お問い合わせ内容 --}}
            <div>
                <label for="detail">お問い合わせ内容</label>
                <textarea name="detail" id="detail">{{ old('detail') }}</textarea>
                @error('detail')
                <p>{{ $message }}</p>
                @enderror
            </div>

            {{-- ボタン --}}
            <button type="submit">確認画面</button>
        </form>
    </main>
</body>

</html>