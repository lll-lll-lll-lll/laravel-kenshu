<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Article</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">

<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md dark:bg-zinc-900">
        <h2 class="text-2xl font-semibold text-center">Edit Article</h2>

        @if (session('success'))
            <div class="p-4 mt-4 text-green-800 bg-green-100 border border-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mt-4 text-red-800 bg-red-100 border border-red-200 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content', $article->content) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="thumbnail_image" class="block text-sm font-medium text-gray-700">Thumbnail Image</label>
                <input type="file" name="thumbnail_image" id="thumbnail_image" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @if ($article->images->isNotEmpty() && $article->images->first()->thumbnail_image_path)
                    <img src="{{ url('storage/'.$article->images->first()->thumbnail_image_path) }}" alt="" class="mt-4">
                @endif
            </div>

            <div class="mb-4">
                <label for="sub_image" class="block text-sm font-medium text-gray-700">Sub Image</label>
                <input type="file" name="sub_image" id="sub_image" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @if ($article->images->isNotEmpty() && $article->images->first()->sub_image_path)
                    <img src="{{ url('storage/'.$article->images->first()->sub_image_path) }}" alt="" class="mt-4">
                @endif
            </div>

            <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Update Article
            </button>
        </form>
    </div>
</div>
</body>
</html>
