<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * These fields can be filled via mass assignment
     * when creating or updating a Category model.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the task(s) associated with the category.
     * 
     * @return BelongsToMany
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_category');
    }
}
