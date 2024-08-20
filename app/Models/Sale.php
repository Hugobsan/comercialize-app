<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = ['seller_id', 'customer_id', 'total_amount', 'total_quantity'];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['unformatted_total_amount'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')->withPivot('quantity', 'price');
    }

    public function getTotalAmountAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getUnformattedTotalAmountAttribute()
    {
        return $this->attributes['total_amount'];
    }
}
