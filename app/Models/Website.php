<?php

namespace App\Models;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'favicon',
        'language',
        'theme_id',
        'domain',
        'status',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function users(): HasMany
{
    return $this->hasMany(User::class);
}

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function selectedTheme()
    {
        return $this->belongsTo(\App\Models\Theme::class, 'theme_id');
    }

    public function themeOrders()
{
    return $this->hasMany(ThemeOrder::class);
}

public function domains(): HasMany

{
    return $this->hasMany(Domain::class);
}

}