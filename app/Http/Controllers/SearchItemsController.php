<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchItemsController extends Controller
{
    // Page
    public function index()
    {
        return Inertia::render('Items/Search/Index');
    }

    // Fetch search results (AJAX)
    public function fetch(Request $request)
    {
        $query = Item::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json([
            'data' => $query->limit(20)->get(),
        ]);
    }
}
