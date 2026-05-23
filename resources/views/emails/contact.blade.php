<!DOCTYPE html>
<html>
<head>
    <title>New Portfolio Message</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>You have a new message from your portfolio!</h2>
    
    <p><strong>Name:</strong> {{ $contactData['name'] }}</p>
    <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
    
    <p><strong>Message:</strong></p>
    <p style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
        {{ $contactData['message'] }}
    </p>
</body>
</html>