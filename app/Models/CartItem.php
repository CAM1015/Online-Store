<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Getter para el ID
    public function getId()
    {
        return $this->id;
    }

    // Getter para el nombre del producto
    public function getName()
    {
        return $this->product->name;
    }

    // Getter para el precio del producto
    public function getPrice()
    {
        return $this->product->price;
    }
}
