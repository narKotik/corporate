<?php

namespace Corp\Policies;

use Corp\Article;
use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

//php artisan make:policy ArticlePolicy


class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user)
    {
        return $user->canDo('ADD_ARTICLES');
    }
    
    public function edit(User $user)
    {
        return $user->canDo('UPDATE_ARTICLES');
    }

    public function destroy(User $user, Article $article)
    {
        //return $user->canDo('DELETE_ARTICLES') && $user->id == $article->user_id; // второе условие что б юзер мог удалить только свои статьи
        return $user->canDo('DELETE_ARTICLES');
    }
}
