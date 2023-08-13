<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    const COLUMN_ARRAY = [
        'name',
        'description',
        'address',
        'user_id',
        'is_online'
    ];

    const VALIDATION_UPDATE_RULES = [
        'is_online' => 'required'
    ];

    const VALIDATION_STORE_RULES = [
        'name' => 'required',
        'address' => 'required',
        'is_online' => 'required'
    ];    

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'user_id',
        'is_online'
    ];

    /**
     * products
     *
     * @return void
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
