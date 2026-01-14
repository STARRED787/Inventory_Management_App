<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryDataItemsController extends Controller
{
    public function index(Item $item)
    {
        return Inertia::render('Items/History/Data', [
            'item' => $item
        ]);
        // resources/js/Pages/Items/History/Index.vue
    }

    public function fetch(Request $request, Item $item)
    {
        $query = $item->transactions()->orderBy('created_at', 'desc');

        // Filter: add / deduct
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter: date range
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from,
                $request->to
            ]);
        }

        // Filter: last 7 days
        if ($request->boolean('last_7_days')) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        $transactions = $query->paginate(10)->withQueryString();

        // Running balance
        $balance = 0;
        $history = collect($transactions->items())
            ->reverse()
            ->map(function ($tx) use (&$balance) {
                $balance += $tx->type === 'add'
                    ? $tx->quantity
                    : -$tx->quantity;

                return [
                    'id' => $tx->id,
                    'type' => $tx->type,
                    'quantity' => $tx->quantity,
                    'created_at' => $tx->created_at->toDateTimeString(),
                    'balance' => $balance,
                ];
            })
            ->reverse()
            ->values();

        return response()->json([
            'data' => $history,
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'links' => $transactions->links()->toHtml(),
            ]
        ]);
    }
}
