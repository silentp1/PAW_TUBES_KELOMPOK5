<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with([
            'user',
            'movie' => function ($query) {
                $query->withTrashed();
            }
        ])
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where('transaction_code', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $bookings = $query->get();

        return view('admin.transactions.index', compact('bookings'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:paid,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi diperbarui.');
    }
}
