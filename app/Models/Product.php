<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'imageUrl',
        'price',
        'isBest',
        'brand_id',
        'category_id'
    ];

    /**
     * Get the user that owns the Role
     *
     * @return BelongsTo
     */
    private function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the Role
     *
     * @return BelongsTo
     */
    private function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
