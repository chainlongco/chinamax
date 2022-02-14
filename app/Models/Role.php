<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role_User;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /*public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
        //return $this->belongsToMany(User::class)->using(Role_User::class);
    }*/
}
