<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleUpdateTest extends TestCase
{
    use RefreshDatabase;
    public function test_authenticated_user_can_update_an_article()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $existingThumbnail = UploadedFile::fake()->image('existing_thumbnail.jpg');
        $existingSubImage = UploadedFile::fake()->image('existing_sub_image.jpg');

        $articleImage = ArticleImage::factory()->create([
            'article_id' => $article->id,
            'thumbnail_image_path' => $existingThumbnail->store('images', 'public'),
            'sub_image_path' => $existingSubImage->store('images', 'public'),
        ]);

        $newThumbnail = UploadedFile::fake()->image('new_thumbnail.jpg');
        $newSubImage = UploadedFile::fake()->image('new_sub_image.jpg');
        $tags = Tag::where('name', '総合')->firstOrCreate(['name' => '総合']);
        $tagIds = [$tags->id];
        $response = $this->actingAs($user)->put(route('articles.update', $article), [
            'title' => 'Updated Test Article',
            'content' => 'This is an updated test article.',
            'thumbnail_image' => $newThumbnail,
            'sub_image' => $newSubImage,
            'tags' => $tagIds,
        ]);

        // 検証
        $response->assertStatus(302);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Test Article',
            'content' => 'This is an updated test article.',
            'user_id' => $user->id,
        ]);

        // 既存の画像が削除されているかテスト
        Storage::disk('public')->assertMissing('images/'.$articleImage->thumbnail_image_path);
        Storage::disk('public')->assertMissing('images/'.$articleImage->sub_image_path);
    }
}
