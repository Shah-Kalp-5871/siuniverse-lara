<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        .otp {
            font-size: 36px;
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 5px;
            margin: 30px 0;
            padding: 15px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Authentication Required</h2>
        <p>You recently attempted to sign in to the SI UNIVERSE Admin Panel.</p>
        <p>Please use the following One-Time Password to complete your login:</p>
        
        <div class="otp">{{ $otp }}</div>
        
        <p>This code will expire in 5 minutes. If you did not request this code, please ignore this email.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} SI UNIVERSE. All rights reserved.
        </div>
    </div>
</body>
</html>
