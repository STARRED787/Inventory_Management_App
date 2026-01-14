<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ItemTransaction;

class Item extends Model
{
    protected $fillable = ['name', 'unit', 'quantity'];

    /**
     * Transactions related to this item
     */
    public function transactions()
    {
        return $this->hasMany(ItemTransaction::class);
    }
}
