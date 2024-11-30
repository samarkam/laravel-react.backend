<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=[
        "label","menuID"
    ];

    public function menu()
    {
    return $this->belongsTo(Menu::class,"menuID");
    }
    public function articles()
    {
    return $this->hasMany(Article::class ,"categorieID");
    }
}
