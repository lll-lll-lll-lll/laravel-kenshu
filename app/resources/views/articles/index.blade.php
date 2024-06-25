<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">

<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen p-6">
    @if (session('success'))
        <div class="p-4 mt-4 text-green-800 bg-green-100 border border-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6">
        @foreach ($articles as $article)
            <div class="mb-4 p-4 bg-white rounded-lg shadow-md dark:bg-zinc-900">
                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">By {{ $article->user->name }}</div>
                @if ($article->images->isNotEmpty())
                    @if ($article->images->first()->thumbnail_image_path)
                        <img src="{{ url('storage/'.$article->images->first()->thumbnail_image_path) }}" alt="" title="" />
                    @endif
                @endif
                <div class="mt-2">
                    @foreach ($article->tags as $tag)
                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
