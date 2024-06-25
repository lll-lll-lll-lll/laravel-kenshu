<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Tag;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    public function index(): Factory|View|Application
    {
        $articles = Article::with('user', 'tags')->get();
        return view('articles.index', compact('articles'));
    }
    public function show(Article $article): Factory|Application|View
    {
        return view('articles.show', compact('article'));
    }


    public function create(): Factory|Application|View
    {
        $tags = Tag::all();
        return view('articles.create', compact('tags'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sub_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $article = Article::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'user_id' => $user->id,
            ]);

            $articleImage = new ArticleImage();
            $articleImage->article_id = $article->id;

            if ($request->hasFile('thumbnail_image') && $request->hasFile('sub_image')) {
                $thumbnailPath = $request->file('thumbnail_image')->store('images', 'public');
                $subImagePath = $request->file('sub_image')->store('images', 'public');
                $articleImage->thumbnail_image_path = $thumbnailPath;
                $articleImage->sub_image_path = $subImagePath;
            }
            if ($request->tags) {
                $article->tags()->sync($request->tags);
            }

            DB::commit();

            return redirect()->route('articles.index')->with('success', '記事が作成されました');
        } catch (Exception) {
            DB::rollBack();

            if (isset($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            if (isset($subImagePath)) {
                Storage::disk('public')->delete($subImagePath);
            }

            return redirect()->back()->withErrors('記事の作成に失敗しました: ');
        }
    }

}
