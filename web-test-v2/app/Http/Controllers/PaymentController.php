<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

use Midtrans\Transaction; // Add this

class PaymentController extends Controller
{
    // Show Payment Page
    public function index(Request $request)
    {
        // Receive data from Booking Page form
        $data = $request->validate([
            'movie_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'seats' => 'required', // JSON string or array
            'total_price' => 'required',
        ]);

        $movie = Movie::findOrFail($data['movie_id']);

        // Pass data to view
        return view('payment.index', compact('movie', 'data'));
    }

    // Process Payment & Create Booking (Snap Redirect)
    public function process(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'seats' => 'required',
            'total_price' => 'required',
            'payment_method' => 'required',
        ]);

        // Generate Unique Transaction Code
        $code = 'TRX-' . Date('Ymd') . '-' . rand(1000, 9999);

        // Create Booking
        $booking = Booking::create([
            'transaction_code' => $code,
            'user_id' => Auth::id(),
            'movie_id' => $validated['movie_id'],
            'booking_date' => $validated['date'],
            'booking_time' => $validated['time'],
            'seats' => $validated['seats'], // stored as JSON
            'total_price' => $validated['total_price'],
            'payment_method' => 'Midtrans Snap',
            'status' => 'pending',
        ]);

        // Set Configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        // Snap Redirect Parameters
        $params = array(
            'transaction_details' => array(
                'order_id' => $booking->transaction_code,
                'gross_amount' => (int) $booking->total_price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
            // Redirect URL override - Ensure this matches your app domain
            'callbacks' => [
                'finish' => route('payment.complete', $booking->id)
            ]
        );

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($params)->redirect_url;

            // Redirect user to Midtrans Payment Page
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment Error: ' . $e->getMessage());
        }
    }

    // Show Ticket
    public function showTicket($id)
    {
        $booking = Booking::with('movie')->where('user_id', Auth::id())->findOrFail($id);
        return view('tickets.show', compact('booking'));
    }

    // RESUME PAYMENT (New Snap Token)
    public function resume($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        // If already paid, just show ticket
        if ($booking->status == 'paid') {
            return redirect()->route('tickets.show', $id);
        }

        // Config setup
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        // Update Transaction Code to avoid 'Duplicate Order ID' error from Midtrans
        // We append a suffix or regenerate slightly
        $newCode = $booking->transaction_code . '-R' . rand(10, 99);
        $booking->update(['transaction_code' => $newCode]);

        $params = array(
            'transaction_details' => array(
                'order_id' => $booking->transaction_code, // Use new code
                'gross_amount' => (int) $booking->total_price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
            'callbacks' => [
                'finish' => route('payment.complete', $booking->id)
            ]
        );

        try {
            $paymentUrl = Snap::createTransaction($params)->redirect_url;
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Resume Payment Error: ' . $e->getMessage());
        }
    }

    // COMPLETE PAYMENT (Status Check)
    public function complete($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        // Config setup for Status Check
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            // Check status from Midtrans API
            $status = Transaction::status($booking->transaction_code);

            // Ensure we handle both Object and Array return types
            $status = json_decode(json_encode($status), true);

            $transactionStatus = $status['transaction_status'] ?? null;
            $fraudStatus = $status['fraud_status'] ?? null;

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    // TODO: Set payment status in merchant's database to 'challenge'
                } else if ($fraudStatus == 'accept') {
                    $booking->update(['status' => 'paid']);
                }
            } else if ($transactionStatus == 'settlement') {
                $booking->update(['status' => 'paid']);
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $booking->update(['status' => 'failed']);
            } else if ($transactionStatus == 'pending') {
                $booking->update(['status' => 'pending']);
            }

        } catch (\Exception $e) {
            // If transaction not found or error, likely pending or not started
            // Keep as is or log error
        }

        return redirect()->route('history.index');
    }
}
