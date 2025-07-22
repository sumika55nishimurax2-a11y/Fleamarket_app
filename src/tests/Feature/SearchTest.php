<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_shows_matching_items_in_recommend_tab()
    {
        $item1 = Item::factory()->create(['name' => 'ニンテンドースイッチ']);
        $item2 = Item::factory()->create(['name' => '洗濯機']);

        $response = $this->get('/?keyword=スイッチ');

        $response->assertStatus(200);
        $response->assertSee('ニンテンドースイッチ');
        $response->assertDontSee('洗濯機');
    }

    public function test_search_keyword_is_retained_in_form_input()
    {
        $response = $this->get('/?keyword=イヤホン');

        $response->assertStatus(200);
        $response->assertSee('value="イヤホン"', false); // inputタグのvalue確認
    }

    public function test_search_keyword_is_applied_to_mylist_tab()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => 'ノートパソコン']);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist&keyword=ノート');

        $response->assertStatus(200);
        $response->assertSee('ノートパソコン');
        $response->assertSee('value="ノート"', false); // フォームにキーワード保持
    }
}
