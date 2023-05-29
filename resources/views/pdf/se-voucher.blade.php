<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        

        <style>
            table { width: 100% !important; }
        </style>
    </head>
    <body>

        <table align="center" style="width:100%;line-height:22px;" cellpadding="0" cellspacing="0" >
            <tr>
                <td style="width:100%;">
                    <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="width:100%;">
                                <img style="width:700px;" src="{{asset('images/singing/voucher_cover_2.jpeg')}}" />
                            </td>
                        </tr>
                    </table>
                    <table align="center" style="background-color:#e0eafb;padding:10px 10px 50px 10px;width:100%;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td align="top" style="width:50%;">
                                <img style="width:100px;" src="{{asset('images/singing/voucher_logo_2.png')}}" />
                            </td>
                            <td align="top" style="width:50%;vertical-align:bottom;text-align:left;">
                                <td style="vertical-align:top;"></td>
                            </td>
                        </tr>
                        <tr>
                            <td align="top" style="font-size:12px;width:50%;">
                                Thank you for purchasing a voucher from Singing Experiences. The UK's No 1 Recording Studios. Former hosts to One Direction, Blur, New Order and many others.
                            </td>
                            <td align="top" style="width:50%;vertical-align:top;">
                               <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td align="top" style="font-size:15px;width:100%;color:#000;text-align:center;">
                                            Please book your experience at the link below
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="font-size:15px;width:100%;color:#c3004d;text-align:center;">
                                            https://www.clients.singingexperience.co.uk
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="top" style="height:8px;width:50%;"></td>
                            <td align="top" style="height:8px;width:50%;"></td>
                        </tr>
                        <tr>
                            <td align="top" style="font-size:12px;width:50%;">
                                <ul style="margin-left:-30px;">
                                    <li>Some Slots are restricted and incur a prime time booking fee - &pound;55 </li>
                                    <li>Check your online booking calendar for individual availability </li>
                                    <li>For ay booking cancellations we require at least 2 weeks prior notice</li>
                                    <li>Please do not turn up early as we do not have a waiting area</li>
                                    <li>Bring as many friends and family members as you like, to watch your experience</li>
                                    <li>For singing/performance experiences bring your own printed lyrics/sheet</li>
                                    <li>Upgrades for this experience are available on our booking portal</li>
                                    <li>All bookings can be made through our booking portal. No phone line is available for booking</li>
                                    <li>All Vouchers expire after 8 months from purchase</li>
                                </ul>
                            </td>
                            <td align="top" style="font-size:15px;width:50%;vertical-align:top;color:#c3004d;text-align:center">
                                <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td align="top" style="width:100%;text-align:center;color:#000;">
                                            PERSONAL MESSAGE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;text-align:center;">
                                            {{str_limit($comment, 80)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;height:40px;"></td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;text-align:center;color:#000;">
                                            YOUR UNIQUE VOUCHER SECURITY CODE IS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="font-size:18px;width:100%;text-align:center;">
                                            {{$code}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;height:40px;"></td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;text-align:center;">
                                            (Please keep this code safe as you may need it in the future)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;height:40px;"></td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;text-align:center;color:#000">
                                            YOUR EXPERIENCE IS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="top" style="width:100%;text-align:center;">
                                            {{$experienceTitle}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>