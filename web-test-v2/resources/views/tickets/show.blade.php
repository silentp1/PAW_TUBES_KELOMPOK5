@extends('layouts.app')

@section('title', 'E-Ticket')

@section('content')
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            #ticket-container,
            #ticket-container * {
                visibility: visible;
            }

            #ticket-container {
                position: relative;
                left: auto;
                top: auto;
                transform: none;
                width: 100%;
                max-width: 600px;
                margin: 10mm auto;
                box-shadow: none !important;
                border: 2px solid #000;
                page-break-inside: avoid;
                overflow: hidden;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    <div id="ticket-container"
        style="max-width: 450px; margin: 2vh auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">

        @if($booking->status == 'paid')
            <div style="background: var(--primary); padding: 15px; text-align: center; color: white;">
                <h2 style="font-size: 1.2rem; color: white; margin-bottom: 2px;">Your E-Ticket</h2>
                <p style="opacity: 0.9; font-size: 0.8rem; margin: 0;">Show this at the entrance</p>
            </div>

            <div style="padding: 20px; text-align: center;">

                <img src="{{ $booking->movie->poster_url }}"
                    style="width: 100px; border-radius: 6px; margin-bottom: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.2);">

                <h3 style="font-size: 1.2rem; margin-bottom: 5px; margin-top: 5px;">{{ $booking->movie->title }}</h3>

                <div style="margin-bottom: 10px; font-size: 1.1rem; font-weight: bold; color: var(--primary);">
                    STUDIO {{ ($booking->movie_id % 5) + 1 }}
                </div>

                <div style="display: flex; justify-content: center; gap: 20px; margin: 10px 0; color: var(--text-muted);">
                    <div>
                        <small style="font-size: 0.8rem;">DATE</small><br>
                        <strong style="color: var(--text-main); font-size: 1rem;">{{ $booking->booking_date }}</strong>
                    </div>
                    <div>
                        <small style="font-size: 0.8rem;">TIME</small><br>
                        <strong style="color: var(--text-main); font-size: 1rem;">{{ $booking->booking_time }}</strong>
                    </div>
                </div>

                <div style="margin: 10px 0; padding: 10px; background: var(--bg-secondary); border-radius: 6px;">
                    <small style="font-size: 0.8rem;">SEATS</small><br>
                    <strong
                        style="font-size: 1.1rem; color: var(--text-main);">{{ implode(', ', json_decode($booking->seats)) }}</strong>
                </div>

                <div style="margin: 15px 0;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $booking->transaction_code }}"
                        style="width: 100px; opacity: 0.8;">
                    <p
                        style="margin-top: 5px; font-family: monospace; letter-spacing: 1px; font-weight: bold; color: var(--text-dark); font-size: 0.9rem;">
                        {{ $booking->transaction_code }}
                    </p>
                </div>

                <div class="no-print" style="display:flex; gap:10px; justify-content:center;">
                    <a href="{{ url('/') }}"
                        style="display: inline-block; padding: 10px 20px; border: 1px solid var(--border); border-radius: 50px; color: var(--text-muted); font-weight: 500; font-size: 0.9rem;">
                        Back to Home
                    </a>
                    <button onclick="window.print()"
                        style="padding: 10px 20px; background: var(--primary); color: white; border: none; border-radius: 50px; font-weight: 500; cursor: pointer; font-size: 0.9rem;">
                        Print Ticket
                    </button>
                </div>

            </div>
        @else
            <div style="padding: 50px; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 20px;">⏳</div>
                <h2 style="color: var(--text-main); margin-bottom: 15px;">Waiting for Approval</h2>
                <p style="color: var(--text-muted); margin-bottom: 30px; line-height: 1.6;">
                    Your payment of <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong> is being
                    verified by admin.<br>
                    Please check your <strong>History</strong> page periodically.
                </p>
                <div
                    style="background: #fffaf0; padding: 15px; border-radius: 8px; display: inline-block; margin-bottom: 30px;">
                    <small style="color: #c05621; font-weight: bold;">Transaction Code:</small><br>
                    <strong
                        style="font-family: monospace; font-size: 1.2rem; color: #742a0c;">{{ $booking->transaction_code }}</strong>
                </div>
                <div>
                    <a href="{{ route('history.index') }}"
                        style="padding: 12px 30px; background: var(--primary); color: white; text-decoration: none; border-radius: 50px; font-weight: 500;">
                        Go to History
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection