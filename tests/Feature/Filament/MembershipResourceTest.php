<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Memberships\Pages\ListMemberships;
use App\Filament\Resources\Memberships\Pages\ViewMembership;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Override;
use Filament\Actions\DeleteBulkAction;
use App\Models\Plan;
use Filament\Actions\DeleteAction;
use Tests\TestCase;
use Filament\Actions\Testing\TestAction;

class MembershipResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_admin()->create());
    }

    // Testing a resource list page
    public function test_can_render_list_membership_page()
    {
        $memberships = Membership::factory(10)->create();
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->assertSuccessful()
            ->assertCanSeeTableRecords($memberships);
    }

    public function test_can_render_all_membership_columns()
    {
        Livewire::test(ListMemberships::class)
            ->assertCanRenderTableColumn('user_id')
            ->assertCanRenderTableColumn('user.name')
            ->assertCanRenderTableColumn('plan.title')
            ->assertCanRenderTableColumn('active')
            ->assertCanRenderTableColumn('start_date')
            ->assertCanRenderTableColumn('end_date')
            ->assertCanRenderTableColumn('created_at')
            ->assertCanRenderTableColumn('updated_at');
    }

    public function test_can_search_membership_by_user_name_and_plan_title()
    {
        $userA = User::factory()->is_member()->create(['name' => 'Budi Santoso']);
        $userB = User::factory()->is_member()->create(['name' => 'Siti Aminah']);

        $planA = Plan::factory()->create(['title' => 'Premium Plan']);
        $planB = Plan::factory()->create(['title' => 'Basic Plan']);

        $membershipA = Membership::factory()->create(['user_id' => $userA->id, 'plan_id' => $planA->id]);
        $membershipB = Membership::factory()->create(['user_id' => $userB->id, 'plan_id' => $planB->id]);

        // 1. Tes pencarian berdasarkan Nama User
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->searchTable('Budi')
            ->assertCanSeeTableRecords([$membershipA])
            ->assertCanNotSeeTableRecords([$membershipB]);

        // 2. Tes pencarian berdasarkan Judul Plan
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->searchTable('Basic')
            ->assertCanSeeTableRecords([$membershipB])
            ->assertCanNotSeeTableRecords([$membershipA]);
    }

    public function test_can_sort_membership_by_all_columns_can_be_sorting()
    {
        $memberships = Membership::factory(10)->create();
        // 1. Test Sort berdasarkan User ID
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->sortTable('user_id')
            ->assertCanSeeTableRecords($memberships->sortBy('user_id')->values(), inOrder: true)
            ->sortTable('user_id', 'desc')
            ->assertCanSeeTableRecords($memberships->sortByDesc('user_id')->values(), inOrder: true);

        // 2. Test Sort berdasarkan Start Date
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->sortTable('start_date')
            ->assertCanSeeTableRecords($memberships->sortBy('start_date')->values(), inOrder: true)
            ->sortTable('start_date', 'desc')
            ->assertCanSeeTableRecords($memberships->sortByDesc('start_date')->values(), inOrder: true);

        // 3. Test Sort berdasarkan End Date
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->sortTable('end_date')
            ->assertCanSeeTableRecords($memberships->sortBy('end_date')->values(), inOrder: true)
            ->sortTable('end_date', 'desc')
            ->assertCanSeeTableRecords($memberships->sortByDesc('end_date')->values(), inOrder: true);

    }

    public function test_can_bulk_delete_action():void
    {
        $memberships = Membership::factory(10)->create();
        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->assertCanSeeTableRecords($memberships)
            ->selectTableRecords($memberships)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertCanNotSeeTableRecords($memberships);
    }

    public function test_can_delete_a_membership() :void
    {
        $membership = Membership::factory()->create();

        Livewire::test(ListMemberships::class)
            ->assertOk()
            ->callTableAction(DeleteAction::class, $membership)
            ->assertNotified();

        $this->assertModelMissing($membership);

    }

    // Testing a resource view page
    public function test_can_load_view_plan_page()
    {
        $membership = Membership::factory()->create();
        Livewire::test(ViewMembership::class, ['record' => $membership->getKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'user.name' => $membership->user->name,
                'plan.title' => $membership->plan->title,
                'active' => $membership->active,
                'start_date' => $membership->start_date,
                'end_date' => $membership->end_date,
                'created_at' => $membership->created_at,
                'updated_at' => $membership->updated_at
            ]);
    }
}
