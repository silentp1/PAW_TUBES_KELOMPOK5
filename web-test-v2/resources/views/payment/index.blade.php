@extends('layouts.app')

@section('title', 'Payment')

@section('content')
    <div class="payment-container" style="max-width: 800px; margin: 0 auto;">
        <h2 style="margin-bottom: 30px;">Payment Confirmation</h2>

        <div style="display: flex; gap: 40px;">

            <!-- Order Summary -->
            <div
                style="flex: 1; background: white; padding: 30px; border-radius: 12px; height: fit-content; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom: 20px; font-size: 1.2rem;">Order Summary</h3>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <img src="{{ $movie->poster_url }}" style="width: 80px; border-radius: 8px;">
                    <div>
                        <h4 style="margin: 0; font-size: 1.1rem;">{{ $movie->title }}</h4>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $data['date'] }} • {{ $data['time'] }}
                        </p>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0;">

                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: var(--text-muted);">Seats</span>
                    <strong>{{ implode(', ', json_decode($data['seats'])) }}</strong>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 20px; font-size: 1.2rem;">
                    <span>Total Amount</span>
                    <strong style="color: var(--primary);">Rp
                        {{ number_format($data['total_price'], 0, ',', '.') }}</strong>
                </div>
            </div>

            <!-- Payment Method -->
            <div
                style="flex: 1.5; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom: 20px; font-size: 1.2rem;">Select Payment Method</h3>

                <div class="methods" style="display: flex; gap: 15px; margin-bottom: 30px;">
                    <div class="method-card" onclick="selectMethod('QRIS')"
                        style="flex: 1; border: 2px solid var(--border); border-radius: 8px; padding: 15px; text-align: center; cursor: pointer;">
                        <strong>QRIS</strong>
                    </div>
                    <div class="method-card" onclick="selectMethod('GoPay')"
                        style="flex: 1; border: 2px solid var(--border); border-radius: 8px; padding: 15px; text-align: center; cursor: pointer;">
                        <strong>GoPay</strong>
                    </div>
                    <div class="method-card" onclick="selectMethod('ShopeePay')"
                        style="flex: 1; border: 2px solid var(--border); border-radius: 8px; padding: 15px; text-align: center; cursor: pointer;">
                        <strong>ShopeePay</strong>
                    </div>
                </div>

                <!-- QR Code Area (Hidden initially) -->
                <div id="qr-area" style="display: none; text-align: center; margin-bottom: 30px;">
                    <p style="margin-bottom: 15px;">Scan this QR to Pay</p>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=CineSpotPayment"
                        style="width: 200px; height: 200px; border-radius: 10px; border: 1px solid var(--border); padding: 10px;">
                </div>

                <!-- VA Display Area (Hidden initially) -->
                <div id="va-area" style="display: none; text-align: center; margin-bottom: 30px;">
                    <p style="margin-bottom: 15px;">Please transfer to this Virtual Account:</p>
                    <h2 id="va-number"
                        style="font-family: monospace; font-size: 2rem; color: var(--primary); letter-spacing: 2px;"></h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">(Copied to clipboard)</p>
                </div>

                <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                    <input type="hidden" name="date" value="{{ $data['date'] }}">
                    <input type="hidden" name="time" value="{{ $data['time'] }}">
                    <input type="hidden" name="seats" value="{{ $data['seats'] }}">
                    <input type="hidden" name="total_price" value="{{ $data['total_price'] }}">
                    <input type="hidden" name="payment_method" id="selected-method">

                    <button type="button" id="btn-confirm" onclick="submitPayment()" disabled
                        style="width: 100%; padding: 15px; background: var(--border); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: not-allowed; transition: 0.2s;">
                        Confirm Payment
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function selectMethod(method) {
            // Highlight selection
            document.querySelectorAll('.method-card').forEach(el => el.style.borderColor = 'var(--border)');
            event.currentTarget.style.borderColor = 'var(--primary)';

            // Set input value
            document.getElementById('selected-method').value = method;

            // Logic Display
            const qrArea = document.getElementById('qr-area');
            const vaArea = document.getElementById('va-area');
            const vaNumber = document.getElementById('va-number');

            qrArea.style.display = 'none';
            vaArea.style.display = 'none';

            if (method === 'QRIS') {
                qrArea.style.display = 'block';
            }
            else {
                // Generate Fake VA
                const randomVA = '88' + Math.floor(1000000000 + Math.random() * 9000000000); // 88 + 10 digits
                vaNumber.innerText = randomVA;
                vaArea.style.display = 'block';
            }

            // Enable Button
            const btn = document.getElementById('btn-confirm');
            btn.disabled = false;
            btn.style.background = 'var(--primary)';
            btn.style.cursor = 'pointer';
            btn.innerHTML = 'Confirmed Payment with ' + method;
        }

        function submitPayment() {
            document.getElementById('payment-form').submit();
        }
    </script>
@endsection