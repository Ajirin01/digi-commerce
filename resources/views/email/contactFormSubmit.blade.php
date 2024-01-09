<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>

    <p><strong>Name:</strong> {{ $messageData['name'] }}</p>
    <p><strong>Email:</strong> {{ $messageData['email'] }}</p>

    @if (!empty($messageData['subject']))
        <p><strong>Subject:</strong> {{ $messageData['subject'] }}</p>
    @endif

    @if (!empty($messageData['message']))
        <p><strong>Message:</strong> {{ $messageData['message'] }}</p>
    @endif
</body>
</html>
