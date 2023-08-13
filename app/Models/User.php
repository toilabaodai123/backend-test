<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_EMAIL = 'email';
    const COLUMN_PASSWORD = 'password';
    const COLUMN_REMEBER_TOKEN = 'remember_token';
    const COLUMN_EMAIL_VERIFIED_AT = 'email_verified_at';

    const VALIDATION_STORE_RULES = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
    ];     
    
    const VALIDATION_LOGIN_RULES = [
        'email' => 'required|email',
        'password' => 'required',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_EMAIL,
        self::COLUMN_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::COLUMN_PASSWORD,
        self::COLUMN_REMEBER_TOKEN
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::COLUMN_EMAIL_VERIFIED_AT => 'datetime',
        self::COLUMN_PASSWORD => 'hashed',
    ];
}
