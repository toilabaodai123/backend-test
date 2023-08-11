<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory,SoftDeletes;

    const NAME = 'name';
    const DESCRIPTION = 'description';
    const ADDRESS = 'address';
    const USER_ID = 'user_id';
    const IS_ONLINE = 'is_online';

    protected $fillable = [
        self::NAME,
        self::DESCRIPTION,
        self::ADDRESS,
        self::USER_ID,
        self::IS_ONLINE
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
