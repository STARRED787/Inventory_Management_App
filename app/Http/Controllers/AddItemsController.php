<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AddItemsController extends Controller
{
   // Show Add item Page
    public function index()
    {
        return Inertia::render('Items/Add/Index');
        // Folder: resources/js/Pages/Items/Add/Index.vue
    }

}
