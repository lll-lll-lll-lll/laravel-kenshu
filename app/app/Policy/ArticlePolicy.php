<?php
declare(strict_types=1);

namespace App\Policy;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can create articles.
     *
     * @return mixed
     */
    public function create(User $user): mixed
    {
        // すべての認証済みユーザーが記事を作成できる場合
        return $user->isAuthenticated();
    }

    /**
     * Determine whether the user can update the article.
     */
    public function update(User $user, Article $article): bool
    {
        // ユーザーが記事の所有者である場合に更新を許可
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article): mixed
    {
        // ユーザーが記事の所有者である場合に削除を許可
        return $user->id === $article->user_id;
    }
}
