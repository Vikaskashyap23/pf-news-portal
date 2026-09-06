<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'price',
        'trial_days',
        'theme_path',
        'preview_image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'trial_days' => 'integer',
        'status' => 'boolean',
    ];

    public function websites()
    {
        return $this->hasMany(Website::class, 'theme_id');
    }

    public function orders()
{
    return $this->hasMany(ThemeOrder::class);
}

}