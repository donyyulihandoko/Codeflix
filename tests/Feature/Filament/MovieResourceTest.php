<?php

namespace Tests\Feature\Filament;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Crew;
use Tests\TestCase;
use App\Models\User;
use livewire\Livewire;
use App\Models\Movie;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\Movies\Pages\ListMovies;
use App\Filament\Resources\Movies\Pages\ViewMovie;
use App\Filament\Resources\Movies\Pages\CreateMovie;
use App\Filament\Resources\Movies\Pages\EditMovie;
use App\Models\Category;
use Database\Seeders\CategoryMovieSeeder;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Http\UploadedFile;


class MovieResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_admin()->create());
        // Set up any necessary test data or configurations here
    }

    // Testing a resource list page
    public function test_can_load_list_movies_page()
    {
        $movies = Movie::factory(5)->create();

        Livewire::test(ListMovies::class)
            ->assertOk()
            ->assertSuccessful()
            ->assertCanSeeTableRecords($movies);
    }

    public function test_can_render_all_movie_columns()
    {
        Livewire::test(ListMovies::class)
            ->assertCanRenderTableColumn('title')
            ->assertCanRenderTableColumn('categories.title')
            ->assertCanRenderTableColumn('release_date')
            ->assertCanRenderTableColumn('poster');

    }

    public function test_can_search_movie_by_title_and_category_title()
    {
        Category::factory(5)->create();
        $movies = Movie::factory(5)->create();
        $this->seed(CategoryMovieSeeder::class);

        Livewire::test(ListMovies::class)
            ->assertOk()
            ->assertCanSeeTableRecords($movies)
            ->searchTable($movies->first()->title)
            ->assertCanSeeTableRecords($movies->take(1))
            ->searchTable($movies->last()->title)
            ->assertCanSeeTableRecords($movies->take(-1));

        Livewire::test(ListMovies::class)
            ->assertOk()
            ->assertCanSeeTableRecords($movies)
            ->searchTable($movies->first()->categories->first()->title)
            ->assertCanSeeTableRecords($movies->take(1))
            ->searchTable($movies->last()->categories->first()->title)
            ->assertCanSeeTableRecords($movies->take(-1));

    }

    public function test_can_sort_movie()
    {
        $movies = Movie::factory(5)->create();

        Livewire::test(ListMovies::class)
            ->assertOk()
            ->assertCanSeeTableRecords($movies)
            ->sortTable('title')
            ->assertCanSeeTableRecords($movies->sortBy('title'), inOrder: true)
            ->sortTable('title', 'desc')
            ->assertCanSeeTableRecords($movies->sortByDesc('title'), inOrder: true);

        Livewire::test(ListMovies::class)
            ->assertOk()
            ->assertCanSeeTableRecords($movies)
            ->sortTable('release_date')
            ->assertCanSeeTableRecords($movies->sortBy('release_date'), inOrder: true)
            ->sortTable('release_date', 'desc')
            ->assertCanSeeTableRecords($movies->sortByDesc('release_date'), inOrder: true);

    }

    public function test_can_bulk_delete_action()
    {
        $movies = Movie::factory(5)->create();

        Livewire::test(ListMovies::class)
            ->assertOk()
            ->assertCanSeeTableRecords($movies)
            ->selectTableRecords($movies)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($movies);

        $movies->each(function ($movie) {
            $this->assertDatabaseMissing($movie->getTable(), ['id' => $movie->id]);
        });
    }

    // Testing a resource create page
    public function test_can_load_create_movie_page()
    {
        Livewire::test(CreateMovie::class)
            ->assertOk();
    }

    public function test_has_form_movie()
    {
        Livewire::test(CreateMovie::class)
            ->assertSchemaExists('form');
    }

    public function test_has_all_movie_fields()
    {
        Livewire::test(CreateMovie::class)
            ->assertFormFieldExists('title')
            ->assertFormFieldExists('slug')
            ->assertFormFieldExists('categories')
            ->assertFormFieldExists('directors')
            ->assertFormFieldExists('writers')
            ->assertFormFieldExists('stars')
            ->assertFormFieldExists('description')
            ->assertFormFieldExists('release_date')
            ->assertFormFieldExists('duration')
            ->assertFormFieldExists('poster')
            ->assertFormFieldExists('url_720')
            ->assertFormFieldExists('url_1080')
            ->assertFormFieldExists('url_4k');
    }

    public function test_can_create_a_movie()
    {
        $crew = Crew::factory(3)->create();
        $crewIds = $crew->pluck('id')->toArray();
        $categories = Category::factory(2)->create();
        $categoryIds = $categories->pluck('id')->toArray();
        $fakePoster = UploadedFile::fake()->image('poster.jpg');
        $movie = Movie::factory()->make();

        Livewire::test(CreateMovie::class)
            ->assertOk()
            ->fillForm([
                'title' => $movie->title,
                'slug' => $movie->slug,
                'categories' => $categoryIds,
                'directors' => $crewIds,
                'writers' => $crewIds,
                'stars' => $crewIds,
                'description' => $movie->description,
                'release_date' => $movie->release_date->format('Y-m-d'),
                'duration' => $movie->duration,
                'poster' => $fakePoster,
                'url_720' => $movie->url_720,
                'url_1080' => $movie->url_1080,
                'url_4k' => $movie->url_4k,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('movies', [
            'title' => $movie->title,
            'slug' => $movie->slug,
        ]);

        $savedMovie = Movie::where('slug', $movie->slug)->first();
        foreach ($categoryIds as $id) {
            $this->assertDatabaseHas('category_movie', [
                'movie_id' => $savedMovie->id,
                'category_id' => $id,
            ]);
        }
    }

    // Testing a resource edit page
    public function test_can_load_edit_movie_page()
    {
        $movie = Movie::factory()->create();
        Livewire::test(EditMovie::class, ['record' => $movie->slug])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $movie->title,
                'slug' => $movie->slug,
                'description' => $movie->description,
                // 'directors' => $movie->directors,
                // 'writers' => $movie->writers,
                // 'stars' => $movie->stars,
                // 'poster' => $movie->poster,
                'release_date' => $movie->release_date,
                'duration' => $movie->duration,
                'url_720' => $movie->url_720,
                'url_1080' => $movie->url_1080,
                'url_4k' => $movie->url_4k
            ]);
    }

    public function test_can_update_data_movie()
    {
        $movie = Movie::factory()->create();
        $newMovie = Movie::factory()->make();
        $categories = Category::factory(2)->create();
        $categoryIds = $categories->pluck('id')->toArray();
        $crew = Crew::factory(3)->create();
        $crewIds = $crew->pluck('id')->toArray();
        $newPoster = UploadedFile::fake()->image('poster.jpg');

        Livewire::test(EditMovie::class, ['record' => $movie->slug])
            ->assertOk()
            ->fillForm([
                'title' => $newMovie->title,
                'slug' => $newMovie->slug,
                'categories' => $categoryIds,
                'directors' => $crewIds,
                'writers' => $crewIds,
                'stars' => $crewIds,
                'description' => $newMovie->description,
                'release_date' => $newMovie->release_date->format('Y-m-d'),
                'duration' => $newMovie->duration,
                'poster' => $newPoster,
                'url_720' => $newMovie->url_720,
                'url_1080' => $newMovie->url_1080,
                'url_4k' => $newMovie->url_4k,
            ])
            ->call('save')
            ->assertNotified()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('movies', [
            'title' => $newMovie->title,
            'slug' => $newMovie->slug
        ]);

        $this->assertDatabaseMissing('movies', [
            'title' => $movie->title,
            'slug' => $movie->slug
        ]);
    }

    public function test_can_delete_a_movie()
    {

        $movie = Movie::factory()->create();

        Livewire::test(EditMovie::class, ['record' => $movie->slug])
            ->callAction(DeleteAction::class)
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id
        ]);

    }

    // Testing wizard pages
    public function test_moves_to_next_wizard_step()
    {
        Livewire::test(CreateMovie::class)
            ->assertOk()
            ->goToNextWizardStep()
            ->assertHasFormErrors(['title']);
    }

    public function test_moves_to_previous_wizard_step()
    {
        Livewire::test(CreateMovie::class)
            ->assertOk()
            ->goToNextWizardStep()
            ->goToPreviousWizardStep()
            ->assertHasFormErrors();
    }

    public function test_moves_to_the_wizards_second_step()
    {
        livewire::test(CreateMovie::class)
            ->goToWizardStep(2)
            ->assertWizardCurrentStep(2);
    }

    // Testing a resource view page
    public function test_can_load_view_plan_page()
    {
        $movie = Movie::factory()->create();
        Livewire::test(ViewMovie::class, ['record' => $movie->slug])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $movie->title,
                'slug' => $movie->slug,
                'description' => $movie->description,
                // 'director' => $movie->director,
                // 'writers' => $movie->writers,
                // 'stars' => $movie->stars,
                'poster' => $movie->poster,
                'release_date' => $movie->release_date,
                'duration' => $movie->duration,
                'url_720' => $movie->url_720,
                'url_1080' => $movie->url_1080,
                'url_4k' => $movie->url_4k
            ]);
    }
}
