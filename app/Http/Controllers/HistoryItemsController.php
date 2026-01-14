<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryItemsController extends Controller
{
        // Show History Item Page
    public function index()
    {
        return Inertia::render('Items/History/Index');
        // Folder: resources/js/Pages/Items/History/Index.vue
    }
}
