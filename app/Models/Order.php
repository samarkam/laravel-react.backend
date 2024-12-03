<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'order_date', // Assuming you're adding order_date as well
    ];

    // Relationship with OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    // Relationship with User (assuming a user is associated with the order)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

