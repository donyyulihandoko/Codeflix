<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member()->create());
    }

    public function test_index_success(): void
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertStatus(200);
    }
}
