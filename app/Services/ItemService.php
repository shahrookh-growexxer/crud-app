<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\File;

class ItemService
{
    public function getAllItems()
    {
        return Item::latest()->paginate(5);
    }

    public function create(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }
        return Item::create($data);
    }

    public function updateItem(Item $item, array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        } else {
            $data['is_active'] = 1;
        }

        if (isset($data['file'])) {
            // Delete the old file if it exists
            if ($item->file) {
                File::delete($item->file);
            }

            // Store the new file
            $extension = pathinfo($item->file, PATHINFO_EXTENSION);
            $imageName = time().'.'.$extension;
            $data['file']->move(public_path('/files'), $imageName);
            $data['file'] = 'files/'. $imageName;
        }

        // Update the item with new data
        $item->update($data);
    }

    public function deleteItem($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return $item;
    }
}
