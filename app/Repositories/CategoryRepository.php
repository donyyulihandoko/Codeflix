<?php

namespace App\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function show(Category $category): Category;

    public function getCategories();

}
