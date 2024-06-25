<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\View;

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
}
