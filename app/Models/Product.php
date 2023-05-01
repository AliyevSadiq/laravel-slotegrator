<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends=[
        'is_favorite'
    ];

    protected $casts=[
      'is_favorite'=>'bool'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeFilterBy($query, $filters)
    {
        $namespace = 'App\Utils\Filters\ProductFilter';
        $filter = new FilterBuilder($query, $filters, $namespace);
        return $filter->apply();
    }

    protected function isFavorite(): Attribute
    {
        return new Attribute(
            get: fn($value) => auth()->check() && in_array(auth()->id(), $this->favorites->pluck('user_id')->toArray())
        );
    }
}
