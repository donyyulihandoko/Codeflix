<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function __construct(private CategoryService $categoryService)
    {
        //
    }

    public function show(Category $category): Response
    {
        return response()->view('categories.show', [
            'category' => $this->categoryService->getDetailCategory($category)
        ]);
    }

}
