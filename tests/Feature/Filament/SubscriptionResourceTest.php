<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Subscriptions\Pages\ListSubscriptions;
use App\Filament\Resources\Subscriptions\Pages\ViewSubscription;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Override;
use Filament\Actions\DeleteBulkAction;
use App\Models\Plan;
use Filament\Actions\DeleteAction;
use Tests\TestCase;
use Filament\Actions\Testing\TestAction;

class SubscriptionResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_admin()->create());
    }

    // Testing a resource list page
    public function test_can_render_list_subscription_page()
    {
        $subscriptions = Subscription::factory(10)->create();
        Livewire::test(ListSubscriptions::class)
            ->assertOk()
            ->assertSuccessful()
            ->assertCanSeeTableRecords($subscriptions);
    }

    public function test_can_render_all_subscription_columns()
    {
        Livewire::test(ListSubscriptions::class)
            ->assertCanRenderTableColumn('user_id')
            ->assertCanRenderTableColumn('user.name')
            ->assertCanRenderTableColumn('plan.title')
            ->assertCanRenderTableColumn('active')
            ->assertCanRenderTableColumn('start_date')
            ->assertCanRenderTableColumn('end_date')
            ->assertCanRenderTableColumn('created_at')
            ->assertCanRenderTableColumn('updated_at');
    }

    public function test_can_search_subscription_by_user_name_and_plan_title()
    {
        $userA = User::factory()->is_member()->create(['name' => 'Budi Santoso']);
        $userB = User::factory()->is_member()->create(['name' => 'Siti Aminah']);

        $planA = Plan::factory()->create(['title' => 'Premium Plan']);
        $planB = Plan::factory()->create(['title' => 'Basic Plan']);

        $subscriptionA = Subscription::factory()->create(['user_id' => $userA->id, 'plan_id' => $planA->id]);
        $subscriptionB = Subscription::factory()->create(['user_id' => $userB->id, 'plan_id' => $planB->id]);

        // 1. Tes pencarian berdasarkan Nama User
        Livewire::test(ListSubscriptions::class)
            ->assertOk()
            ->searchTable('Budi')
            ->assertCanSeeTableRecords([$subscriptionA])
            ->assertCanNotSeeTableRecords([$subscriptionB]);

        // 2. Tes pencarian berdasarkan Judul Plan
        Livewire::test(ListSubscriptions::class)
            ->assertOk()
            ->searchTable('Basic')
            ->assertCanSeeTableRecords([$subscriptionB])
            ->assertCanNotSeeTableRecords([$subscriptionA]);
    }

    // public function test_can_sort_subscription_by_all_columns_can_be_sorting()
    // {
    //     $subscriptions = Subscription::factory(10)->create();

    //     // 2. Test Sort berdasarkan Start Date
    //     Livewire::test(ListSubscriptions::class)
    //         ->assertOk()
    //         ->sortTable('start_date')
    //         ->assertCanSeeTableRecords($subscriptions->sortBy('start_date')->values(), inOrder: true)
    //         ->sortTable('start_date', 'desc')
    //         ->assertCanSeeTableRecords($subscriptions->sortByDesc('start_date')->values(), inOrder: true);

    //     // 3. Test Sort berdasarkan End Date
    //     Livewire::test(ListSubscriptions::class)
    //         ->assertOk()
    //         ->sortTable('end_date')
    //         ->assertCanSeeTableRecords($subscriptions->sortBy('end_date')->values(), inOrder: true)
    //         ->sortTable('end_date', 'desc')
    //         ->assertCanSeeTableRecords($subscriptions->sortByDesc('end_date')->values(), inOrder: true);

    // }

    public function test_can_bulk_delete_action():void
    {
        $subscriptions = Subscription::factory(10)->create();
        Livewire::test(ListSubscriptions::class)
            ->assertOk()
            ->assertCanSeeTableRecords($subscriptions)
            ->selectTableRecords($subscriptions)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertCanNotSeeTableRecords($subscriptions);
    }

    public function test_can_delete_a_subscription() :void
    {
        $subscriptions = Subscription::factory()->create();

        Livewire::test(ListSubscriptions::class)
            ->assertOk()
            ->callTableAction(DeleteAction::class, $subscriptions)
            ->assertNotified();

        $this->assertModelMissing($subscriptions);

    }

    public function test_can_load_view_subscription_page()
    {
        $subscription= Subscription::factory()->create();
        Livewire::test(ViewSubscription::class, ['record' => $subscription->getKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'user.name' => $subscription->user->name,
                'plan.title' => $subscription->plan->title,
                'active' => $subscription->active,
                'start_date' => $subscription->start_date,
                'end_date' => $subscription->end_date,
                'created_at' => $subscription->created_at,
                'updated_at' => $subscription->updated_at
            ]);
    }
}
