<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Website;
use App\Models\News;

class Category extends Model
{
    protected $fillable = [
        'website_id',
        'parent_id',
        'name',
        'slug',
        'status',
    ];


    // Website relationship
    public function website()
    {
        return $this->belongsTo(Website::class);
    }


    // Parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    // Child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    // News belonging to this category
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
    