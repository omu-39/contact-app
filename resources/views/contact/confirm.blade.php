<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Confirm</title>
</head>

<body>
    <x-header />
    <main>
        <h2 class="my-10 text-3xl text-center text-3xl font-serif text-[#82776b]">Confirm</h2>
        <form action="/thanks" method="POST">
            @csrf
            <table class="m-auto w-3/5">
                @foreach ([
                ['label' => 'お名前', 'value' => $contact['first_name'] . ' ' . $contact['last_name']],
                ['label' => '性別', 'value' => $contact->gender_label],
                ['label' => 'メールアドレス', 'value' => $contact['email']],
                ['label' => '電話番号', 'value' => $contact['tel']],
                ['label' => '住所', 'value' => $contact['address']],
                ['label' => '建物名', 'value' => $contact['building']],
                ['label' => 'お問い合わせの種類', 'value' => $contact->category->content],
                ['label' => 'お問い合わせ内容', 'value' => $contact['detail']],
                ] as $item)
                <tr class="border border-gray-300 h-16 text-left">
                    <th class="text-white bg-[#af9d8d] w-[30%] pl-10 font-normal">
                        {{ $item['label'] }}
                    </th>
                    <td class="w-[70%] pl-8 text-[#4b5563]">
                        {{ $item['value'] }}
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="flex justify-center items-center gap-4 mt-10">
                <button type="submit" class="bg-[#82776b] text-white py-2 px-8">送信</button>
                <a href="{{ route('contact.create') }}" class="text-[#82776b] underline">修正する</a>
            </div>
        </form>
    </main>
</body>

</html>