<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = ['name', 'photo', 'price', 'category_id', 'quantity'];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = ['unformatted_price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product')->withPivot('quantity', 'price');
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getUnformattedPriceAttribute()
    {
        return $this->attributes['price'];
    }

    public function getPhotoAttribute($value)
    {
        //Cria uma imagem padrão com via placeholder.com caso não tenha foto
        if(empty($value)){
            $color = dechex(rand(0x000000, 0xFFFFFF));
            return 'https://via.placeholder.com/150/' . $color . '/FFFFFF?text=Produto';
        } 
        elseif( filter_var($value, FILTER_VALIDATE_URL) ){  //Verifica se a imagem armazenada é uma URL
            return $value;
        }
        else{
            return asset('storage/' . $value); //Caso não seja uma URL, retorna a imagem armazenada
        }
    }

    public function setPhotoAttribute($value)
    {   
        if( filter_var($value, FILTER_VALIDATE_URL) ){  //Verifica se a imagem armazenada é uma URL
            $this->attributes['photo'] = $value;
        }
        else{
            $this->attributes['photo'] = $value->store('products', 'public');
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($query) use ($search) {
                      $query->where('name', 'like', '%' . $search . '%');
                  });
        });
    }

    public function getSalesReport()
{
    return $this->sales()
        ->select('sales.id', 'sales.created_at', \DB::raw('SUM(sale_product.quantity) as total_quantity'), \DB::raw('SUM(sale_product.price * sale_product.quantity) as total_revenue'))
        ->groupBy('sales.id', 'sales.created_at')
        ->get();
}
}
