<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'website_id',
        'category_id',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
        'is_featured',
        'status',
        'video',
        'featured_image',
        'is_breaking',
        'language_id',
        'theme_id',

    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured'  =>  'boolean',
        'is_breaking'  =>  'boolean',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}