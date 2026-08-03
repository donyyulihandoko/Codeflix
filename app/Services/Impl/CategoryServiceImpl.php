<?php

namespace App\Services\Impl;

use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use App\Models\Category;
use Override;

class CategoryServiceImpl implements CategoryService
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
        //
    }

    public function getDetailCategory(Category $category): Category
    {
        return $this->categoryRepository->show($category);
    }

    #[Override]
    public function getCategories()
    {
        return $this->categoryRepository->getCategories();
    }
}
