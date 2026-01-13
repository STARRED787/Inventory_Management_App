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
}
