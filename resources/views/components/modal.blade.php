<div id="modal-{{ $contact->id }}" class="modal-overlay">
    <a href="#" class="modal-background-closer"></a>

    <div class="modal-window">
        <a href="#" class="close-button">×</a>

        <table class="w-full text-[#82776b]">
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
            <tr class="align-top">
                <th class="text-left py-4 w-1/3 font-bold">
                    {{ $item['label'] }}
                </th>
                <td class="py-4 w-2/3 text-left">
                    {{ $item['value'] }}
                </td>
            </tr>
            @endforeach
        </table>

        <form action="{{ route('admin.delete', $contact->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">削除</button>
        </form>
    </div>
</div>