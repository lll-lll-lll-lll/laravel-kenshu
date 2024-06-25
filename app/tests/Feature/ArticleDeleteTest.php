<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ArticleDeleteTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_authenticated_user_can_delete_an_article()
    {
        // テストユーザーと記事を作成
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('articles.destroy', $article));

        // リダイレクト先とステータスコードを確認
        $response->assertRedirect(route('articles.index'));
        $response->assertStatus(302);

        // データベースから記事が削除されたことを確認
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_delete_an_article()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        // 認証されていない状態で記事を削除しようとする
        $response = $this->delete(route('articles.destroy', $article));

        // ログインページにリダイレクトされることを確認
        $response->assertRedirect(route('login'));

        // データベースに記事が残っていることを確認
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
        ]);
    }
}
