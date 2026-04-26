<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    @vite(['resources/css/app.css'])
    @vite(['resources/css/modal.css'])
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

    <!-- 検索フォーム -->

    <form action="{{ route('admin.search') }}" method="GET">
    @csrf
        <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">

        <select name="gender">
            <option value="{{ request('gender') }}">性別</option>
            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
        </select>

        <select name="category_id" id="category_id">
            <option value="{{ request('category_id') }}">お問い合わせの種類</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
            @endforeach
        </select>

        <input type="date" name="date" value="{{ request('date') }}">

        <button type="submit">検索</button>
        <a href="{{ route('admin.index') }}">
            リセット
        </a>
        <button></button>
    </form>

    <!-- お問い合わせ一覧 -->

    <table>
        <tr>
            <th>お名前</th>
            <th>性別</th>
            <th>メールアドレス</th>
            <th>お問い合わせの種類</th>
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
</body>

</html>