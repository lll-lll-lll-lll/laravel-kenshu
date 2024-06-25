<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen p-6">
    <h2 class="text-2xl font-semibold text-center">{{ $article->title }}</h2>

    <div class="mt-6 p-4 bg-white rounded-lg shadow-md dark:bg-zinc-900">
        <div class="mb-4 text-gray-700 dark:text-gray-300">{{ $article->content }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400">By {{ $article->user->name }}</div>
        @if ($article->images->isNotEmpty())
            @if ($article->images->first()->thumbnail_image_path)
                <img src="{{ url('storage/'.$article->images->first()->thumbnail_image_path) }}" alt="" title="" />
            @endif
            @if ($article->images->first()->sub_image_path)
                <img src="{{ url('storage/'.$article->images->first()->sub_image_path) }}" alt="" title="" />
            @endif
        @endif
        <div class="mt-2">
            @foreach ($article->tags as $tag)
                <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full">{{ $tag->name }}</span>
            @endforeach
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <a href="{{ route('articles.edit', $article->id) }}" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Edit
            </a>
        </div>
    </div>
</div>
</body>
</html>
