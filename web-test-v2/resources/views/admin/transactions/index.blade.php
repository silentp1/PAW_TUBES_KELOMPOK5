@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Transaction Verification</h1>
    </div>

    <div style="margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.transactions.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search" placeholder="Search Transaction Code..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
            
            <select name="status" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <input type="date" name="date" value="{{ request('date') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">

            <button type="submit" style="padding: 8px 15px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            <a href="{{ route('admin.transactions.index') }}" style="padding: 8px 15px; background: #cbd5e0; color: #2d3748; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">Order ID/Date</th>
                    <th style="padding: 15px;">User</th>
                    <th style="padding: 15px;">Movie</th>
                    <th style="padding: 15px;">Total</th>
                    <th style="padding: 15px;">Status</th>

                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">
                            <strong>{{ $booking->transaction_code }}</strong><br>
                            <small style="color: #888;">{{ $booking->created_at->format('d M H:i') }}</small>
                        </td>
                        <td style="padding: 15px;">{{ $booking->user->name }}</td>
                        <td style="padding: 15px;">
                            {{ $booking->movie ? $booking->movie->title : 'Movie Deleted' }}
                        </td>
                        <td style="padding: 15px;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">
                            @if($booking->status == 'paid')
                                <span style="background: #e6fffa; color: #2c7a7b; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Paid</span>
                            @elseif($booking->status == 'pending')
                                <span style="background: #fffaf0; color: #c05621; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Pending</span>
                            @else
                                <span style="background: #dcdcdc; color: #555; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Cancelled</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
