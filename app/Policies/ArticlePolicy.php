<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        //
    }

    public function published(?User $user, Article $article)
    {
       if($article->status== 1){
           return true;
       }else{
            return false;
         }
    }
}
