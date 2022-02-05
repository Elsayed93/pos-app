<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'client_id',
    ];

    // order client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


    // order products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }
}
