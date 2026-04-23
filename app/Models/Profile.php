<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * These fields can be filled via mass assignment
     * when creating or updating a Profile model.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'bio'
    ];
}
