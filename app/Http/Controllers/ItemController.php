<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        $items = $this->itemService->getAllItems();
        return view('items.index', compact('items'));
    }

    public function toggleActive(Request $request, Item $item)
    {
        $item->is_active = !$item->is_active;
        $item->save();

        return response()->json(['status' => 'success', 'is_active' => $item->is_active]);
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(ItemRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $imageName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('/files'), $imageName);
            $data['file'] = 'files/'. $imageName;
        }
        
        $this->itemService->create($data);

        return redirect()->route('items.index');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $this->itemService->updateItem($item, $request->all());

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $this->itemService->deleteItem($id);
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
