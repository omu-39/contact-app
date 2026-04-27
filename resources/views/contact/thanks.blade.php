<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>thanks</title>
</head>

<body>
    <main>
        <div class="relative flex flex-col items-center justify-center h-screen">
            <h1 class="font-serif md:text-[22rem] text-gray-100 select-none whitespace-no-wrap">
                Thank you
            </h1>

            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-[#82776b]">お問い合わせありがとうございました</p>
                <button class="bg-[#82776b] text-white py-2 px-12 mt-8">
                    <a href="/">HOME</a>
                </button>
            </div>
        </div>
    </main>
</body>

</html>