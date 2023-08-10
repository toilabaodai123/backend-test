<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
        'store_id'
    ];

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function getStoreOwnerId(){
        return $this->store->user_id;
    }
}
