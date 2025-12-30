@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
    <div class="payment-container" style="max-width: 600px; margin: 50px auto; text-align: center;">
        <h2 style="margin-bottom: 20px;">Complete Your Payment</h2>

        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <p style="color: var(--text-muted); margin-bottom: 20px;">Order ID: {{ $booking->transaction_code }}</p>
            <h1 style="color: var(--primary); margin-bottom: 30px;">Rp
                {{ number_format($booking->total_price, 0, ',', '.') }}
            </h1>

            <div class="actions-container" style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                @if(isset($response->actions))
                    @foreach($response->actions as $action)
                        @if($action->name == 'generate-qr-code')
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 10px; font-weight: 600;">Scan QR Code (GoPay)</p>
                                <img src="{{ $action->url }}" alt="QR Code"
                                    style="width: 200px; height: 200px; border: 1px solid #ddd;">
                            </div>
                        @elseif($action->name == 'deeplink-redirect')
                            <div style="text-align: center;">
                                <p style="margin-bottom: 10px; color: #666; font-size: 0.9rem;">Click to Simulate Payment (Sandbox Only)
                                </p>
                                <a href="{{ $action->url }}" target="_blank"
                                    style="background: #008100; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">
                                    Pay with GoPay App
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endif

                <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; width: 100%;">
                    <p style="font-size: 0.9rem; color: #888; margin-bottom: 15px;">After paying via the link above, click
                        below:</p>
                    <a href="{{ route('payment.complete', $booking->id) }}"
                        style="color: var(--primary); text-decoration: none; font-weight: 600; border: 1px solid var(--primary); padding: 10px 20px; border-radius: 6px;">
                        I Have Completed Payment
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection