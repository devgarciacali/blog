<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the category is published (public visible).
     */
    public function published(?User $user, Category $category)
    {
        return $category->status == 1;
    }
}
