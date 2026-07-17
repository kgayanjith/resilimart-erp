<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
</head>

<body style="margin:0; padding:0; background-color:#eef2f1; font-family: 'Inter', Arial, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef2f1; padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="620" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 20px 50px rgba(20,51,47,0.10);">

                  

                    <!-- Logo header -->
                    <tr>
                        <td style="padding:36px 40px 24px; text-align:center; background-color:#0b0f0e;">
                           <img src="{{ asset('images/resilimart-white.png') }}" alt="ResiliMart" width="150" style="display:block; margin:0 auto 10px;">
                            <p style="margin:0; color:#9ca3af; font-size:12px; letter-spacing:1.5px; text-transform:uppercase;">
                                Built to Break, Built to Improve
                            </p>
                        </td>
                    </tr>

                    <!-- Status ribbon -->
                    <tr>
                        <td style="padding:0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-color:#14332f; padding:14px 40px; text-align:center;">
                                        <span style="color:#5eead4; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                                            &#10003; Order Received
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Confirmation message -->
                    <tr>
                        <td style="padding:44px 44px 8px;">
                            <h1 style="margin:0 0 10px; font-family:'Manrope', Arial, sans-serif; font-size:26px; font-weight:800; color:#0b0f0e; letter-spacing:-0.5px;">
                                Thanks for your order
                            </h1>
                            <p style="margin:0; font-size:14.5px; color:#6b7280; line-height:1.7;">
                                Hi {{ $order->customer->name }}, we've got your order and it's already moving through processing. Here's a summary of what you ordered.
                            </p>
                        </td>
                    </tr>

                    <!-- Order meta cards -->
                    <tr>
                        <td style="padding:28px 44px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="33%" style="padding-right:8px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f8f7; border-radius:12px; border:1px solid #eef1f0;">
                                            <tr>
                                                <td style="padding:16px 14px; text-align:center;">
                                                    <p style="margin:0 0 4px; font-size:10.5px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.6px;">Order No.</p>
                                                    <p style="margin:0; font-size:14px; font-weight:700; color:#0b0f0e;">#{{ $order->order_number }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="34%" style="padding:0 4px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f8f7; border-radius:12px; border:1px solid #eef1f0;">
                                            <tr>
                                                <td style="padding:16px 14px; text-align:center;">
                                                    <p style="margin:0 0 4px; font-size:10.5px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.6px;">Date</p>
                                                    <p style="margin:0; font-size:14px; font-weight:700; color:#0b0f0e;">{{ $order->created_at->format('d M Y') }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="33%" style="padding-left:8px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f8f7; border-radius:12px; border:1px solid #eef1f0;">
                                            <tr>
                                                <td style="padding:16px 14px; text-align:center;">
                                                    <p style="margin:0 0 4px; font-size:10.5px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.6px;">Status</p>
                                                    <p style="margin:0; font-size:14px; font-weight:700; color:#0d9488; text-transform:capitalize;">{{ $order->status }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding:32px 44px 0;">
                            <p style="margin:0 0 16px; font-size:11.5px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:1px;">
                                Order Summary
                            </p>
                        </td>
                    </tr>

                    <!-- Order items -->
                    <tr>
                        <td style="padding:0 44px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                @foreach ($order->orderItems as $item)
                                <tr>
                                    <td style="padding:14px 0; border-bottom:1px solid #f0f2f1;">
                                        <p style="margin:0; font-size:14px; font-weight:600; color:#0b0f0e;">{{ $item->product_name }}</p>
                                        <p style="margin:2px 0 0; font-size:12.5px; color:#9ca3af;">Qty {{ $item->quantity }}</p>
                                    </td>
                                    <td style="padding:14px 0; border-bottom:1px solid #f0f2f1; text-align:right; vertical-align:top;">
                                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b0f0e;">Rs {{ number_format($item->line_total, 2) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Totals -->
                    <tr>
                        <td style="padding:20px 44px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-size:13.5px; color:#6b7280; padding:5px 0;">Subtotal</td>
                                    <td style="font-size:13.5px; color:#0b0f0e; text-align:right; padding:5px 0;">Rs {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13.5px; color:#6b7280; padding:5px 0;">Shipping</td>
                                    <td style="font-size:13.5px; color:#0b0f0e; text-align:right; padding:5px 0;">Rs 0.00</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13.5px; color:#6b7280; padding:5px 0;">Vat (18%)</td>
                                    <td style="font-size:13.5px; color:#0b0f0e; text-align:right; padding:5px 0;">Rs {{ number_format($order->vat_amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Total highlight bar -->
                    <tr>
                        <td style="padding:12px 44px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0b0f0e; border-radius:12px;">
                                <tr>
                                    <td style="padding:18px 22px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px; font-weight:600; color:#fff;">Total Paid</td>
                                                <td style="font-size:19px; font-weight:800; color:#fff; text-align:right;">Rs {{ number_format($order->total, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA — black button -->
                    <tr>
                        <td style="padding:0 44px 44px; text-align:center;">
                            <a href="{{ url('/orders/' . $order->id) }}" style="display:inline-block; background-color:#0b0f0e; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700; padding:16px 42px; border-radius:10px; letter-spacing:0.3px;">
                                View Order Details
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