<x-app-layout>
    <div class="flex h-screen">
        <!-- Left sidebar navigation -->
        <div class="w-64 bg-gray-800 text-white p-5 space-y-6">
            <ul class="space-y-4">
                <!-- Navigation items -->
                <li>
                    <a href="javascript:void(0);" id="events-tab" onclick="showEvents()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Feeds</a>
                </li>
                <li>
                    <a href="javascript:void(0);" id="bookings-tab" onclick="showBookings()" class="block text-lg hover:text-gray-400 py-2 px-4 rounded-md">Manage Bookings</a>
                </li>
            </ul>
        </div>

        <?php

        /*for events*/
        $user = auth()->user();
        $userEvents = $user->getOrganisers(); // Get the organisers related to the user

        /*for bookings*/
        $userBookings = $user->bookings()->with('event')->get();

      //  dd($userBookings);

        ?>

            <!-- Main content area -->
        <div class="flex-1 p-6">
            <!-- Events section -->
            <div id="events" class="space-y-6 max-h-[calc(100vh-120px)] overflow-y-auto scrollbar-hidden">
                <!-- Header with "Create Event" button aligned to the right -->
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Events</h2>
                    <p class="text-gray-600">Browse and book events here.</p>
                </div>

                <!-- Example Event Card -->

                @if ($userEvents->isNotEmpty())
                @foreach ($userEvents as $organiser)

                    @foreach ($organiser->events as $event)
                        <div class="bg-white shadow-md rounded-lg p-5 mb-4">
                            <div class="flex justify-between">
                                <!-- Left: Event Details -->
                                <div class="w-1/2 pr-4">
                                    <h3 class="text-xl font-semibold text-gray-700">Event: {{ $event->name }}</h3>
                                    <p class="text-gray-500">Date: {{ $event->date }}</p>
                                    <p class="text-gray-500">Location: {{ $event->location }}</p>
                                    <p class="text-gray-500">Description: {{ $event->description }}</p>
                                    <p class="text-gray-500">Status: {{ $event->status }}</p>
                                    <h6 class="text-xl font-semibold text-gray-700">Price: R{{$event->ticket_price}}</h6>
                                    <br>
                                    <h3 class="text-xl font-semibold text-gray-700">Category: {{ $event->category->name  }}</h3>
                                    <p class="text-gray-500">Description: {{ $event->category->description }}</p>


                                </div>

                                <!-- Right: Category Details -->
                                <div class="w-1/2 pl-4 border-l-2 border-gray-300">
                                    <img src="" alt="event image here">
                                  <!--  <p class="text-gray-500">Category Name: {{ $event->category->name }}</p>
                                    <p class="text-gray-500">Category Description: {{ $event->category->description }}</p> -->
                                </div>
                            </div>

                            <!-- Centered Button -->
                            <div class="text-center mt-4">

                                <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md"
                                        onclick="openEditEventModal(this)"
                                        data-eventid="{{ $event->event_id }}"
                                        form="booking-event-form">
                                     Book Spot</button>

                            </div>
                        </div>
                    @endforeach

                @endforeach
                @endif
            </div>

            <!-- Bookings section -->
            <div id="bookings" class="space-y-6 mt-10 hidden overflow-y-auto max-h-[500px] scrollbar-hidden">
                <h2 class="text-2xl font-semibold text-gray-800">Bookings</h2>
                <p class="text-gray-600">Manage your event bookings and see detailed reports.</p>
                <!-- Example Booking Card -->

                @if ($userBookings->isNotEmpty())
                @foreach ($userBookings as $bookings)
                    <div class="bg-white shadow-md rounded-lg p-5 mb-4">
                        <div class="flex justify-between">
                            <!-- Left: Event Details -->
                            <div class="w-1/2 pr-4">
                                <h3 class="text-xl font-semibold text-gray-700">Event: {{$bookings->event->name}}</h3>
                                <p class="text-gray-500">Date: {{ $bookings->event->date }}</p>
                                <p class="text-gray-500">Location: {{$bookings->event->location }} </p>
                                <p class="text-gray-500">Status: {{$bookings->event->status }} </p>
                                <h5 class="text-xl font-semibold text-gray-700">Price: R{{$bookings->event->ticket_price}}</h5>
                                <br>
                                <h3 class="text-xl font-semibold text-gray-700">Category: {{$bookings->event->category->name}}</h3>
                                <p class="text-gray-500">Description: {{ $bookings->event->category->description  }} </p>

                                <button type="submit" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md" form="deleteform"
                                        onclick="passDeleteId(this)"
                                        data-delete="{{$bookings->booking_id }}"
                                >Cancel Event</button>
                            </div>

                            <!-- Right: Event Image -->
                            <div class="w-1/2 pl-4 border-l-2 border-gray-300">
                                <img src="{{ $bookings->event->image_url }}" alt="Event Image" class="w-full h-auto object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif

            </div>


        </div>
    </div>


    <form id="deleteform" method="post" action="/deleteBooking">
        @csrf
        @method('DELETE')

        <input type="hidden" id="delete_event" name="delete_event" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

    </form>

    <!--event booking form
    <form action="/booking-event" method="post" id="booking-event-form">


        <input type="hidden" id="eventid" name="eventid" class="w-full p-2 border rounded-md" placeholder="Category Name" required>

    </form> -->

    <form action="/session" method="POST" id="booking-event-form">
        <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="eventid" name="eventid" class="w-full p-2 border rounded-md" placeholder="Category Name" required>
        <button class="btn btn-success" type="submit" id="checkout-live-button"><i class="fa fa-money"></i> Checkout</button>
    </form>




    <!-- Modal for Editing Event -->
    <!-- Modal code remains unchanged -->

    <!-- JavaScript -->
    <script>
        // Open the Create Event modal
        function openCreateEventModal() {
            document.getElementById('create-event-modal').classList.remove('hidden');
            showEventDetailsForm();
        }

        // Close the Create Event modal
        function closeCreateEventModal() {
            document.getElementById('create-event-modal').classList.add('hidden');
        }

        // Show the Event Details form after filling out the Category form
        function showEventDetailsForm() {

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

            const eventid = button.getAttribute('data-eventid');

            document.getElementById('eventid').value = eventid;

        }

        // Function to pass the event id for deletion
        function passDeleteId(button) {
            var deleteId = button.getAttribute('data-delete');

           document.getElementById('delete_event').value = deleteId;
            document.getElementById('deleteform').submit();

            alert("You have cancelled your booking, please check your emails.");
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
