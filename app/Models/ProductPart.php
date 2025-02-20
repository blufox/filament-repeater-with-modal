<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPart extends Model
{
    protected $fillable = ['name', 'code', 'description', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
