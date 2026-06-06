<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'user_id',
        'title',
        'description',
        'priority',
    ];

    /**
     * Get the user associated with the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category(s) associated with the task.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'task_category');
    }

    /**
     * Get the users who favored the task.
     */
    public function favoriteByUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
