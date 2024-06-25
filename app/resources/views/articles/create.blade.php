<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Article</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md dark:bg-zinc-900">
        <h2 class="text-2xl font-semibold text-center">Create Article</h2>

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

        @auth
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Contents</label>
                    <textarea name="content" id="content" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="thumbnail_image" id="thumbnail_image" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="sub_image" id="sub_image" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tags</label>
                    <div class="mt-2 space-y-2">
                        @foreach ($tags as $tag)
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="tag{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="tag{{ $tag->id }}" class="font-medium text-gray-700">{{ $tag->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Article
                </button>
            </form>
        @else
            <div class="p-4 mt-4 text-red-800 bg-red-100 border border-red-200 rounded">
                Please <a href="{{ route('login') }}" class="text-indigo-600 underline">login</a> to create an article.
            </div>
        @endauth
    </div>
</div>
</body>
</html>
