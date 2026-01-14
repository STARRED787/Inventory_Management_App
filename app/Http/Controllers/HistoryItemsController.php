<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryItemsController extends Controller
{

    // Show History Item Page (UI only)

    public function index(Item $item)
    {
        return Inertia::render('Items/History/Index', [
            'item' => $item
        ]);
        // resources/js/Pages/Items/History/Index.vue
    }

    // Show History Item Page to item table data
    public function get(Request $request)
    {
        $query = Item::query();

        // Optional: add pagination
        $items = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'data' => $items->items(),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'total' => $items->total(),
            ]
        ]);
    }
}
