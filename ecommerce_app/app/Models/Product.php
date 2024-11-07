<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'sku','stock_alert_threshold','stock_status', 'images','is_on_sale', 'discount_percentage','discount_start_date', 'discount_end_date'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function latestVariant()
    {
        return $this->variants()->latest()->first(); 
    }
}
