<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bookings;
use App\Models\Categories;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EventController extends Controller
{

    /**
     * Delete the user's account.
     */
    public function destroyEvent(Request $request): RedirectResponse
    {

        $eventss = Event::all();

        $event = Event::findOrFail($request->delete_event);
        $category = $event->category;

        $bookings = Bookings::where('event_event_id', $request->delete_event)->get();

        // Loop through the bookings collection and delete each booking
        $bookings->each(function($booking) {
            $booking->delete();
        });

        $category->delete();
        $event->delete();

        $user = auth()->user();
        $role = $user->role;

        return redirect(route('dashboard',  ['identifier' => $role],  absolute:  false));
    }

    public function store(Request $request): RedirectResponse
    {

       $Category = Categories::create([
            'name' => $request->category_name,
            'description' => $request->category_description,

        ]);

        $Event = Event::create([
            'name' => $request->event_name,
            'description' => $request->event_description,
            'location' => $request->event_location,
            'date' => $request->event_date,
            'time' => $request->event_time,
            'max_attendees' => $request->max_attendees,
            'ticket_price' => $request->ticket_price,
            'status' => $request->event_status,
            'visibility' => $request->event_visibility,
            'categories_id' => $Category->id,  // Pass the category ID here
            'user_id' => auth()->id(),  // Assuming the event creator is logged in
        ]);

        $user = auth()->user();
        $role = $user->role;

        return redirect(route('dashboard',  ['identifier' => $role],  absolute:  false));


    }

    /*update the event*/

    public function updateEvent(Request $request): RedirectResponse
    {

        // Find the category using the ID provided
        $event = Event::find($request->id_edit);
        $category = $event->category;

        // Update the category if necessary
        $category->update([
            'name' => $request->category_name_edit,
            'description' => $request->category_description_edit,
        ]);

        // Update the event details
        $event->update([
            'name' => $request->event_name_edit,
            'description' => $request->event_description_edit,
            'location' => $request->event_location_edit,
            'date' => $request->event_date_edit,
            'time' => $request->event_time_edit,
            'max_attendees' => $request->max_attendees_edit,
            'ticket_price' => $request->ticket_price_edit,
            'status' => $request->event_status_edit,
            'visibility' => $request->event_visibility_edit,
            'categories_id' => $category->id, // Make sure to update the category ID
            'user_id' => auth()->id(),  // Assuming the event creator is logged in
        ]);

        // Get the user's role for redirecting
        $user = auth()->user();
        $role = $user->role;

        // Redirect to the dashboard or the appropriate route
        return redirect(route('dashboard', ['identifier' => $role], absolute: false))
            ->with('success', 'Event and Category updated successfully!');
    }

    public function updateEventAdmin(Request $request): RedirectResponse
    {

        // Find the category using the ID provided
        $event = Event::find($request->id_edit);
        $category = $event->category;

        // Update the category if necessary
        $category->update([
            'name' => $request->category_name_edit,
            'description' => $request->category_description_edit,
        ]);

        // Update the event details
        $event->update([
            'name' => $request->event_name_edit,
            'description' => $request->event_description_edit,
            'location' => $request->event_location_edit,
            'date' => $request->event_date_edit,
            'time' => $request->event_time_edit,
            'max_attendees' => $request->max_attendees_edit,
            'ticket_price' => $request->ticket_price_edit,
            'status' => $request->event_status_edit,
            'visibility' => $request->event_visibility_edit,
            'categories_id' => $category->id, // Make sure to update the category ID
            'user_id' => $request->user_id,  // Assuming the event creator is logged in
        ]);

        // Get the user's role for redirecting
        $user = auth()->user();
        $role = $user->role;

        // Redirect to the dashboard or the appropriate route
        return redirect(route('dashboard', ['identifier' => $role], absolute: false))
            ->with('success', 'Event and Category updated successfully!');
    }


}
