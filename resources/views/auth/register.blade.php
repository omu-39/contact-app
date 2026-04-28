<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FashionablyLate</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-[#f5efe7] text-gray-700">
    <x-header>
        <x-slot name="right">
            <a href="{{ route('login') }}" class="w-full h-full flex items-center justify-center">
                login
            </a>
        </x-slot>
    </x-header>

    <main class="bg-[#f5efe7] text-gray-700">
        <h1 class="text-center text-3xl text-stone-500 font-serif my-16">Register</h1>

        <form method="POST" action="{{ route('register') }}" class="m-auto w-1/3 bg-white rounded px-8 py-10 border-2 border-gray-200" novalidate>
            @csrf

            <div class="m-auto w-2/3 flex flex-col mt-6 mb-10">
                <label for="name" class="text-2xl font-semibold text-[#82776b] mb-4">お名前</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="例: 山田太郎" class="bg-[#eee] py-2 px-5">
                @error('name')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="m-auto w-2/3 flex flex-col mb-10">
                <label for="email" class="text-2xl font-semibold text-[#82776b] mb-4">メールアドレス</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="例: test@example.com" required class="bg-[#eee] py-2 px-5">
                @error('email')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="m-auto w-2/3 flex flex-col mb-10">
                <label for="password" class="text-2xl font-semibold text-[#82776b] mb-4">パスワード</label>
                <input id="password" name="password" type="password" placeholder="例: coachtech106" required class="bg-[#eee] py-2 px-5">
                @error('password')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="block m-auto bg-[#726254] px-10 py-2 my-16 text-white">
                登録
            </button>
        </form>
    </main>
</body>

</html>