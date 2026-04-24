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
            <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                login
            </a>
        </x-slot>
    </x-header>

    <main class="flex min-h-[calc(100vh-80px)] items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <h1 class="text-center text-3xl font-semibold tracking-[0.12em] text-stone-500 font-serif">Register</h1>

            <div class="mt-10 rounded-[32px] bg-white/95 p-10 shadow-xl shadow-gray-300/20 ring-1 ring-gray-200">
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-stone-500">
                        <p class="font-semibold">入力に誤りがあります。</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-500">お名前</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="例: 山田太郎" required autofocus class="mt-3 w-full rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-500">メールアドレス</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="例: test@example.com" required class="mt-3 w-full rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-stone-500">パスワード</label>
                        <input id="password" name="password" type="password" placeholder="例: coachtech106" required class="mt-3 w-full rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-stone-500">パスワード確認</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="例: coachtech106" required class="mt-3 w-full rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                    </div>

                    <button type="submit" class="w-full rounded-md bg-[#726254] px-4 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-sm shadow-gray-400/10 transition hover:bg-[#5f5048]">
                        登録
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>