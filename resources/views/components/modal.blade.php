<div id="modal-{{ $contact->id }}" class="modal-overlay">
    <div class="modal-window">
        <a href="#" class="close-button">×</a>

        <div class="modal-content">
            <div class="modal-body">
                <table>
                    <tr>
                        <th>お名前</th>
                        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                    </tr>
                    <tr>
                        <th>性別</th>
                        <td>{{ $contact->gender_label }}</td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td>{{ $contact->email }}</td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>{{ $contact->tel }}</td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>{{ $contact->address }}</td>
                    </tr>
                    <tr>
                        <th>建物名</th>
                        <td>{{ $contact->building }}</td>
                    </tr>
                    <tr>
                        <th>お問い合わせの種類</th>
                        <td>{{ $contact->category->content }}</td>
                    </tr>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td>{{ $contact->detail }}</td>
                    </tr>
                </table>

                {{-- 削除ボタンのフォーム --}}
                <div class="modal-footer">
                    <form action="{{ route('admin.delete', $contact->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>