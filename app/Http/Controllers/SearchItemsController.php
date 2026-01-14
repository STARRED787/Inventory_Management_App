<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchItemsController extends Controller
{
    // Show Search item Page
    public function index()
    {
        return Inertia::render('Items/Search/Index');
        // Folder: resources/js/Pages/Items/Search/Index.vue
    }
}
