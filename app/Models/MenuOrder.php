<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'menu_order';

    /**
     * Get the menu that owns the MenuOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id', 'menu_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
