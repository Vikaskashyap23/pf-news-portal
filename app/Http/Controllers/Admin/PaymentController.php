<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeOrder;

class PaymentController extends Controller
{
    /**
     * Display all theme payments.
     */
    public function index()
    {
        // Only Super Admin can view payments
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only Super Admin can view payments.');
        }

        $payments = ThemeOrder::with([
            'user',
            'website',
            'theme',
        ])
        ->latest()
        ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }
}