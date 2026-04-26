<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/thanks" method="POST">
        @csrf
        <h1>確認画面</h1>
        <p>姓: {{ $contact['first_name'] }}</p>
        <p>名: {{ $contact['last_name'] }}</p>
        <p>性別: {{ $contact->gender_label }}</p>
        <p>メールアドレス: {{ $contact['email'] }}</p>
        <p>電話番号: {{ $contact['tel'] }}</p>
        <p>住所: {{ $contact['address'] }}</p>
        <p>建物名: {{ $contact['building'] }}</p>
        <p>お問い合わせの種類: {{ $contact->category->content }}</p>
        <p>お問い合わせ内容: {{ $contact['detail'] }}</p>
        <button type="submit">送信</button>
    </form>
</body>

</html>