<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DeductItemsController extends Controller
{
      // Show Deduct Item Page
    public function index()
    {
        return Inertia::render('Items/Deduct/Index');
        // Folder: resources/js/Pages/Items/Deduct/Index.vue
    }

}
