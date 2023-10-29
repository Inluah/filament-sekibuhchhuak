<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // public function items()
    // {
    //     return $this->belongsToMany(Menu::class);
    // }

    public function order_items()
    {
        return $this->hasMany(MenuOrder::class);
    }

    public function starters()
    {
        return $this->order_items()->where('order_section', 'like', 'starter');
    }

    public function main_course()
    {
        return $this->order_items()->where('order_section', 'like', 'main_course');
    }

    public function dissert()
    {
        return $this->order_items()->where('order_section', 'like', 'dissert');
    }

    public function package()
    {
        return $this->order_items()->where('order_section', 'like', 'package');
    }
}
