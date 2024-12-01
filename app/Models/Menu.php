<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable=[
        "name","description"
    ];
    public function categories()
    {
    return $this->hasMany(Category::class ,"menuID");
    }
}
