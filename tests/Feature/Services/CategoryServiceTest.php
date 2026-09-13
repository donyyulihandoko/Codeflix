<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\CategoryService;
use App\Models\Category;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->categoryService = $this->app->make(CategoryService::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->categoryService);
    }

    public function test_get_categories(): void
    {
        Category::factory(10)->create();

        $categories = $this->categoryService->getCategories();

        $this->assertNotNull($categories);
        $this->assertIsIterable($categories);
        $this->assertCount(3, $categories);
        $this->assertEquals(10, $categories->flatten()->count());

    }

    public function test_get_detail_category(): void
    {
        $category = \App\Models\Category::factory()->create();

        $categoryDetail = $this->categoryService->getDetailCategory($category);

        $this->assertNotNull($categoryDetail);
        $this->assertEquals($category->id, $categoryDetail->id);
    }
}
