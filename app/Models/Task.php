<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * These fields can be filled via mass assignment
     * when creating or updating a Task model.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'priority'
    ];
}
