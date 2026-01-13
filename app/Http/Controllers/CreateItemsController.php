<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item; // Make sure you have this model

class CreateItemsController extends Controller
{
    // Show create item Page
    public function index()
    {
        return Inertia::render('Items/Create/Index'); 
        // Folder: resources/js/Pages/Items/Create/Index.vue
    }

    // Store item data
     public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'unit'     => 'required|in:kg,m,cm,pcs',
            'quantity' => 'required|numeric|min:0',
        ]);

        Item::create($validated);

        return redirect()->route('items.create');
    }
}
