<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'article_images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'thumbnail_image_path',
        'sub_image_path',
        'created_at',
        'article_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at ' => 'datetime',
        ];
    }
}
