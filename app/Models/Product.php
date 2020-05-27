<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['slug', 'name', 'description', 'created_by'];
    protected $dates = ['deleted_at'];
    protected $with = ['createdBy', 'variations'];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    
    public function variations(){
        return $this->hasMany(ProductVariation::class);
    }
}
