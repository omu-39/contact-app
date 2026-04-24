<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#f5efe7]">
    <x-header>
        <x-slot name="right">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>logout</button>
            </form>
        </x-slot>
    </x-header>
    <h1>お問い合わせ管理</h1>
</body>
</html>