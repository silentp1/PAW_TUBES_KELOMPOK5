@extends('layouts.app')

@section('title', 'History')

@section('content')
    <div class="history-container" style="max-width: 800px; margin: 0 auto; padding: 30px;">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
            <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center;">
                <img src="{{ asset('back_arrow.png') }}" alt="Back" style="width: 24px; height: 24px;">
            </a>
            <h2 style="margin: 0;">Booking History</h2>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @foreach($bookings as $booking)
            <div class="history-card"
                style="display: flex; gap: 20px; align-items: flex-start; background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <img src="{{ $booking->movie->poster_url }}"
                    style="width: 100px; height: auto; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">

                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.2rem; margin-bottom: 5px;">{{ $booking->movie->title }}</h3>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($booking->status == 'paid')
                                <span style="background: #e6fffa; color: #2c7a7b; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 500;">Paid</span>
                            @elseif($booking->status == 'pending')
                                <span style="background: #fffaf0; color: #c05621; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 500;">Pending Verification</span>
                                <a href="{{ route('payment.resume', $booking->id) }}" 
                                   style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
                                    Continue Payment
                                </a>
                            @else
                                <span style="background: #ffe6e6; color: #c00; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 500;">Cancelled</span>
                            @endif
                        </div>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 10px;">
                        {{ $booking->booking_date }} • {{ $booking->booking_time }}
                    </p>

                    <div style="display: flex; gap: 30px; margin-top: 15px;">
                        <div>
                            <small style="color: var(--text-muted);">STUDIO</small><br>
                            <strong>{{ ($booking->movie_id % 5) + 1 }}</strong>
                        </div>
                        <div>
                            <small style="color: var(--text-muted);">SEATS</small><br>
                            <strong>{{ implode(', ', json_decode($booking->seats)) }}</strong>
                        </div>
                        <div>
                            <small style="color: var(--text-muted);">TOTAL</small><br>
                            <strong style="color: var(--primary);">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <!-- Rating Section (Only for Paid) -->
                    @if($booking->status == 'paid')
                        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid var(--border);">
                            @if(isset($myReviews[$booking->id]))
                                <div style="color: var(--text-main);">
                                    <strong style="display:block; margin-bottom: 5px;">Your Rating:</strong>
                                    <span style="font-size: 1.2rem; color: var(--accent);">
                                        @for($i = 0; $i < $myReviews[$booking->id]->rating; $i++) ★ @endfor
                                        <span
                                            style="color:#ddd; font-size:1rem; margin-left:5px;">({{ $myReviews[$booking->id]->rating }}/5)</span>
                                    </span>
                                    @if($myReviews[$booking->id]->comment)
                                        <p style="margin-top: 10px; color: var(--text-muted); font-style: italic;">
                                            "{{ $myReviews[$booking->id]->comment }}"
                                        </p>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('history.rate') }}" method="POST"
                                    style="display: flex; flex-direction: column; gap: 10px;">
                                    @csrf
                                    <input type="hidden" name="movie_id" value="{{ $booking->movie_id }}">
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                    <label style="font-size: 0.9rem; margin-bottom: 5px;">Rate this movie:</label>

                                    <!-- Star Rating UI -->
                                    <div class="star-rating">
                                        <input type="radio" id="star5-{{ $booking->id }}" name="rating" value="5" /><label
                                            for="star5-{{ $booking->id }}">★</label>
                                        <input type="radio" id="star4-{{ $booking->id }}" name="rating" value="4" /><label
                                            for="star4-{{ $booking->id }}">★</label>
                                        <input type="radio" id="star3-{{ $booking->id }}" name="rating" value="3" /><label
                                            for="star3-{{ $booking->id }}">★</label>
                                        <input type="radio" id="star2-{{ $booking->id }}" name="rating" value="2" /><label
                                            for="star2-{{ $booking->id }}">★</label>
                                        <input type="radio" id="star1-{{ $booking->id }}" name="rating" value="1" /><label
                                            for="star1-{{ $booking->id }}">★</label>
                                    </div>

                                    <!-- Comment Area -->
                                    <textarea name="comment" placeholder="Write a review (optional)..."
                                        style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 0.9rem; resize: vertical; min-height: 60px;"></textarea>

                                    <button type="submit"style="align-self: flex-start; padding: 8px 20px; background: var(--text-main); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; margin-top: 5px;">Submit Review</button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <style>
                        .star-rating {
                            display: flex;
                            flex-direction: row-reverse;
                            justify-content: flex-end;
                            gap: 5px;
                        }

                        .star-rating input {
                            display: none;
                        }

                        .star-rating label {
                            font-size: 1.5rem;
                            color: #ddd;
                            cursor: pointer;
                            transition: color 0.2s;
                        }

                        .star-rating input:checked~label,
                        .star-rating label:hover,
                        .star-rating label:hover~label {
                            color: var(--accent);
                            /* Gold color */
                        }
                    </style>
                </div>

                <div style="display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end;">
                    @if($booking->status == 'paid')
                        <a href="{{ route('tickets.show', $booking->id) }}"
                            style="color: var(--primary); font-size: 0.9rem; font-weight: 500;">View Ticket →</a>
                    @endif
                </div>
            </div>
        @endforeach

        @if($bookings->isEmpty())
            <div style="text-align: center; padding: 50px; color: var(--text-muted);">
                No booking history yet.
            </div>
        @endif
    </div>
@endsection