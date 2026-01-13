<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\DB;

class AddItemsController extends Controller
{
    // Show Add Item Page
    public function index()
    {
        return Inertia::render('Items/Add/Index');
        // Folder: resources/js/Pages/Items/Add/Index.vue
    }

    // Get all items (id, name, unit, quantity)
    public function get()
    {
        $items = Item::select('id', 'name', 'unit', 'quantity')->get();
        return response()->json($items);
    }

     // Save multiple quantities
    public function updateMultipleQuantities(Request $request)
    {
        $updates = $request->input('updates', []);

        if (empty($updates)) {
            return response()->json(['message' => 'No updates provided'], 400);
        }

        DB::transaction(function () use ($updates) {
            foreach ($updates as $update) {
                $item = Item::find($update['id']);
                if ($item) {
                    // Update main quantity
                    $item->quantity += $update['addQuantity'];
                    $item->save();

                    // Log transaction
                    ItemTransaction::create([
                        'item_id' => $item->id,
                        'type' => 'add',
                        'quantity' => $update['addQuantity'],
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Quantities updated successfully']);
    }
}
