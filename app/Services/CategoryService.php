<?php

namespace App\Services;

use App\Models\Category;

interface CategoryService
{
    public function getDetailCategory(Category $category): Category;

    public function getCategories();
}
