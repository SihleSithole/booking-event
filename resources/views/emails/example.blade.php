
<!DOCTYPE html>
<html>
<head>
    <title>Event Booking Confirmation</title>
</head>
<body>
<h1>Event Booking Confirmation</h1>
<p>Hi {{ $booking->user->name }},</p>

<p>Thank you for booking the event <strong>{{ $booking->event->name }}</strong>!</p>

<p>Here are your booking details:</p>
<ul>
    <li><strong>Event:</strong> {{ $booking->event->name }}</li>
    <li><strong>Date:</strong> {{ $booking->event->date }}</li>
    <li><strong>Time:</strong> {{ $booking->event->time }}</li>
    <li><strong>Location:</strong> {{ $booking->event->location }}</li>
    <li><strong>Total Price:</strong> {{ $booking->event->ticket_price }}</li>
</ul>

<p>Thanks,<br>The {{ config('app.name') }} Team</p>
</body>
</html>
