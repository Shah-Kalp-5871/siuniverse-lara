<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code - SIU UNIVERSE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f4f8; }
        .wrapper { max-width: 560px; margin: 40px auto; padding: 20px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); padding: 36px 32px; text-align: center; }
        .header-icon { display: inline-block; background: rgba(255,255,255,0.2); border-radius: 50%; width: 64px; height: 64px; line-height: 64px; font-size: 28px; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: -0.3px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; margin-top: 6px; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 15px; color: #374151; margin-bottom: 16px; }
        .otp-label { font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 12px; }
        .otp-box { background: linear-gradient(135deg, #eff6ff 0%, #eef2ff 100%); border: 2px solid #c7d2fe; border-radius: 12px; padding: 24px; text-align: center; margin-bottom: 24px; }
        .otp-code { font-size: 42px; font-weight: 800; letter-spacing: 10px; color: #3b82f6; font-family: 'Courier New', monospace; }
        .expiry-note { background: #fff7ed; border-left: 4px solid #f97316; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 13px; color: #9a3412; margin-bottom: 20px; }
        .expiry-note strong { color: #c2410c; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
        .security-note { font-size: 12px; color: #9ca3af; line-height: 1.6; }
        .footer { background: #f9fafb; padding: 20px 32px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 12px; color: #9ca3af; }
        .footer .brand { font-weight: 700; color: #3b82f6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <!-- Header -->
            <div class="header">
                <div class="header-icon">🎓</div>
                <h1>SIU UNIVERSE</h1>
                <p>Email Verification</p>
            </div>

            <!-- Body -->
            <div class="body">
                <p class="greeting">Hello! You're just one step away from joining the SIU UNIVERSE community.</p>

                <p class="otp-label">Your Verification Code</p>
                <div class="otp-box">
                    <div class="otp-code">{{ $otp }}</div>
                </div>

                <div class="expiry-note">
                    ⏱ This code is valid for <strong>5 minutes</strong> only. Do not share it with anyone.
                </div>

                <hr class="divider">

                <p class="security-note">
                    If you did not attempt to sign up for SIU UNIVERSE, please ignore this email. 
                    This code was requested from our signup page. Your account will not be created unless you enter this code.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>© {{ date('Y') }} <span class="brand">SIU UNIVERSE</span> · Symbiosis International University</p>
                <p style="margin-top:4px;">This is an automated message, please do not reply.</p>
            </div>
        </div>
    </div>
</body>
</html>
