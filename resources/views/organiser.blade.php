<x-app-layout>
    <div class="flex h-screen">
        <!-- Left sidebar navigation -->
        <div class="w-64 bg-gray-800 text-white p-5 space-y-6">
            <ul class="space-y-4">
                <!-- Navigation items -->
                <li>
                    <a href="javascript:void(0);" id="events-tab" onclick="showEvents()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Events</a>
                </li>
                <li>
                    <a href="javascript:void(0);" id="bookings-tab" onclick="showBookings()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Bookings</a>
                </li>
            </ul>
        </div>

        <?php

             $user = auth()->user();
             $userEvents = $user->events()->with('category')->get();

             $userBookings = \App\Models\Bookings::showBookings();

         ?>

        <!-- Main content area -->
        <div class="flex-1 p-6">
            <!-- Events section -->
            <div id="events" class="space-y-6">
                <!-- Header with "Create Event" button aligned to the right -->
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Events</h2>
                    <button onclick="openCreateEventModal()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Create Event</button>
                </div>
                <p class="text-gray-600">Manage your events here. Create, edit, and delete event.</p>
                <!-- Example Event Card -->

                @foreach ($userEvents as $event)

                <div class="bg-white shadow-md rounded-lg p-5">
                    <h3 class="text-xl font-semibold text-gray-700">Event : {{ $event->name }}</h3>
                    <p class="text-gray-500">Date: {{ $event->date }}</p>
                    <p class="text-gray-500">Location: {{ $event->location }}</p>
                    <button type="submit" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md" form="deleteform"
                            onclick="passDeleteId(this)"
                            data-delete="{{ $event->event_id }}"
                    >Delete</button>
                    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md"
                        onclick="openEditEventModal(this)"
                        data-desc="{{ $event->description }}"
                        data-name="{{ $event->name }}"
                        data-date="{{ $event->date }}"
                        data-loc="{{ $event->location }}"
                        data-time="{{ $event->time }}"
                            data-att="{{ $event->max_attendees }}"
                            data-price="{{ $event->ticket_price }}"
                            data-status="{{ $event->status }}"
                            data-visible="{{ $event->visibility }}"
                            data-cname="{{ $event->category->name }}"
                            data-cdesc="{{ $event->category->description }}"
                            data-event="{{ $event->event_id }}"
                          >
                    Edit Event</button>
                </div>

                @endforeach


            </div>

            <!-- Bookings section -->
            <div id="bookings" class="space-y-6 mt-10 hidden">
                <h2 class="text-2xl font-semibold text-gray-800">Bookings</h2>
                <p class="text-gray-600">Manage your event bookings and see detailed reports.</p>
                <!-- Example Booking Card -->

                @foreach ($userBookings as $booking)
                <div class="bg-white shadow-md rounded-lg p-5">
                    <h3 class="text-xl font-semibold text-gray-700">Booking for : {{ $booking->user->name }}</h3>
                    <br>
                    <p class="text-gray-500">Event:  {{ $booking->event->name }} </p>
                    <p class="text-gray-500">Event description :  {{ $booking->event->description }} </p>
                    <p class="text-gray-500">Date:  {{ $booking->event->date }} </p>
                    <p class="text-gray-500">Location :  {{ $booking->event->location }}</p>
                    <p class="text-gray-500">Booking Status:  {{ $booking->event->status }}</p>
                    <br>
                    <p class="text-gray-500">Event Category :  {{ $booking->event->category->name }}</p>
                    <p class="text-gray-500">Category Description :  {{ $booking->event->category->description }}</p>

                </div>
                @endforeach


            </div>
        </div>
    </div>

    <form id="deleteform" method="post" action="/deleteEvent">
        @csrf
        @method('DELETE')

        <input type="hidden" id="delete_event" name="delete_event" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

    </form>

    <!-- Modal for Creating Event -->
    <div id="create-event-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-[600px]">

            <form method="POST" action="/add_event">
                @csrf <!-- CSRF token for security -->

                <!-- Category Form Section -->
                <div id="category-form" class="space-y-4">
                    <h3 class="text-2xl font-semibold text-gray-800">Enter Category Information</h3>

                    <!-- Category Name Input -->
                    <input type="text" name="category_name" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

                    <!-- Category Description Input -->
                    <textarea name="category_description" class="w-full p-2 border rounded-md" placeholder="Category Description" rows="4" required></textarea>
                </div>

                <!-- Event Details Form Section (Initially Hidden) -->
                <div id="event-details-form" class="space-y-4 hidden">
                    <h3 class="text-2xl font-semibold text-gray-800">Event Details</h3>

                    <!-- Event Name and Description (Two Inputs per Line) -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="event_name" class="w-full p-2 border rounded-md" placeholder="Event Name" required>
                        <textarea name="event_description" class="w-full p-2 border rounded-md" placeholder="Event Description" rows="4" required></textarea>
                    </div>

                    <!-- Event Location and Date -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="event_location" class="w-full p-2 border rounded-md" placeholder="Event Location" required>
                        <input type="date" name="event_date" class="w-full p-2 border rounded-md" required>
                    </div>

                    <!-- Event Time and Max Attendees -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="time" name="event_time" class="w-full p-2 border rounded-md" required>
                        <input type="number" name="max_attendees" class="w-full p-2 border rounded-md" placeholder="Max Attendees" required>
                    </div>

                    <!-- Ticket Price and Event Status -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="ticket_price" class="w-full p-2 border rounded-md" placeholder="Ticket Price" required>
                        <select name="event_status" class="w-full p-2 border rounded-md" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Event Visibility -->
                    <div class="grid grid-cols-2 gap-4">
                        <select name="event_visibility" class="w-full p-2 border rounded-md" required>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                </div>

                <!-- Inline Buttons -->
                <div class="flex space-x-4">
                    <button type="button" onclick="closeCreateEventModal()" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md w-full">Close</button>
                    <button type="button" onclick="showEventDetailsForm()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md w-full" id="nextbtn">Next</button>
                    <button type="submit" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md w-full hidden" id="submit-btn">Create Event</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal for Editing Event -->
    <div id="edit-event-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-[600px]">

            <form method="POST" action="/edit_event">
                @csrf
                @method('patch')
                <!-- Category Form Section -->
                <div id="category-form-edit" class="space-y-4">
                    <h3 class="text-2xl font-semibold text-gray-800">Edit Category Information</h3>

                    <!-- Category Name Input -->
                    <input type="hidden" id="id_edit" name="id_edit" class="w-full p-2 border rounded-md" placeholder="Category Name" required>
                    <input type="text" id="category_name_edit" name="category_name_edit" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

                    <!-- Category Description Input -->
                    <textarea id="category_description_edit" name="category_description_edit" class="w-full p-2 border rounded-md" placeholder="Category Description" rows="4" required></textarea>
                </div>

                <!-- Event Details Form Section (Initially Hidden) -->
                <div id="event-details-form-edit" class="space-y-4 hidden">
                    <h3 class="text-2xl font-semibold text-gray-800">Edit Event Details</h3>

                    <!-- Event Name and Description (Two Inputs per Line) -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" id="event_name_edit" name="event_name_edit" class="w-full p-2 border rounded-md" placeholder="Event Name" required>
                        <textarea id="event_description_edit" name="event_description_edit" class="w-full p-2 border rounded-md" placeholder="Event Description" rows="4" required></textarea>
                    </div>

                    <!-- Event Location and Date -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" id="event_location_edit" name="event_location_edit" class="w-full p-2 border rounded-md" placeholder="Event Location" required>
                        <input type="date" id="event_date_edit" name="event_date_edit" class="w-full p-2 border rounded-md" required>
                    </div>

                    <!-- Event Time and Max Attendees -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="time" id="event_time_edit" name="event_time_edit" class="w-full p-2 border rounded-md" required>
                        <input type="number" id="max_attendees_edit" name="max_attendees_edit" class="w-full p-2 border rounded-md" placeholder="Max Attendees" required>
                    </div>

                    <!-- Ticket Price and Event Status -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" id="ticket_price_edit" name="ticket_price_edit" class="w-full p-2 border rounded-md" placeholder="Ticket Price" required>
                        <select id="event_status_edit" name="event_status_edit" class="w-full p-2 border rounded-md" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Event Visibility -->
                    <div class="grid grid-cols-2 gap-4">
                        <select id="event_visibility_edit" name="event_visibility_edit" class="w-full p-2 border rounded-md" required>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                </div>

                <!-- Inline Buttons -->
                <div class="flex space-x-4">
                    <button type="button" onclick="closeEditEventModal()" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md w-full">Close</button>
                    <button type="button" onclick="showEditEventDetailsForm()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md w-full" id="nextbtn-edit">Next</button>
                    <button type="submit" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md w-full hidden" id="submit-btn-edit">Update Event</button>
                </div>
            </form>

        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Open the Create Event modal
        function openCreateEventModal() {
            document.getElementById('create-event-modal').classList.remove('hidden');
        }

        // Close the Create Event modal
        function closeCreateEventModal() {
            document.getElementById('create-event-modal').classList.add('hidden');
        }

        // Show the Event Details form after filling out the Category form
        function showEventDetailsForm() {
            // Get the values of the Category fields
            var categoryName = document.querySelector('input[name="category_name"]').value.trim();
            var categoryDescription = document.querySelector('textarea[name="category_description"]').value.trim();

            // Check if the Category fields are filled
            if (categoryName === "" || categoryDescription === "") {
                alert("Please fill out both Category Name and Category Description before proceeding.");
                return; // Stop proceeding to the next form
            }

            // If fields are valid, hide the Category form and show the Event Details form
            document.getElementById('category-form').classList.add('hidden');
            document.getElementById('event-details-form').classList.remove('hidden');
            document.getElementById('submit-btn').classList.remove('hidden');
            document.getElementById('nextbtn').style.display = 'none';
        }


        // Function to show the Events section and hide others
        function showEvents() {
            document.getElementById('events').classList.remove('hidden');
            document.getElementById('bookings').classList.add('hidden');
            document.getElementById('events-tab').classList.add('bg-gray-700');
            document.getElementById('bookings-tab').classList.remove('bg-gray-700');

        }

        // Function to show the Bookings section and hide others
        function showBookings() {
            document.getElementById('events').classList.add('hidden');
            document.getElementById('bookings').classList.remove('hidden');
            document.getElementById('bookings-tab').classList.add('bg-gray-700');
            document.getElementById('events-tab').classList.remove('bg-gray-700');
        }

        // Open the Edit Event modal
        function openEditEventModal(button) {
            document.getElementById('edit-event-modal').classList.remove('hidden');

            const cName = button.getAttribute('data-cname');
            const cdesc = button.getAttribute('data-cdesc');

            const eventName = button.getAttribute('data-name');
            const eventDesc = button.getAttribute('data-desc');
            const eventLocation = button.getAttribute('data-loc');

            const eventDate= button.getAttribute('data-date');
            const eventTime = button.getAttribute('data-time');
            const eventAttendees = button.getAttribute('data-att');

            const eventPrice= button.getAttribute('data-price');
            const eventStatus = button.getAttribute('data-status');
            const eventVisibility = button.getAttribute('data-visible');

            const eventt = button.getAttribute('data-event');

            document.getElementById('id_edit').value = eventt;

            document.getElementById('category_name_edit').value = cName;
            document.getElementById('category_description_edit').value = cdesc;

            document.getElementById('event_name_edit').value = eventName;
            document.getElementById('event_description_edit').value = eventDesc;
            document.getElementById('event_location_edit').value = eventLocation;

            document.getElementById('event_date_edit').value = eventDate;
            document.getElementById('event_time_edit').value = eventTime;
            document.getElementById('max_attendees_edit').value = eventAttendees;
            document.getElementById('ticket_price_edit').value = eventPrice;
            document.getElementById('event_status_edit').value = eventStatus;
            document.getElementById('event_visibility_edit').value = eventVisibility;

        }

        // Close the Edit Event modal
        function closeEditEventModal() {
            document.getElementById('edit-event-modal').classList.add('hidden');
        }

        // Show the Edit Details form after filling out the Category form
        function showEditEventDetailsForm() {
            // Get the values of the Category fields
            var categoryName = document.querySelector('input[name="category_name_edit"]').value.trim();
            var categoryDescription = document.querySelector('textarea[name="category_description_edit"]').value.trim();

            // Check if the Category fields are filled
            if (categoryName === "" || categoryDescription === "") {
                alert("Please fill out both Category Name and Category Description before proceeding.");
                return; // Stop proceeding to the next form
            }

            // If fields are valid, hide the Category form and show the Event Details form
            document.getElementById('category-form-edit').classList.add('hidden');
            document.getElementById('event-details-form-edit').classList.remove('hidden');
            document.getElementById('submit-btn-edit').classList.remove('hidden');
            document.getElementById('nextbtn-edit').style.display = 'none';
        }

        function passDeleteId(button){

            const deleteEvent= button.getAttribute('data-delete');
            document.getElementById('delete_event').value = deleteEvent;

        }

        // Show events by default when page loads
        window.onload = showEvents;
    </script>
</x-app-layout>
