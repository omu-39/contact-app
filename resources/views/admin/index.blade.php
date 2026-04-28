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
            <form method="POST" action="{{ route('logout') }}" class="block w-full h-full">
                @csrf
                <button type="submit" class="w-full h-full flex items-center justify-center">
                    logout
                </button>
            </form>
        </x-slot>
    </x-header>
    <main class="w-3/5 m-auto">
        <h2 class="my-10 text-3xl text-center text-3xl font-serif text-[#82776b]">Admin</h2>

        <form action="{{ route('admin.search') }}" method="GET">
            @csrf

            <div class="flex justify-between items-center">
                <!-- 名前・メールアドレス検索 -->
                <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}" class="w-80 bg-[#f4f4f4] px-5 py-2 border border-[#82776b] text-lg">

                <!-- 性別選択 -->
                <div class="relative inline-block">
                    <select name="gender" class="bg-[#f4f4f4] px-5 py-2 border border-[#82776b] appearance-none pr-6 cursor-pointer">
                        <option value="">性別</option>
                        <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                    </select>
                    <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none color text-[#82776b]">
                        ▼
                    </span>
                </div>

                <!-- お問い合わせの種類選択 -->
                <div class="relative inline-block">
                    <select name=" category_id" id="category_id" class="bg-[#f4f4f4] px-4 py-2 border border-[#82776b] appearance-none cursor-pointer">
                        <option value="">お問い合わせの種類</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                        @endforeach
                    </select>
                    <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-[#82776b]">
                        ▼
                    </span>
                </div>

                <!-- 日付選択 -->
                <div class="relative inline-block">
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="appearance-none bg-[#f4f4f4] px-5 py-2 border border-[#82776b] cursor-pointer">
                    <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none color text-[#82776b]">
                        ▼
                    </span>
                </div>

                <!-- リセットボタン -->
                <button type="submit" class="my-6 bg-[#82776b] text-white py-2 px-8">検索</button>
                <a href="{{ route('admin.index') }}" class="my-6 bg-[#cbb994] text-white py-2 px-8">
                    リセット
                </a>
            </div>
        </form>

        <!-- エクスポートボタン -->
        <div class="flex justify-between">
            <a href="{{ route('admin.export', request()->query()) }}" class="my-6 bg-[#82776b] text-white py-2 px-8">
                エクスポート
            </a>
            {{ $contacts->links('vendor.pagination.tailwind') }}
        </div>

        <!-- お問い合わせ一覧 -->
        <table class="w-full text-left table-fixed [&_th]:px-8 [&_td]:px-8">
            <colgroup>
                <col class="w-1/6"> {{-- お名前の幅 --}}
                <col class="w-32"> {{-- 性別の幅 --}}
                <col class="w-1/4"> {{-- メールアドレスの幅 --}}
                <col class="w-auto"> {{-- お問い合わせの種類の幅 --}}
                <col class="w-32"> {{-- 詳細ボタンの幅 --}}
            </colgroup>

            <tr class="bg-[#82776b] text-white">
                <th class="py-2">お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th colspan="2">お問い合わせの種類</th>
            </tr>

            @foreach ($contacts as $contact)
            <tr class="border border-collapse border-[#d8d3cd] h-12 text-[#82776b] text-lg">
                <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                <td>{{ $contact->gender_label }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->category->content }}</td>
                <td class="text-right w-32">
                    <a href="#modal-{{ $contact->id }}" class="detail-btn bg-[#faf8f6] px-3 py-1 border border-[#d4c6b6] text-[#d4c6b6]">詳細</a>
                    <x-modal :contact="$contact" />
                </td>
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>