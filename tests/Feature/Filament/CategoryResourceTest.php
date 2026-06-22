<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use App\Models\User;
use Tests\TestCase;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Pages\ViewCategory;
use App\Models\Category;
use Filament\Actions\DeleteAction;
use Livewire\Livewire;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;

class CategoryResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_admin()->create());
    }

     // Testing a resource list page
    public function test_can_load_list_categories_page()
    {
        $categories = Category::factory(5)->create();

        Livewire::test(ListCategories::class)
            ->assertOk()
            ->assertSuccessful()
            ->assertCanSeeTableRecords($categories);
    }

    public function test_can_render_all_category_columns()
    {
        Livewire::test(ListCategories::class)
            ->assertCanRenderTableColumn('title')
            ->assertCanRenderTableColumn('slug');
    }

    public function test_can_search_category_by_title_and_slug()
    {
        $categories = Category::factory(5)->create();

        Livewire::test(ListCategories::class)
            ->assertOk()
            ->assertCanSeeTableRecords($categories)
            ->searchTable($categories->first()->title)
            ->assertCanSeeTableRecords($categories->take(1))
            ->searchTable($categories->last()->title)
            ->assertCanSeeTableRecords($categories->take(-1));

            Livewire::test(ListCategories::class)
            ->assertOk()
            ->assertCanSeeTableRecords($categories)
            ->searchTable($categories->first()->slug)
            ->assertCanSeeTableRecords($categories->take(1))
            ->searchTable($categories->last()->slug)
            ->assertCanSeeTableRecords($categories->take(-1));
    }

    public function test_can_sort_category()
    {
        $categories = Category::factory(5)->create();

        Livewire::test(ListCategories::class)
            ->assertOk()
            ->assertCanSeeTableRecords($categories)
            ->sortTable('title')
            ->assertCanSeeTableRecords($categories->sortBy('title'), inOrder: true)
            ->sortTable('title', 'desc')
            ->assertCanSeeTableRecords($categories->sortByDesc('title'), inOrder: true);

    }

    public function test_can_bulk_delete_action()
    {
        $categories = Category::factory(5)->create();

        Livewire::test(ListCategories::class)
            ->assertOk()
            ->assertCanSeeTableRecords($categories)
            ->selectTableRecords($categories)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($categories);

        $categories->each(function ($category) {
            $this->assertDatabaseMissing($category);
        });
    }

    // Testing a resource create page
    public function test_can_load_create_category_page()
    {
        Livewire::test(CreateCategory::class)
            ->assertOk();
    }

    public function test_has_form_category()
    {
        Livewire::test(CreateCategory::class)
            ->assertSchemaExists('form');
    }

    public function test_has_all_category_fields()
    {
        Livewire::test(CreateCategory::class)
            ->assertFormFieldExists('title')
            ->assertFormFieldExists('slug');
    }

    public function test_can_create_a_category()
    {
        $category = Category::factory()->make();

        Livewire::test(CreateCategory::class)
            ->assertOk()
            ->fillForm([
                'title' => $category->title,
                'slug' => $category->slug,

            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('categories', [
            'title' => $category->title,
            'slug' => $category->slug,
        ]);
    }

    public function test_can_validate_form_input()
    {
        Livewire::test(CreateCategory::class)
            ->assertOk()
            ->fillForm([
                'title' => null,
                'slug' => null,

            ])
            ->call('create')
            ->assertHasFormErrors([
                'title' => 'required',
                'slug' => 'required',
                ]);
    }

        // Testing a resource edit page
    public function test_can_load_edit_category_page()
    {
        $category = Category::factory()->create();
        Livewire::test(EditCategory::class, ['record' => $category->getKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $category->title,
                'slug' => $category->slug
            ]);
    }

    public function test_can_update_data_category()
    {
        $category = Category::factory()->create();
        $newPlanData = Category::factory()->make();
        Livewire::test(EditCategory::class, ['record' => $category->getKey()])
            ->assertOk()
            ->fillForm([
                    'title' => $newPlanData->title,
                    'slug' => $newPlanData->slug,
            ])
            ->call('save')
            ->assertNotified()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('categories', [
            'title' => $newPlanData->title,
            'slug' => $newPlanData->slug
        ]);
    }

    public function test_validation_form_edit()
    {
        $category = Category::factory()->create();

        Livewire::test(EditCategory::class, ['record' => $category->getKey()])
            ->assertOk()
            ->fillForm([
                'title' => null,
                'slug' => null,

            ])
            ->call('save')
            ->assertHasFormErrors([
                'title' => 'required',
                'slug' => 'required',
            ]);
    }

    public function test_can_delete_a_category(){

        $category = Category::factory()->create();

        Livewire::test(EditCategory::class, ['record' => $category->getKey()])
            ->callAction(DeleteAction::class)
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseMissing($category);

    }

    // Testing a resource view page
    public function test_can_load_view_plan_page()
    {
        $category = Category::factory()->create();
        Livewire::test(ViewCategory::class, ['record' => $category->getKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $category->title,
                'slug' => $category->slug
            ]);
    }

}
