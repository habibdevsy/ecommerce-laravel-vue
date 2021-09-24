<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role',
        'user_type',
    ];

    /**
     * Get the user that owns the Role
     *
     * @return BelongsTo
     */
    private function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
