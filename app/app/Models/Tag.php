<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'tags';

    protected $fillable = [
        'id',
        'name',
        'created_at',
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

    public function articles():BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tags', 'tag_id', 'article_id')
            ->withTimestamps();
    }
}
