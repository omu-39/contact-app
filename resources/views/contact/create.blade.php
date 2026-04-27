<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Contact</title>
</head>

<body>
    <x-header />
    <main>
        <h2 class="my-10 text-3xl text-center text-2xl font-bold text-stone-500">Contact</h2>
        <form action="/confirm" method="POST" class="w-3/5 mx-auto flex flex-col gap-6">
            @csrf

            {{-- 名前 --}}
            <div class="flex gap-4 items-center">
                <label class="w-1/3 text-lg text-stone-500">
                    お名前 <span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex flex-col gap-1">
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="例: 山田" class="bg-gray-100 px-5 py-2">
                    @error('first_name')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-1 flex flex-col gap-1">
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="例: 太郎" class="bg-gray-100 px-5 py-2">
                    @error('last_name')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 性別 --}}
            <div class="flex gap-4 items-center">
                <label for="gender" class="w-1/3 text-lg text-stone-500">
                    性別<span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex gap-20">
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="gender" value="1" class="accent-stone-500" checked> 男性
                    </label>
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="gender" value="2" class="accent-stone-500"> 女性
                    </label>
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="gender" value="3" class="accent-stone-500"> その他
                    </label>
                </div>
                @error('gender')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="flex gap-4 items-center">
                <label for="email" class="w-1/3 text-lg text-stone-500">
                    メールアドレス<span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex flex-col gap-1">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="例: test@example.com" class="bg-gray-100 px-5 py-2">
                    @error('email')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 電話番号 --}}
            <div class="flex gap-4 items-center">
                <label for="tel" class="w-1/3 text-lg text-stone-500">
                    電話番号<span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex flex-col gap-1">
                    <div class="flex-1 flex justify-between">
                        <input type="text" name="tel1" id="tel1" value="{{ old('tel1') }}" placeholder="080" class="bg-gray-100 px-5 py-2"> -
                        <input type="text" name="tel2" id="tel2" value="{{ old('tel2') }}" placeholder="1234" class="bg-gray-100 px-5 py-2"> -
                        <input type="text" name="tel3" id="tel3" value="{{ old('tel3') }}" placeholder="5678" class="bg-gray-100 px-5 py-2">
                    </div>
                    @error('tel')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 住所 --}}
            <div class="flex gap-4 items-center">
                <label for="address" class="w-1/3 text-lg text-stone-500">
                    住所<span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex flex-col">
                    <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" class="bg-gray-100 px-5 py-2">
                    @error('address')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 建物名 --}}
            <div class="flex gap-4 items-center">
                <label for="building" class="w-1/3 text-lg text-stone-500">
                    建物名
                </label>
                <div class="flex-1 flex flex-col">
                    <input type="text" name="building" id="building" value="{{ old('building') }}" placeholder="例: 千駄ヶ谷マンション101" class="bg-gray-100 px-5 py-2">
                    @error('building')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- お問い合わせの種類 --}}
            <div class="flex gap-4 items-center">
                <label for="category_id" class="w-1/3 text-lg text-stone-500">
                    お問い合わせの種類<span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex flex-col">
                    <select name="category_id" id="category_id" class="w-1/2 bg-gray-100 px-4 py-2 text-gray-500">
                        <option value="">選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- お問い合わせ内容 --}}
            <div class="flex gap-4 items-start">
                <label for="detail" class="w-1/3 text-lg text-stone-500">
                    お問い合わせ内容<span class="text-red-500">※</span>
                </label>
                <div class="flex-1 flex flex-col">
                    <textarea name="detail" id="detail" class="h-32 bg-gray-100 px-5 py-3" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                    @error('detail')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ボタン --}}
            <button type="submit" class=" m-auto my-6 bg-stone-600/80 text-white py-2 px-8">
                確認画面
            </button>
        </form>
    </main>
</body>

</html>