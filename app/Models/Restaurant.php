<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'year_founded', 'tax_rate', 'phone', 'email', 'address1', 'address2', 'city', 'state', 'zip'];
}
