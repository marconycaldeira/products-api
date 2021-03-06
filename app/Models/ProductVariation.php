<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use SoftDeletes;

    protected $table = 'products_variations';
    protected $fillable = ['name', 'type', 'initial_inventary', 'actual_inventary', 'price', 'created_by', 'product_id'];
    protected $dates = ['deleted_at'];
    protected $with = ['createdBy'];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
