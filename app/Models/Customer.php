<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address'];
    public function carts() 
    { 
        return $this->hasMany(Cart::class); 
    }
    public function wishlists() 
    { 
        return $this->hasMany(Wishlist::class); 
    }
    public function orders() 
    { 
        return $this->hasMany(Order::class); 
    }
    public function payments() 
    { 
        return $this->hasMany(Payment::class); 
    }
}
