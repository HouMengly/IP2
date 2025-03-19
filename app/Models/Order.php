<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'orders';

    protected $fillable = ['order_date', 'total_price', 'customer_id'];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function orderProducts() {
        return $this->hasMany(OrderProduct::class);
    }
}
