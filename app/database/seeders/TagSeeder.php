<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()->create(['name' => '総合']);
        Tag::factory()->create(['name' => 'テクノロジー']);
        Tag::factory()->create(['name' => 'モバイル']);
        Tag::factory()->create(['name' => 'アプリ']);
        Tag::factory()->create(['name' => 'エンタメ']);
        Tag::factory()->create(['name' => 'ビューティー']);
        Tag::factory()->create(['name' => 'ファッション']);
        Tag::factory()->create(['name' => 'ライフスタイル']);
        Tag::factory()->create(['name' => 'ビジネス']);
        Tag::factory()->create(['name' => 'グルメ']);
        Tag::factory()->create(['name' => 'スポーツ']);
    }
}
