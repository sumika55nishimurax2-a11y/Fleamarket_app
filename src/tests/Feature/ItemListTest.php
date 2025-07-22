<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_are_displayed()
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(Item::first()->name);
    }

    public function test_sold_items_show_sold_label()
    {
        $item = Item::factory()->create([
            'is_sold' => true,
        ]);

        $response = $this->get('/');

        $response->assertSee('SOLD');
    }

    public function test_user_cannot_see_their_own_items()
    {
        $user = User::factory()->create();
        $myItem = Item::factory()->create(['user_id' => $user->id]);
        $otherItem = Item::factory()->create();

        $this->actingAs($user);
        $response = $this->get('/');

        $response->assertDontSee($myItem->name);
        $response->assertSee($otherItem->name);
    }
}
