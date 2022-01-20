<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'password', 'address1', 'address2', 'city', 'state', 'zip', 'card_number', 'expired', 'cvv', 'updated_at'];

    protected $hidden = ['password'];
}
