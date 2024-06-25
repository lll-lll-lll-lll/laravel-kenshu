<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
//    public function viewAny(User $user): bool
//    {
//        // 認証済みユーザーのみ記事一覧を表示できる場合
//        return $user->isAuthenticated();
//    }

    /**
     * Determine whether the user can view the model.
     */
//    public function view(User $user, Article $article): bool
//    {
//
//    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // すべての認証済みユーザーが記事を作成できる場合
        return $user->isAuthenticated();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        // ユーザーが記事の所有者である場合に更新を許可
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        // ユーザーが記事の所有者である場合に削除を許可
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
//    public function restore(User $user, Article $article): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can permanently delete the model.
     */
//    public function forceDelete(User $user, Article $article): bool
//    {
//        //
//    }
}
