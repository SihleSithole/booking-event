<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\CreateEmail;
use App\Models\Bookings;
use App\Models\Categories;
use App\Models\Event;
use App\Models\Payments;
use App\Models\User;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BookingController extends Controller
{

    /**
     * Delete the user's account.
     */
   // public function bookingEvent(Request $request): RedirectResponse
    public function bookingEvent(Request $request, $id): RedirectResponse
    {

        $user = auth()->user();

        $user_id = $user->id;
        $role = $user->role;

        $event = $id;
        $current_date = date('Y-m-d');
        $status = 'paid';
        $qrcode = 'vfg33255ytdf';

        $booking = Bookings::create([
            'user_id' => $user_id,
            'event_event_id' => $event,
            'booking_date' => $current_date,
            'payment_status' => $status,
            'qr_code' => $qrcode,
        ]);

        $even = Event::findOrFail($event);

        $payment = Payments::create([
            'bookings_booking_id' => $event,
            'amount' => $even->ticket_price,
            'payment_method' => 'card',
            'payment_status' => $status,

        ]);

        Mail::to(auth()->user()->email)->send(new CreateEmail($booking));

        /*SEND AN EMAIL HERE*/

        return redirect(route('dashboard',  ['identifier' => $role],  absolute:  false));
    }

    public function cancelBooking(Request $request): RedirectResponse
    {

       $booking = Bookings::findOrFail($request->delete_event);

        $booking->delete();

        /*SEND AN EMAIL*/

        $user = auth()->user();
        $role = $user->role;

        return redirect(route('dashboard',  ['identifier' => $role],  absolute:  false));
    }

    public function removeUser(Request $request): RedirectResponse
    {

        $user_id = $request->delete_user;

        $user = User::findOrFail($user_id);

        $user->delete();

        $role = 'admin';

        return redirect(route('dashboard',  ['identifier' => $role],  absolute:  false));
    }


}


//removeUser
