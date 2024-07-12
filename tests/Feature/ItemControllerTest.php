<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function it_displays_the_items_index()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertSee($item->name);
    }

    public function it_displays_the_edit_form()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('items.edit', $item->id));

        $response->assertStatus(200);
        $response->assertSee($item->name);
    }

    public function it_updates_an_item()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('items.update', $item->id), [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
            'file' => null,
        ]);

        $response->assertRedirect(route('items.index'));
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ]);
    }

    public function it_toggles_the_is_active_status()
    {
        $item = Item::factory()->create(['is_active' => true]);

        $response = $this->post(route('items.toggle-active', $item->id));

        $response->assertStatus(200);
        $item->refresh();

        $this->assertFalse($item->is_active);
    }
}
