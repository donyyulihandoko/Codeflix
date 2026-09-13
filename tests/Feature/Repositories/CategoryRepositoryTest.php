<?php

namespace Tests\Feature\Repositories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\CategoryRepository;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private CategoryRepository $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = $this->app->make(CategoryRepository::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->categoryRepository);
    }

    public function test_get_categories(): void
    {
        Category::factory(10)->create();

        $categories = $this->categoryRepository->getCategories();

        $this->assertNotNull($categories);
        $this->assertIsIterable($categories);
        $this->assertCount(3, $categories);
        $this->assertEquals(10, $categories->flatten()->count());
    }

    public function test_show_category(): void
    {
        $category = Category::factory()->create();

        $categoryDetail = $this->categoryRepository->show($category);

        $this->assertNotNull($categoryDetail);
        $this->assertEquals($category->id, $categoryDetail->id);
    }
}
