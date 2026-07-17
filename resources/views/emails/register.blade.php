<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ResiliMart</title>
</head>

<body style="margin:0; padding:0; background-color:#eef2f1; font-family: 'Inter', Arial, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef2f1; padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="620" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 20px 50px rgba(20,51,47,0.10);">

                    <!-- Top accent bar -->
                    <tr>
                        <td style="height:6px; background:linear-gradient(90deg,#14b8a6,#0d9488,#14332f);"></td>
                    </tr>

                    <!-- Logo header -->
                    <tr>
                        <td style="padding:36px 40px 24px; text-align:center; background-color:#0b0f0e;">
                            <img src="{{ asset('images/resilimart-white.png') }}" alt="ResiliMart" width="150" style="display:block; margin:0 auto 10px;">
                            <p style="margin:0; color:#9ca3af; font-size:12px; letter-spacing:1.5px; text-transform:uppercase;">
                                Built to Break, Built to Improve
                            </p>
                        </td>
                    </tr>

                    <!-- Welcome ribbon -->
                    <tr>
                        <td style="padding:0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-color:#14332f; padding:14px 40px; text-align:center;">
                                        <span style="color:#5eead4; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                                            &#9733; Account Created
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Welcome message -->
                    <tr>
                        <td style="padding:44px 44px 8px;">
                            <h1 style="margin:0 0 10px; font-family:'Manrope', Arial, sans-serif; font-size:26px; font-weight:800; color:#0b0f0e; letter-spacing:-0.5px;">
                                Welcome, {{ $user->name }}
                            </h1>
                            <p style="margin:0; font-size:14.5px; color:#6b7280; line-height:1.7;">
                                Your ResiliMart account has been created successfully. You now have access to real-time supply chain risk monitoring, shipment tracking, and early warning alerts across your network.
                            </p>
                        </td>
                    </tr>

                    <!-- Account details card -->
                    <tr>
                        <td style="padding:28px 44px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f8f7; border-radius:12px; border:1px solid #eef1f0;">
                                <tr>
                                    <td style="padding:18px 22px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#6b7280; padding:6px 0;">Name</td>
                                                <td style="font-size:13px; font-weight:700; color:#0b0f0e; text-align:right; padding:6px 0;">{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#6b7280; padding:6px 0;">Email</td>
                                                <td style="font-size:13px; font-weight:700; color:#0b0f0e; text-align:right; padding:6px 0;">{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#6b7280; padding:6px 0;">Joined</td>
                                                <td style="font-size:13px; font-weight:700; color:#0b0f0e; text-align:right; padding:6px 0;">{{ $user->created_at->format('d M Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- What's next -->
                    <tr>
                        <td style="padding:32px 44px 8px;">
                            <p style="margin:0 0 16px; font-size:11.5px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:1px;">
                                Get Started
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:12px 0; border-bottom:1px solid #f0f2f1;">
                                        <p style="margin:0; font-size:14px; font-weight:600; color:#0b0f0e;">Browse products</p>
                                        <p style="margin:2px 0 0; font-size:12.5px; color:#9ca3af;">Explore our full catalog and find what you're looking for.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; border-bottom:1px solid #f0f2f1;">
                                        <p style="margin:0; font-size:14px; font-weight:600; color:#0b0f0e;">Track your orders</p>
                                        <p style="margin:2px 0 0; font-size:12.5px; color:#9ca3af;">Get real-time updates on order status and delivery progress.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;">
                                        <p style="margin:0; font-size:14px; font-weight:600; color:#0b0f0e;">Manage your account</p>
                                        <p style="margin:2px 0 0; font-size:12.5px; color:#9ca3af;">Save addresses and view your order history anytime.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA — black button -->
                    <tr>
                        <td style="padding:28px 44px 44px; text-align:center;">
                            <a href="{{ url('/') }}" style="display:inline-block; background-color:#0b0f0e; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700; padding:16px 42px; border-radius:10px; letter-spacing:0.3px;">
                                Start Shopping
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f6f8f7; padding:28px 44px; text-align:center; border-top:1px solid #eef1f0;">
                            <p style="margin:0 0 6px; font-size:12px; font-weight:700; color:#0b0f0e;">ResiliMart</p>
                            <p style="margin:0; font-size:11.5px; color:#9ca3af;">
                                &copy; {{ date('Y') }} ResiliMart. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>