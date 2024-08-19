<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['name', 'code', 'icon', 'color', 'description'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function setCodeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['code'] = $this->generateCategoryCode();
        } else {
            $this->attributes['code'] = $value;
        }
    }

    /**
     * Generate category code
     *
     * @return string
     */
    protected function generateCategoryCode()
    {
        $latestCategory = self::latest('created_at')->first();
        $latestCode = $latestCategory ? $latestCategory->code : 'CAT-0000';
        $nextNumber = intval(substr($latestCode, -4)) + 1;
        return 'CAT-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
