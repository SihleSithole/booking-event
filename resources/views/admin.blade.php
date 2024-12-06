<x-app-layout>
    <div class="flex h-screen">
        <!-- Left sidebar navigation -->
        <div class="w-64 bg-gray-800 text-white p-5 space-y-6">
            <ul class="space-y-4">
                <!-- Navigation items -->
                <!-- Added Reviews Link -->
                <li>
                    <a href="javascript:void(0);" id="reviews-tab" onclick="showReviews()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Bookings</a>
                </li>
                <li>
                    <a href="javascript:void(0);" id="events-tab" onclick="showEvents()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Events</a>
                </li>
                <li>
                    <a href="javascript:void(0);" id="bookings-tab" onclick="showBookings()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Users</a>
                </li>

            </ul>
        </div>

        <?php
        /* for events */
        $user = auth()->user();
        $userEvents = $user->getOrganisers(); // Get the organisers related to the user

        $userBookings = \App\Models\Bookings::allBookings();

        /* Get all the users */
        $users = \App\Models\User::all();
        ?>

            <!-- Main content area -->
        <div class="flex-1 p-6">
            <!-- Events section -->
            <div id="events" class="space-y-6 max-h-[calc(100vh-120px)] overflow-y-auto scrollbar-hidden">
                <!-- Header with "Create Event" button aligned to the right -->
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Events</h2>
                    <p class="text-gray-600">All Events Here.</p>
                </div>

                <!-- Example Event Card -->

                @if ($userEvents->isNotEmpty())
                    @foreach ($userEvents as $organiser)

                        @foreach ($organiser->events as $event)
                            <div class="bg-white shadow-md rounded-lg p-5 mb-4">
                                <div class="flex justify-between">
                                    <!-- Left: Event Details -->
                                    <div class="w-1/2 pr-4">
                                        <h3 class="text-xl font-semibold text-gray-700">Organiser: {{ $organiser->name }}</h3>
                                        <p class="text-gray-500">Event Name: {{ $event->name }}</p>
                                        <p class="text-gray-500">Date: {{ $event->date }}</p>
                                        <p class="text-gray-500">Location: {{ $event->location }}</p>
                                        <p class="text-gray-500">Description: {{ $event->description }}</p>
                                        <p class="text-gray-500">Status: {{ $event->status }}</p>
                                        <p class="text-gray-500">Ticket Price: {{ $event->ticket_price }}</p>
                                        <br>

                                    </div>

                                    <!-- Right: Category Details -->
                                    <div class="w-1/2 pl-4 border-l-2 border-gray-300">
                                        <h3 class="text-xl font-semibold text-gray-700">Category: {{ $event->category->name  }}</h3>
                                        <p class="text-gray-500">Description: {{ $event->category->description }}</p>
                                        <br>
                                        <img src="" alt="event image here">
                                    </div>
                                </div>

                                <!-- Centered Button -->
                                <div class="text-center mt-4">

                                    <button type="submit" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md" form="deleteformEvent"
                                            onclick="passDeleteIdEvent(this)"
                                            data-event="{{ $event->event_id }}"
                                    >Delete</button>

                                    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md"
                                            onclick="openEditEventModal(this)"
                                            data-euserid="{{ $organiser->id }}"
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

                            </div>
                        @endforeach

                    @endforeach
                @endif
            </div>

            <!-- Bookings section -->
            <div id="bookings" class="space-y-6 mt-10 hidden overflow-y-auto max-h-[500px] scrollbar-hidden">
                <h2 class="text-2xl font-semibold text-gray-800">Users</h2>
                <p class="text-gray-600">Manage user accounts..</p>
                <!-- Example Booking Card -->

                @if ($users->isNotEmpty())
                    @foreach ($users as $user)
                        <div class="bg-white shadow-md rounded-lg p-5 mb-4">
                            <div class="flex justify-between">
                                <!-- Left: Event Details -->
                                <div class="w-1/2 pr-4">
                                    <h3 class="text-xl font-semibold text-gray-700"> </h3>
                                    <p class="text-gray-500">Name : {{$user->name}}</p>
                                    <p class="text-gray-500">Email :  {{$user->email}}</p>
                                    <p class="text-gray-500">Role: {{$user->role}} </p>
                                </div>

                                <!-- Right: Event Image -->
                                <div class="w-1/2 pl-4 border-l-2 border-gray-300">
                                    <button type="submit" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md" form="deleteform"
                                            onclick="passDeleteId(this)"
                                            data-delete="{{$user->id}}"
                                    >Delete Account</button>
                                    <button type="button" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md" form="editform"
                                            onclick="passDataUser(this)"
                                            data-edituser="{{$user->id}}"
                                    >Edit Account</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Reviews section -->
            <div id="reviews" class="space-y-6 mt-10 hidden overflow-y-auto max-h-[500px] scrollbar-hidden">
                <h2 class="text-2xl font-semibold text-gray-800">Bookings</h2>
                <p class="text-gray-600">All confirmed bookings.</p>

                <!-- Example Booking Card -->
                @foreach ($userBookings as $booking)
                <div class="bg-white shadow-md rounded-lg p-5 mb-4">
                    <div class="flex justify-between">
                        <div class="w-1/2 pr-4">
                            <h3 class="text-xl font-semibold text-gray-700">Booking By : {{ $booking->user->name }}</h3>
                            <br>
                            <p class="text-gray-500">Event:  {{ $booking->event->name }} </p>
                            <p class="text-gray-500">Event description :  {{ $booking->event->description }} </p>
                            <p class="text-gray-500">Date:  {{ $booking->event->date }} </p>
                            <p class="text-gray-500">Location :  {{ $booking->event->location }}</p>
                            <p class="text-gray-500">Booking Status:  {{ $booking->event->status }}</p>
                            <p class="text-gray-500">Payment Status:  {{ $booking->payment_status }}</p>
                            <p class="text-gray-500">Ticket Price:  {{ $booking->event->ticket_price }}</p>
                            <br>
                            <p class="text-gray-500">Event Category :  {{ $booking->event->category->name }}</p>
                            <p class="text-gray-500">Category Description :  {{ $booking->event->category->description }}</p>

                        </div>
                        <div class="flex items-center justify-end">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg">View Details</button>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Repeat the above card for each booking -->

            </div>

        </div>
    </div>

    <form method="POST" action="/edit-user" id="editform">
        @csrf

        <input type="hidden" id="user_ids" name="user_ids" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

    </form>

    <form id="deleteform" method="post" action="/adminDeleteUser">
        @csrf
        @method('DELETE')

        <input type="hidden" id="delete_user" name="delete_user" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

    </form>


    <form id="deleteformEvent" method="post" action="/deleteEvent">
        @csrf
        @method('DELETE')

        <input type="hidden" id="delete_event" name="delete_event" class="w-full p-2 border rounded-md" placeholder="Event ID" required>

    </form>


    <!-- Modal for Editing Event -->
    <div id="edit-event-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-[600px]">

            <form method="POST" action="/edit_event_admin">
                @csrf
                @method('patch')
                <!-- Category Form Section -->
                <div id="category-form-edit" class="space-y-4">
                    <h3 class="text-2xl font-semibold text-gray-800">Edit Category Information</h3>

                    <!-- Category Name Input -->
                    <input type="hidden" id="user_id" name="user_id" class="w-full p-2 border rounded-md" placeholder="Category Name" required>
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
        // Function to show the Events section and hide others
        function showEvents() {
            document.getElementById('events').classList.remove('hidden');
            document.getElementById('bookings').classList.add('hidden');
            document.getElementById('reviews').classList.add('hidden');
            document.getElementById('events-tab').classList.add('bg-gray-700');
            document.getElementById('bookings-tab').classList.remove('bg-gray-700');
            document.getElementById('reviews-tab').classList.remove('bg-gray-700');
        }

        // Function to show the Bookings section and hide others
        function showBookings() {
            document.getElementById('events').classList.add('hidden');
            document.getElementById('bookings').classList.remove('hidden');
            document.getElementById('reviews').classList.add('hidden');
            document.getElementById('bookings-tab').classList.add('bg-gray-700');
            document.getElementById('events-tab').classList.remove('bg-gray-700');
            document.getElementById('reviews-tab').classList.remove('bg-gray-700');
        }

        // Function to show the Reviews section and hide others
        function showReviews() {
            document.getElementById('events').classList.add('hidden');
            document.getElementById('bookings').classList.add('hidden');
            document.getElementById('reviews').classList.remove('hidden');
            document.getElementById('reviews-tab').classList.add('bg-gray-700');
            document.getElementById('events-tab').classList.remove('bg-gray-700');
            document.getElementById('bookings-tab').classList.remove('bg-gray-700');
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
            const user_id =  button.getAttribute('data-euserid');

            document.getElementById('id_edit').value = eventt;

            document.getElementById('user_id').value = user_id;

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

        function closeEditEventModal() {
            document.getElementById('edit-event-modal').classList.add('hidden');
        }

        // Function to pass the event id for deletion
        function passDeleteId(button) {
            var deleteId = button.getAttribute('data-delete');

            document.getElementById('delete_user').value = deleteId;
            document.getElementById('deleteform').submit();

            alert("User Account has been successfully deleted.");
        }

        function passDataUser(button) {

            var userId = button.getAttribute('data-edituser');

            document.getElementById('user_ids').value = userId;
            document.getElementById('editform').submit();

        }

        function passDeleteIdEvent(button) {
            var deleteId = button.getAttribute('data-event');

            document.getElementById('delete_event').value = deleteId;
            document.getElementById('deleteformEvent').submit();

            alert("Event Deleted.");
        }

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


    </script>

    <style>
        /* Make the scrollbar invisible */
        .scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hidden {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</x-app-layout>
