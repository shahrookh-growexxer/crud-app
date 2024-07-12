<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function it_creates_an_item()
    {
        $item = Item::factory()->create([
            'name' => 'Test Name',
            'description' => 'Test Deriptionsc',
            'is_active' => true,
            'file' => 'test.pdf',
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
            'file' => 'test.pdf',
        ]);
    }

    public function it_updates_an_item()
    {
        $item = Item::factory()->create();

        $item->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
            'file' => 'updated.pdf',
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
            'file' => 'updated.pdf',
        ]);
    }

    public function it_toggles_is_active()
    {
        $item = Item::factory()->create(['is_active' => true]);

        $item->is_active = !$item->is_active;
        $item->save();

        $this->assertFalse($item->is_active);
    }
}
