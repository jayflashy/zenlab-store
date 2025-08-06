<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style type="text/css">
        /* Reset styles for email clients */
        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* Client-specific styles */
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        /* Media queries for mobile */
        @media screen and (max-width: 600px) {
            .mobile-center {
                text-align: center !important;
            }

            .mobile-padding {
                padding: 15px !important;
            }

            .mobile-font-size {
                font-size: 16px !important;
            }

            .mobile-button {
                width: 100% !important;
                display: block !important;
            }
        }
    </style>
</head>

@php
    $setting = get_setting();
@endphp

<body style="margin: 0; padding: 0; background-color: #f8fffe; font-family: Arial, sans-serif;">

    <!-- Wrapper Table -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
        style="background-color: #f8fffe;">
        <tr>
            <td align="center" style="padding: 20px 10px;">

                <!-- Main Email Table -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.12);">

                    <!-- Header Section -->
                    <tr>
                        <td
                            style="background-color: #0d6efd; padding: 40px 30px; text-align: center; background-image: linear-gradient(135deg, #0d6efd 0%, #2230c5 100%); background-repeat: no-repeat;">
                            <!--[if gte mso 9]>
                            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;height:140px;">
                            <v:fill type="gradient" color="#0d6efd" color2="#2230c5" angle="135" />
                            <v:textbox inset="0,0,0,0">
                            <![endif]-->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <!-- Logo Container -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td
                                                    style="background-color: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; text-align: center; border: 2px solid rgba(255,255,255,0.2);">
                                                    <img src="{{ my_asset($setting->logo) }}" alt="Logo"
                                                        height="32"
                                                        style="display: block; height: 32px; width: auto;">
                                                </td>
                                                <td
                                                    style="padding-left: 15px; color: #ffffff; font-size: 24px; font-weight: bold; line-height: 1.2;">
                                                    {{ $setting->name }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!--[if gte mso 9]>
                            </v:textbox>
                            </v:rect>
                            <![endif]-->
                        </td>
                    </tr>

                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 50px 40px; background-color: #ffffff;">

                            <!-- Subject Line -->
                            <h1
                                style="margin: 0 0 30px 0; color: #0d5097; font-size: 28px; font-weight: bold; line-height: 1.3; text-align: left;">
                                {{ $data['subject'] }}
                            </h1>

                            <!-- Greeting -->
                            @if (isset($data['name']) && $data['name'] != '')
                                <p
                                    style="margin: 0 0 25px 0; font-size: 18px; color: #374151; font-weight: 500; line-height: 1.5;">
                                    Hi {{ $data['name'] ?? '' }},
                                </p>
                            @endif

                            <!-- Message Box -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="margin: 30px 0;">
                                <tr>
                                    <td
                                        style="background-color: #f0fdf4; 
                                        border: 2px solid #bbd1f7; 
                                        border-left: 6px solid #2230c5; border-radius: 8px; padding: 30px;">
                                        <div style="color: #0d5097; font-size: 16px; line-height: 1.6; margin: 0;">
                                            {!! $data['message'] !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            @if (isset($data['link']) && isset($data['link_text']))
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                    style="margin: 40px 0;">
                                    <tr>
                                        <td align="center">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td
                                                        style="background-color: #0d6efd; border-radius: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);">
                                                        <!--[if mso]>
                                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" style="height:48px;v-text-anchor:middle;width:200px;" arcsize="17%" fill="t" stroke="f" fillcolor="#0d6efd">
                                                    <v:fill type="solid" color="#0d6efd" />
                                                    <v:textbox inset="0,0,0,0">
                                                    <![endif]-->
                                                        <a href="{{ $data['link'] }}"
                                                            style="background-color: #0d6efd; border: none; color: #ffffff; display: inline-block; font-size: 16px; font-weight: bold; line-height: 48px; text-align: center; text-decoration: none; width: 200px; border-radius: 8px; padding: 0 20px;">
                                                            {{ $data['link_text'] }}
                                                        </a>
                                                        <!--[if mso]>
                                                    </v:textbox>
                                                    </v:roundrect>
                                                    <![endif]-->
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <!-- Divider -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="margin: 40px 0 30px 0;">
                                <tr>
                                    <td height="1"
                                        style="background-color: #d1dafa; line-height: 1px; font-size: 1px;">&nbsp;</td>
                                </tr>
                            </table>

                            <!-- Signature -->
                            <p style="margin: 0; font-size: 16px; color: #6b7280; line-height: 1.6;">
                                Best regards,<br>
                                <strong style="color: #0d5097;">The {{ $setting->name }} Team</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 40px 30px; border-top: 1px solid #e5e7eb; text-align: center;">

                            <!-- Company Name -->
                            <p
                                style="margin: 0 0 15px 0; font-size: 20px; font-weight: bold; color: #0d5097; line-height: 1.3;">
                                {{ $setting->name }}
                            </p>

                            <!-- Contact Info -->
                            <p style="margin: 0 0 10px 0; font-size: 15px; color: #6b7280; line-height: 1.5;">
                                {{ $setting->phone }} |
                                <a href="mailto:{{ $setting->admin_email }}"
                                    style="color: #0d6efd; text-decoration: none; font-weight: 500;">
                                    {{ $setting->admin_email }}
                                </a>
                            </p>

                            <!-- Copyright -->
                            <p style="margin: 0 0 25px 0; font-size: 14px; color: #6b7280; line-height: 1.5;">
                                © {{ date('Y') }} {{ $setting->title }}. All rights reserved.
                            </p>

                            <!-- Divider -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="margin: 25px 0;">
                                <tr>
                                    <td height="1"
                                        style="background-color: #e5e7eb; line-height: 1px; font-size: 1px;">&nbsp;
                                    </td>
                                </tr>
                            </table>

                            <!-- Unsubscribe -->
                            <p style="margin: 0; font-size: 13px; color: #9ca3af; line-height: 1.6;">
                                You're receiving this because you're a user at {{ $setting->name }}.<br>
                                <a href="#"
                                    style="color: #0d6efd; text-decoration: none; font-weight: 500;">Unsubscribe</a> |
                                <a href="#"
                                    style="color: #0d6efd; text-decoration: none; font-weight: 500;">Privacy Policy</a>
                            </p>

                        </td>
                    </tr>

                </table>
                <!-- End Main Email Table -->

            </td>
        </tr>
    </table>
    <!-- End Wrapper Table -->

</body>

</html>
