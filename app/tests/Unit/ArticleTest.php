<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_it_belongs_to_a_user(): void
    {
        $user_id = rand(1,3);
        $activeUsers = DB::table('users')->select('id')->where('id', $user_id);
        $articles = DB::table('articles')
            ->whereIn('user_id', $activeUsers)
            ->get();
        foreach ($articles as $article) {
            $this->assertEquals($user_id, $article->user_id);
        }
        $this->assertNotEmpty($articles);
    }

    public function test_get_article_with_image_tag_user():void {
        $user_id = rand(1,3);
        $article = Article::factory()->create(['user_id' => $user_id]);
        $article = Article::with(['user', 'images', 'tags'])
            ->where('id', $article->id)
            ->where('user_id', $user_id)
            ->first();
        $this->assertNotNull($article);
        $this->assertNotNull($article->user);
        $this->assertNotNull($article->images);
        $this->assertNotNull($article->tags);
    }

    public function test_get_article_list_with_image_tag_user():void{
        $user_id = rand(1,3);
        $articles = Article::with(['user', 'images', 'tags'])
            ->where('user_id', $user_id)
            ->get();
        $this->assertNotEmpty($articles);
        foreach ($articles as $article) {
            $this->assertNotNull($article->user);
            $this->assertNotNull($article->images);
            $this->assertNotNull($article->tags);
        }
    }
}
