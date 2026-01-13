<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;
    protected $table = 'items_transactions';
    protected $fillable = [
        'item_id',
        'type',
        'quantity',
    ];

    // Relation: each transaction belongs to an item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
