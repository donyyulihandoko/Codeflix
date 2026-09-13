<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Crews\Pages\CreateCrew;
use App\Filament\Resources\Crews\Pages\EditCrew;
use App\Filament\Resources\Crews\Pages\ListCrews;
use App\Filament\Resources\Crews\Pages\ViewCrew;
use App\Models\Crew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

class CrewResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->is_admin()->create());
    }

      // Testing a resource list page
    public function test_can_load_list_crew_page()
    {
        $crews = Crew::factory(5)->create();

        Livewire::test(ListCrews::class)
            ->assertOk()
            ->assertSuccessful()
            ->assertCanSeeTableRecords($crews);
    }

    public function test_can_render_all_crew_columns()
    {
        Livewire::test(ListCrews::class)
            ->assertCanRenderTableColumn('name')
            ->assertCanRenderTableColumn('photo')
            ->assertCanRenderTableColumn('place_of_birth')
            ->assertCanRenderTableColumn('birth_date');
    }

    public function test_can_search_crew_by_name()
    {
        $crews = Crew::factory(5)->create();

        Livewire::test(ListCrews::class)
            ->assertOk()
            ->assertCanSeeTableRecords($crews)
            ->searchTable($crews->first()->name)
            ->assertCanSeeTableRecords($crews->take(1))
            ->searchTable($crews->last()->name)
            ->assertCanSeeTableRecords($crews->take(-1));

    }

    public function test_can_sort_crew()
    {
        $crews = Crew::factory(5)->create();

        Livewire::test(ListCrews::class)
            ->assertOk()
            ->assertCanSeeTableRecords($crews)
            ->sortTable('name')
            ->assertCanSeeTableRecords($crews->sortBy('name'), inOrder: true)
            ->sortTable('name', 'desc')
            ->assertCanSeeTableRecords($crews->sortByDesc('name'), inOrder: true);

            Livewire::test(ListCrews::class)
            ->assertOk()
            ->assertCanSeeTableRecords($crews)
            ->sortTable('birth_date')
            ->assertCanSeeTableRecords($crews->sortBy('birth_date'), inOrder: true)
            ->sortTable('birth_date', 'desc')
            ->assertCanSeeTableRecords($crews->sortByDesc('birth_date'), inOrder: true);

    }

    public function test_can_bulk_delete_action()
    {
        $crews = Crew::factory(5)->create();

        Livewire::test(ListCrews::class)
            ->assertOk()
            ->assertCanSeeTableRecords($crews)
            ->selectTableRecords($crews)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($crews);

        $crews->each(function ($crew) {
            $this->assertDatabaseMissing($crew);
        });
    }

     // Testing a resource create page
    public function test_can_load_create_crew_page()
    {
        Livewire::test(CreateCrew::class)
            ->assertOk();
    }

    public function test_has_form_crew()
    {
        Livewire::test(CreateCrew::class)
            ->assertSchemaExists('form');
    }

    public function test_has_all_crew_fields()
    {
        Livewire::test(CreateCrew::class)
            ->assertFormFieldExists('name')
            ->assertFormFieldExists('slug')
            ->assertFormFieldExists('birth_date')
            ->assertFormFieldExists('place_of_birth')
            ->assertFormFieldExists('photo')
            ->assertFormFieldExists('biography');
    }

    public function test_can_create_a_crew()
    {
        $crew = Crew::factory()->make();
        $photo = UploadedFile::fake()->image('poto.jpg');
        Livewire::test(CreateCrew::class)
            ->assertOk()
            ->fillForm([
                'name' => $crew->name,
                'slug' => $crew->slug,
                'photo' => $photo,
                'biography' => $crew->biography,
                'birth_date' => $crew->birth_date,
                'place_of_birth' => $crew->place_of_birth,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect()
            ->assertHasNoFormErrors();

    $this->assertDatabaseHas('crews', [
            'name' => $crew->name,
            'slug' => $crew->slug,
        ]);
    }

    // public function test_can_validate_form_input()
    // {
    //     Livewire::test(CreateCrew::class)
    //         ->assertOk()
    //         ->fillForm([
    //             'title' => null,
    //             'slug' => null,

    //         ])
    //         ->call('create')
    //         ->assertHasFormErrors([
    //             'title' => 'required',
    //             'slug' => 'required',
    //             ]);
    // }


     // Testing a resource edit page
    public function test_can_load_edit_crew_page()
    {
        $crew = Crew::factory()->create();
        Livewire::test(EditCrew::class, ['record' => $crew->slug])
            ->assertOk()
            ->assertSchemaStateSet([
                'name' => $crew->name,
                'slug' => $crew->slug,
                // 'photo' => $crew->photo,
                'biography' => $crew->biography,
                // 'birth_date' => $crew->birth_date,
                'place_of_birth' => $crew->place_of_birth,
            ]);
    }

    public function test_can_update_data_crew()
    {
        $crew = Crew::factory()->create();
        $newCrew = Crew::factory()->make();
        $photo = UploadedFile::fake()->image('poto.jpg');
        Livewire::test(EditCrew::class, ['record' => $crew->slug])
            ->assertOk()
            ->fillForm([
                    'name' => $newCrew->name,
                    'slug' => $newCrew->slug,
                    'photo' => $photo,
                    'biography' => $newCrew->biography,
                    'birth_date' => $newCrew->birth_date,
                    'place_of_birth' => $newCrew->place_of_birth,
            ])
            ->call('save')
            ->assertNotified()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('crews', [
            'name' => $newCrew->name,
            'slug' => $newCrew->slug
        ]);
    }

    // public function test_validation_form_edit()
    // {
    //     $category = Category::factory()->create();

    //     Livewire::test(EditCrew::class, ['record' => $category->slug])
    //         ->assertOk()
    //         ->fillForm([
    //             'title' => null,
    //             'slug' => null,

    //         ])
    //         ->call('save')
    //         ->assertHasFormErrors([
    //             'title' => 'required',
    //             'slug' => 'required',
    //         ]);
    // }

    public function test_can_delete_a_crew(){

        $crew = Crew::factory()->create();

        Livewire::test(EditCrew::class, ['record' => $crew->slug])
            ->callAction(DeleteAction::class)
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseMissing($crew);

    }

    // Testing a resource view page
    public function test_can_load_view_crew_page()
    {
        $crew = Crew::factory()->create();
        Livewire::test(ViewCrew::class, ['record' => $crew->slug])
            ->assertOk()
            ->assertSchemaStateSet([
                'name' => $crew->name,
                'slug' => $crew->slug,
                // 'photo' => $crew->photo,
                'biography' => $crew->biography,
                'birth_date' => $crew->birth_date,
                'place_of_birth' => $crew->place_of_birth,
            ]);
    }

}
