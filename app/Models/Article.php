<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','reference','prix','categorieID'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class,"categorieID");
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
