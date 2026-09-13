<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Movie;
use Override;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Models\MyList;
use Tests\TestCase;


class MyListControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware([CheckDeviceSessionMiddleware::class]);
    }

    public function test_index()
    {
        $response = $this->get(route('mylists.index'));

        $response->assertOk();
    }

    public function test_store_success()
    {
        $movie = Movie::factory()->create();

        $response = $this->from(route('mylists.index'))
            ->post(route('mylists.store', $movie ));

        $response->assertStatus(302)
            ->assertRedirectBack()
            ->assertSessionHas('success', 'Success add this Movie to Your List');
    }

    public function test_destroy()
    {
        $myList = MyList::factory()->create();

        $response = $this->from(route('mylists.index'))
            ->delete(route('mylists.destroy', $myList ));

        $response->assertStatus(302)
            ->assertRedirectBack()
            ->assertSessionHas('success', 'Success remove this Movie from Your List');
    }
}
