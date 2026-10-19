<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()->with(['user', 'subscription.plan'])->latest('payment_date')->get();
        $paid = (float) $payments->where('payment_status', 'paid')->sum('amount');
        $pending = (float) $payments->where('payment_status', 'pending')->sum('amount');

        return view('admin.payments', compact('payments', 'paid', 'pending'));
    }
}
