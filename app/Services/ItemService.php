<?php
namespace App\Services;

use App\Models\Item;

class ItemService
{
    public function create(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }
        return Item::create($data);
    }
}
