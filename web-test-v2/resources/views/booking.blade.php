@extends('layouts.app')

@section('title', 'Booking - ' . $movie->title)

@section('content')
    <style>
        body {
            align-items: flex-start !important;
        }

        .content-wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: none !important;
        }

        .booking-container {
            width: 100%;
            padding: 20px 0;
            margin: 0;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            justify-content: center;
        }

        .seat-section {
            flex: 2;
            background: #f8f9fa;
            border-radius: 20px;
            padding: 40px;
            border: 2px solid #e0e0e0;
            position: relative;
        }

        .seat-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 60px;
        }

        .seat-group {
            display: grid;
            gap: 12px;
        }

        /* 4 bangku */
        .group-left,
        .group-right {
            grid-template-columns: repeat(4, 1fr);
        }

        /* 8 bangku */
        .group-center {
            grid-template-columns: repeat(8, 1fr);
        }

        .seat-icon {
            width: 32px;
            height: 32px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            background-color: #333;


            /* Apply the PNG as a mask so we can color it */
            -webkit-mask-image: url('{{ asset("images/seat-icon.png") }}');
            mask-image: url('{{ asset("images/seat-icon.png") }}');
            -webkit-mask-size: contain;
            mask-size: contain;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-position: center;
            mask-position: center;
        }

        .seat-icon:hover {
            transform: scale(1.1);
        }

        .seat-icon.taken {
            background-color: #e0e0e0;
            /* sold */
            cursor: not-allowed;
            pointer-events: none;
        }

        .seat-icon.selected {
            background-color: #F59E0B;
            /* selected */
        }

        .screen-bar {
            width: 80%;
            height: 40px;
            background: #e0e0e0;
            border-radius: 0 0 50px 50px;
            /* Curved screen look */
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
            margin-top: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Right Side: Summary Card */
        .booking-summary-card {
            flex: 1;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 100px;
        }

        .summary-header {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-poster {
            width: 80px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .summary-details h3 {
            margin: 0 0 5px 0;
            font-size: 1.2rem;
            color: #333;
        }

        .summary-info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            color: #666;
            font-size: 0.9rem;
        }

        .seat-list-display {
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            min-height: 24px;
        }

        .price-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .total-chairs {
            color: #666;
            font-size: 0.9rem;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            border-radius: 50px;
            border: 1px solid #333;
            background: white;
            color: #333;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-cancel:hover {
            background: #f5f5f5;
        }

        .btn-payment {
            flex: 1;
            padding: 12px;
            border-radius: 50px;
            border: none;
            background: #111;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-payment:hover {
            background: #333;
            transform: translateY(-2px);
        }
    </style>

    <div class="booking-container">
        <!-- LEFT: Seat Selection -->
        <div class="seat-section">
            <div class="seat-container">
                <!-- Left Section (4 Columns) -->
                <div class="seat-group group-left" id="group-left"></div>

                <!-- Center Section (8 Columns) -->
                <div class="seat-group group-center" id="group-center"></div>

                <!-- Right Section (4 Columns) -->
                <div class="seat-group group-right" id="group-right"></div>
            </div>

            <!-- Seat Legend (Simple Icons) -->
            <div style="display: flex; justify-content: center; gap: 30px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div class="seat-icon"></div>
                    <span>Available</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div class="seat-icon taken"></div>
                    <span>Sold</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div class="seat-icon selected"></div>
                    <span>Selected</span>
                </div>
            </div>

            <div class="screen-bar">Screen Theater</div>
        </div>

        <!-- RIGHT: Summary Card -->
        <div class="booking-summary-card">
            <div class="summary-header">
                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="summary-poster">
                <div class="summary-details">
                    <h3>{{ $movie->title }}</h3>
                    <div class="summary-info-row">
                        <span>📍</span> <span id="theater-name-display">{{ $theater->name }}</span>
                        <!-- Will be filled by JS if needed -->
                    </div>
                    <div class="summary-info-row">
                        <span>📅</span> <span id="date-display">{{ request('date') }}</span>
                    </div>
                    <div class="summary-info-row">
                        <span>⏰</span> <span id="time-display">{{ request('time') }}</span>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #eee; margin: 20px 0;"></div>

            <div style="font-size: 0.9rem; color: #666;">Chair Number</div>
            <div class="seat-list-display" id="seat-numbers">-</div>

            <div class="price-summary">
                <div class="total-chairs" id="chair-count">0 Chair</div>
                <div class="total-price" id="total-price-display">Rp0</div>
            </div>

            <div class="action-buttons">
                <a href="javascript:history.back()" class="btn-cancel">Cancel</a>
                <button type="button" class="btn-payment" onclick="proceedToCheckout()">Payment</button>
            </div>
        </div>
    </div>

    <!-- Hidden Form -->
    <form id="booking-form" action="{{ route('payment.process') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        <input type="hidden" name="theater_id" id="input-theater-id" value="{{ request('theater_id') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
        <input type="hidden" name="time" value="{{ request('time') }}">
        <input type="hidden" name="seats" id="input-seats">
        <input type="hidden" name="total_price" id="input-total-price">
        <input type="hidden" name="payment_method" value="Midtrans">
    </form>

    <script>
        // Seat Layout Config
        // Rows A-H (8 rows)
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        const groupLeft = document.getElementById('group-left');
        const groupCenter = document.getElementById('group-center');
        const groupRight = document.getElementById('group-right');

        let selectedSeatLabels = [];
        let ticketPrice = 35000;

        // Determine Price
        const dateStr = "{{ request('date') }}";
        if (dateStr) {
            const dateObj = new Date(dateStr);
            const day = dateObj.getDay();
            if (day === 0 || day === 6) ticketPrice = 50000;
        }

        // Generate Seats
        // Total cols 16.
        // Group Left: 1-4
        // Group Center: 5-12
        // Group Right: 13-16

        rows.forEach(rowLabel => {
            // Group Left (1-4)
            for (let i = 1; i <= 4; i++) createSeat(groupLeft, rowLabel, i);

            // Group Center (5-12)
            for (let i = 5; i <= 12; i++) createSeat(groupCenter, rowLabel, i);

            // Group Right (13-16)
            for (let i = 13; i <= 16; i++) createSeat(groupRight, rowLabel, i);
        });

        function createSeat(container, rowLabel, num) {
            const seatId = rowLabel + num;

            // Create DIV instead of SVG
            const div = document.createElement("div");
            div.classList.add("seat-icon");
            div.dataset.label = seatId;
            div.onclick = () => toggleSeat(div, seatId);

            // Random Taken Logic (Simulated)
            if (Math.random() < 0.15) {
                div.classList.add("taken");
            }

            container.appendChild(div);
        }

        function toggleSeat(element, label) {
            if (element.classList.contains('taken')) return;

            element.classList.toggle('selected');

            if (element.classList.contains('selected')) {
                selectedSeatLabels.push(label);
            } else {
                selectedSeatLabels = selectedSeatLabels.filter(l => l !== label);
            }

            updateSummary();
        }

        function updateSummary() {
            // Seat Numbers
            const seatListEl = document.getElementById('seat-numbers');
            seatListEl.textContent = selectedSeatLabels.length > 0 ? selectedSeatLabels.join(', ') : '-';

            // Chair Count
            const countEl = document.getElementById('chair-count');
            countEl.textContent = selectedSeatLabels.length + " Chair" + (selectedSeatLabels.length !== 1 ? 's' : '');

            // Price
            const total = selectedSeatLabels.length * ticketPrice;
            document.getElementById('total-price-display').textContent = 'Rp' + total;
        }

        function proceedToCheckout() {
            if (selectedSeatLabels.length === 0) {
                alert("Please select at least one seat.");
                return;
            }

            const total = selectedSeatLabels.length * ticketPrice;

            document.getElementById('input-seats').value = JSON.stringify(selectedSeatLabels);
            document.getElementById('input-total-price').value = total;

            document.getElementById('booking-form').submit();
        }

        // Optional: Set Theater Name from URL param if available (simplistic)
        // Ideally we'd fetch this via API or pass it from controller
        const urlParams = new URLSearchParams(window.location.search);
        // If we had the theater name passed in view we could use it. 
        // For now, let's leave it generic or use a placeholder if not passed.
    </script>
@endsection