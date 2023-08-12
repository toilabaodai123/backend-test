<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_DESCRIPTION = 'description';
    const COLUMN_ADDRESS = 'address';
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_IS_ONLINE = 'is_online';

    const COLUMN_ARRAY = [
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_ADDRESS,
        self::COLUMN_USER_ID,
        self::COLUMN_IS_ONLINE
    ];

    const VALIDATION_UPDATE_RULES = [
        self::COLUMN_IS_ONLINE => 'required'
    ];

    const VALIDATION_STORE_RULES = [
        self::COLUMN_NAME => 'required',
        self::COLUMN_ADDRESS => 'required',
        self::COLUMN_IS_ONLINE => 'required'
    ];    

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_ADDRESS,
        self::COLUMN_USER_ID,
        self::COLUMN_IS_ONLINE
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
