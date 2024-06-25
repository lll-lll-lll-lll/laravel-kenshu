<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Tag;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use AuthorizesRequests;
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

    public function edit(Article $article): Factory|Application|View
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->authorize('update', $article);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sub_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $article->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
            $articleImage = $article->images()->firstOrNew();
            if ($request->hasFile('thumbnail_image')) {
                if ($articleImage->thumbnail_image_path) {
                    Storage::disk('public')->delete($articleImage->thumbnail_image_path);
                }
                $thumbnailPath = $request->file('thumbnail_image')->store('images', 'public');
                $articleImage->thumbnail_image_path = $thumbnailPath;
            }

            if ($request->hasFile('sub_image')) {
                if ($articleImage->sub_image_path) {
                    Storage::disk('public')->delete($articleImage->sub_image_path);
                }
                $subImagePath = $request->file('sub_image')->store('images', 'public');
                $articleImage->sub_image_path = $subImagePath;
            }

            if ($articleImage->exists) {
                $articleImage->save();
            } else {
                $articleImage->article_id = $article->id;
                $articleImage->save();
            }

            if ($request->tags) {
                $article->tags()->sync($request->tags);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('記事の更新に失敗しました: ');
        }

        return redirect()->route('articles.show', $article)->with('success', 'Article updated successfully.');
    }
}
