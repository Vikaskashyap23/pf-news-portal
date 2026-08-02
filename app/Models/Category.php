<?php

namespace App\Models;
use App\Models\Website;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [

        'website_id',
        'parent_id',
        'name',
        'slug',
        'status',
    ];


    public function website()

    {
     


    return $this->belongsTo(Website::class);
        

    } 

    }



    