<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeOrder extends Model
{
    protected $fillable = [
        'user_id',
        'website_id',
        'theme_id',
        'amount',
        'gateway',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'status',
        'paid_at',
        'customer_name',
        'customer_email',
        'customer_mobile',
        'customer_password',
        
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}