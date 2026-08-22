<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'favicon',
        'language',
        'theme',
        'domain',
        'status',
    ];

    public function categories()

    {
        return $this->hasMany(Category::class);
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
