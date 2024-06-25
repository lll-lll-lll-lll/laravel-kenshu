<?php

namespace Tests\Feature;

use App\Models\Article;
use Tests\TestCase;
class ArticleViewTest extends TestCase
{
    public function test_user_can_view_an_article()
    {
        $article = Article::factory()->create();
        $response = $this->get(route('articles.show', $article));

        // 検証
        $response->assertStatus(200);
        $response->assertSee($article->title);
        $response->assertSee($article->content);
    }
    public function test_user_can_view_on_list():void{
        $articles = Article::factory()->count(3)->create();
        $response = $this->get(route('articles.index'));

        // 検証
        $response->assertStatus(200);
        // 各記事のタイトルがページに表示されていることを確認
        foreach ($articles as $article) {
            $response->assertSee($article->title);
        }
    }
}
