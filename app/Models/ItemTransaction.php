<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class ItemTransaction extends Model
{
    protected $table = 'items_transactions';

    protected $fillable = [
        'item_id',
        'type',
        'quantity',
        'created_at',
    ];

    // In ItemTransaction model
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
