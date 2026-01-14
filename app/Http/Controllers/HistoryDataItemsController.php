<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemTransaction;
use Illuminate\Http\Request;

class HistoryDataItemsController extends Controller
{
    // Show the item page
    public function index(Request $request)
    {
        $itemId = $request->query('item_id');
        $item = Item::findOrFail($itemId);

        return inertia('Items/History/Data', [
            'item' => $item
        ]);
    }

    // Fetch transactions for history table
    public function fetch(Request $request)
    {
        $itemId = $request->query('item_id');
        $item = Item::findOrFail($itemId);

        $query = ItemTransaction::where('item_id', $item->id)->orderBy('created_at', 'desc');

        // Filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->boolean('last_7_days')) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        $transactions = $query->paginate(10)->withQueryString();

        // Running balance
        $balance = 0;
        $history = collect($transactions->items())
            ->reverse()
            ->map(function ($tx) use (&$balance) {
                $balance += $tx->type === 'add' ? $tx->quantity : -$tx->quantity;

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
                'links' => $transactions->links()->elements,
            ],
        ]);
    }
}
