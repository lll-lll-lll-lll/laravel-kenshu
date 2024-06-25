<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleCreateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_authenticated_user_can_create_an_article()
    {
        $user = User::factory()->create();

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $subImage = UploadedFile::fake()->image('sub_image.jpg');

        $tags = [];
        $tags[] = Tag::where('name', '総合')->firstOrCreate(['name' => '総合']);
        $response = $this->actingAs($user)->post(route('articles.store'), [
            'title' => 'Test Article',
            'content' => 'This is a test article.',
            'thumbnail_image' => $thumbnail,
            'sub_image' => $subImage,
            'tags' => $tags,
        ]);
        $response->assertStatus(302);
    }
}
