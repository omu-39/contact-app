<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    @vite(['resources/css/app.css'])
    @vite(['resources/css/modal.css'])
</head>

<body>
    <x-header>
        <x-slot name="right">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>logout</button>
            </form>
        </x-slot>
    </x-header>
    <main class="w-3/4 m-auto">
        <h2 class="my-10 text-3xl text-center text-3xl font-serif text-[#82776b]">Admin</h2>

        <form action="{{ route('admin.search') }}" method="GET">
            @csrf

            <div class="flex justify-between items-center mb-3">
                <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}" class="w-80 bg-[#f4f4f4] px-5 py-2 border border-[#82776b] text-lg">

                <select name="gender" class="bg-[#f4f4f4] px-5 py-2 border border-[#82776b]">
                    <option value="{{ request('gender') }}">性別</option>
                    <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                </select>

                <select name="category_id" id="category_id" class="bg-[#f4f4f4] px-5 py-2 border border-[#82776b]">
                    <option value="{{ request('category_id') }}">お問い合わせの種類</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                    </option>
                    @endforeach
                </select>

                <input type="date" name="date" value="{{ request('date') }}" class="bg-[#f4f4f4] px-5 py-2 border border-[#82776b]">

                <button type="submit" class="my-6 bg-[#82776b] text-white py-2 px-8">検索</button>
                <a href="{{ route('admin.index') }}" class="my-6 bg-[#cbb994] text-white py-2 px-8">
                    リセット
                </a>
            </div>
            <p class="mb-10">
                <a href="{{ route('admin.export', request()->query()) }}" class="my-6 bg-[#82776b] text-white py-2 px-8">エクスポート</a>
            </p>
        </form>

        <table class="w-full text-left">
            <tr class="bg-[#82776b] text-white">
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>

            @foreach ($contacts as $contact)
            <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
            <td>{{ $contact->gender_label }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->category->content }}</td>
            <td>
                <a href="#modal-{{ $contact->id }}" class="detail-btn">詳細</a>
                <x-modal :contact="$contact" />
            </td>
            </tr>
            @endforeach

        </table>
    </main>
</body>

</html>