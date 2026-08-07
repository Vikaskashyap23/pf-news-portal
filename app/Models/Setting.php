<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'site_logo',
        'favicon',

        'email',
        'phone',
        'address',

        'facebook',
        'instagram',
        'youtube',
        'twitter',

        'meta_title',
        'meta_description',
    ];
}