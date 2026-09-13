<?php

namespace App\Repositories\Impl;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Override;

class CategoryRepositoryImpl implements CategoryRepository
{
    #[Override]
    public function show(Category $category): Category
    {
        return $category->loadCount('movies');
    }

    #[Override]
    public function getCategories()
    {
        $category = Category::query()
                        ->orderBy('title', 'asc')
                        ->get();

        return $category->chunk(ceil($category->count() / 3));
    }


}
