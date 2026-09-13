<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Http\Middleware\CheckDeviceSessionMiddleware;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware(CheckDeviceSessionMiddleware::class);
    }

    public function test_show()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertOk()
            ->assertStatus(200)
            ->assertViewIs('categories.show')
            ->assertViewHas('category', $category);
    }
}
