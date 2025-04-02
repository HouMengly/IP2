<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'orders';

    protected $fillable = ['order_date', 'total_amount', 'customer_id'];
    
    protected function orderDate(): Attribute {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        );
    }

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
