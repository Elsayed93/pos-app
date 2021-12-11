<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['name', 'description'];

    protected $guarded = [];
    protected $appends = ['profit_percentage'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getProfitPercentageAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percentage = ($profit / $this->purchase_price) * 100;

        return round($profit_percentage, 3);
        // return $profit_percentage;
    }
}
