<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

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
