<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['order_id', 'customer_name', 'address', 'method', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}