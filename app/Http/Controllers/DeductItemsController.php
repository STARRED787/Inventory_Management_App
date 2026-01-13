<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\DB;

class DeductItemsController extends Controller
{
    // Show Deduct Item Page
    public function index()
    {
        return Inertia::render('Items/Deduct/Index');
        // Folder: resources/js/Pages/Items/Deduct/Index.vue
    }

    // Get all items (id, name, unit, quantity)
    public function get()
    {
        $items = Item::select('id', 'name', 'unit', 'quantity')->get();
        return response()->json($items);
    }

    // Deduct multiple quantities
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
                    // Ensure quantity doesn't go below zero
                    $deductAmount = min($item->quantity, $update['deductQuantity']);
                    $item->quantity -= $deductAmount;
                    $item->save();

                    // Log transaction
                    ItemTransaction::create([
                        'item_id' => $item->id,
                        'type' => 'deduct',
                        'quantity' => $deductAmount,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Quantities deducted successfully']);
    }
}
