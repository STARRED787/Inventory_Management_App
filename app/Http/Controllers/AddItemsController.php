<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;

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
}
