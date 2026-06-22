<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Plans\Pages\CreatePlan;
use App\Filament\Resources\Plans\Pages\EditPlan;
use App\Filament\Resources\Plans\Pages\ListPlans;
use App\Filament\Resources\Plans\Pages\ViewPlan;
use App\Models\Plan;
use App\Models\User;
use Filament\Actions\DeleteAction;
// use Illuminate\Support\Str;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PlanResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_admin()->create());
    }

    // Testing a resource list page
    public function test_can_load_list_plans_page()
    {
        $plans = Plan::factory(5)->create();

        Livewire::test(ListPlans::class)
            ->assertOk()
            ->assertSuccessful()
            ->assertCanSeeTableRecords($plans);
    }

    public function test_can_render_all_plan_columns()
    {
        Plan::factory(5)->create();

        Livewire::test(ListPlans::class)
            ->assertCanRenderTableColumn('title')
            ->assertCanRenderTableColumn('price')
            ->assertCanRenderTableColumn('resolution')
            ->assertCanRenderTableColumn('duration')
            ->assertCanRenderTableColumn('max_devices');
    }

    public function test_can_search_plans_by_title()
    {
        $plans = Plan::factory(5)->create();

        Livewire::test(ListPlans::class)
            ->assertOk()
            ->assertCanSeeTableRecords($plans)
            ->searchTable($plans->first()->title)
            ->assertCanSeeTableRecords($plans->take(1))
            ->searchTable($plans->last()->title)
            ->assertCanSeeTableRecords($plans->take(-1));
    }

    public function test_can_sort_plan_by_title()
    {
        $plans = Plan::factory(5)->create();

        Livewire::test(ListPlans::class)
            ->assertOk()
            ->assertCanSeeTableRecords($plans)
            ->sortTable('title')
            ->assertCanSeeTableRecords($plans->sortBy('title'), inOrder: true)
            ->sortTable('title', 'desc')
            ->assertCanSeeTableRecords($plans->sortByDesc('title'), inOrder: true);
    }

    public function test_can_bulk_delete_action()
    {
        $plans = Plan::factory(5)->create();

        Livewire::test(ListPlans::class)
            ->assertOk()
            ->assertCanSeeTableRecords($plans)
            ->selectTableRecords($plans)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($plans);

        $plans->each(function ($plan) {
            $this->assertDatabaseMissing($plan);
        });
    }

    // Testing a resource create page
    public function test_can_load_create_plan_page()
    {
        Livewire::test(CreatePlan::class)
            ->assertOk();
    }

    public function test_has_form_plan()
    {
        Livewire::test(CreatePlan::class)
            ->assertSchemaExists('form');
    }

    public function test_has_all_plan_fields()
    {
        Livewire::test(CreatePlan::class)
            ->assertFormFieldExists('title')
            ->assertFormFieldExists('price')
            ->assertFormFieldExists('duration')
            ->assertFormFieldExists('resolution')
            ->assertFormFieldExists('max_devices');
    }

    public function test_can_create_a_plan()
    {
        $plan = Plan::factory()->make();

        Livewire::test(CreatePlan::class)
            ->assertOk()
            ->fillForm([
                'title' => $plan->title,
                'price' => $plan->price,
                'duration' => $plan->duration,
                'resolution' => $plan->resolution,
                'max_devices' => $plan->max_devices,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('plans', [
            'title' => $plan->title,
            'price' => $plan->price,
            'duration' => $plan->duration,
            'resolution' => $plan->resolution,
            'max_devices' => $plan->max_devices,
        ]);
    }

    public function test_can_validate_form_input()
    {
        Livewire::test(CreatePlan::class)
            ->assertOk()
            ->fillForm([
                'title' => null,
                'price' => null,
                'duration' => null,
                'resolution' => null,
                'max_devices' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'title' => 'required',
                'price' => 'required',
                'duration' => 'required',
                'resolution' => 'required',
                'max_devices' => 'required',
                ]);
    }

    // Testing a resource edit page
    public function test_can_load_edit_plan_page()
    {
        $plan = Plan::factory()->create();
        Livewire::test(EditPlan::class, ['record' => $plan->getKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $plan->title,
                'price' => $plan->price,
                'duration' => $plan->duration,
                'resolution' => $plan->resolution,
                'max_devices' => $plan->max_devices,
            ]);
    }

    public function test_can_update_data_plan()
    {
        $plan = Plan::factory()->create();
        $newPlanData = Plan::factory()->make();
        Livewire::test(EditPlan::class, ['record' => $plan->getKey()])
            ->assertOk()
            ->fillForm([
                    'title' => $newPlanData->title,
                    'price' => $newPlanData->price,
                    'duration' => $newPlanData->duration,
                    'resolution' => $newPlanData->resolution,
                    'max_devices' => $newPlanData->max_devices,
            ])
            ->call('save')
            ->assertNotified()
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('plans', [
            'title' => $newPlanData->title,
            'price' => $newPlanData->price,
            'duration' => $newPlanData->duration,
            'resolution' => $newPlanData->resolution,
            'max_devices' => $newPlanData->max_devices,
        ]);
    }

    public function test_validation_form_edit()
    {
        $plan = Plan::factory()->create();

        Livewire::test(EditPlan::class, ['record' => $plan->getKey()])
            ->assertOk()
            ->fillForm([
                'title' => null,
                'price' => null,
                'duration' => null,
                'resolution' => null,
                'max_devices' => null,
            ])
            ->call('save')
            ->assertHasFormErrors([
                'title' => 'required',
                'price' => 'required',
                'duration' => 'required',
                'resolution' => 'required',
                'max_devices' => 'required',
            ]);
    }

    public function test_can_delete_a_plan(){

        $plan = Plan::factory()->create();

        Livewire::test(EditPlan::class, ['record' => $plan->getKey()])
            ->callAction(DeleteAction::class)
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseMissing($plan);

    }

    // Testing a resource view page
    public function test_can_load_view_plan_page()
    {
        $plan = Plan::factory()->create();
        Livewire::test(ViewPlan::class, ['record' => $plan->getKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $plan->title,
                'price' => $plan->price,
                'duration' => $plan->duration,
                'resolution' => $plan->resolution,
                'max_devices' => $plan->max_devices,
            ]);
    }

}
