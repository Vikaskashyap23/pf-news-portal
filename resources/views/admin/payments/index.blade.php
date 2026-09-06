@extends('adminlte::page')

@section('title', 'Payments')

@section('content_header')
    <h1>Payments</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Theme Payments</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Website</th>
                        <th>Theme</th>
                        <th>Amount</th>
                        <th>Gateway</th>
                        <th>Payment ID</th>
                        <th>Status</th>
                        <th>Paid At</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($payments as $payment)

                    <tr>

                        <td>
                            {{ $payment->id }}
                        </td>

                        <td>
                            @if($payment->user)
                                {{ $payment->user->name }}
                            @else
                                <span class="text-muted">
                                    User Deleted
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($payment->website)
                                {{ $payment->website->name }}
                            @else
                                <span class="text-muted">
                                    Website Deleted
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($payment->theme)
                                {{ $payment->theme->name }}
                            @else
                                <span class="text-muted">
                                    Theme Deleted
                                </span>
                            @endif
                        </td>

                        <td>
                            ₹{{ number_format((float) $payment->amount, 2) }}
                        </td>

                        <td>
                            {{ ucfirst($payment->gateway) }}
                        </td>

                        <td>
                            @if($payment->razorpay_payment_id)
                                <small>
                                    {{ $payment->razorpay_payment_id }}
                                </small>
                            @else
                                -
                            @endif
                        </td>

                        <td>

                            @if($payment->status === 'paid')

                                <span class="badge bg-success">
                                    Paid
                                </span>

                            @elseif($payment->status === 'failed')

                                <span class="badge bg-danger">
                                    Failed
                                </span>

                            @else

                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($payment->status) }}
                                </span>

                            @endif

                        </td>

                        <td>
                            @if($payment->paid_at)
                                {{ $payment->paid_at->format('d M Y, h:i A') }}
                            @else
                                -
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            No payments found.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $payments->links() }}
        </div>

    </div>

</div>

@stop