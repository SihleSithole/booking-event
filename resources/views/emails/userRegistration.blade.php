<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h1>Welcome, {{ $user->name }}!</h1>
<p>Thank you for registering at {{ config('app.name') }}.</p>
<p>Reach out to the team.</p>
<p>Best regards,</p>
<p>The {{ config('app.name') }} Team</p>
</body>
</html>
