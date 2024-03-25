<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
<div bgcolor="#E5EDF6" style="background:#f6f5f2;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">







    <table style="margin-top:0;text-align:center;width:100%" width="100%" cellspacing="0" cellpadding="0" bgcolor="#E5EDF6" align="center">
        <tbody>
        <tr>
            <td style="min-width:8px"></td>
            <td height="18px">&nbsp;</td>
            <td style="min-width:8px"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr>
                        <td style="text-align:left" align="left">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/1logo5.png') }}" style="border:none" class="CToWUd" width="140" border="0">
                            </a>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td height="23px">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="text-align:center" width="500" align="center">


                <table style="background:#ffffff;border-width:1px;border-style:solid;border-color:#e6e6e6;border-radius:5px 5px 5px 5px;max-width:500px;min-width:320px;text-align:left;width:100%" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
                    <tbody>
                    <tr>
                        <td>

                            <table style="width:100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tbody>

                                <tr>
                                    <td width="14">&nbsp;</td>
                                    <td height="31">&nbsp;</td>
                                    <td width="14">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>

                                        <table style="width:100%" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>

                                            <tr>
                                                <td style="color:#9daec3;font-family:Helvetica,Arial,sans-serif;font-size:60px" align="center">
                                                    <span>{{$currencySymbol.number_format($amount, 2)}}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="center">

                                                    <table cellspacing="0" cellpadding="0" border="0" align="center">
                                                        <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td width="290">

                                                                <table style="width:100%;max-width:290px" cellspacing="0" cellpadding="0" border="0" align="center">
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>

                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td height="25">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#9daec3;font-family:Helvetica,Arial,sans-serif;font-size:16px" align="center">
                                                    You just received {{$currencySymbol.number_format($amount, 2)}} support from
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="18">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:16px;" align="center">
                                                    <a href="#" style="text-decoration:none;text-decoration:none!important" target="_blank" data-saferedirecturl=""><span style="color:#f95753;">{{ $sender->name }}</span></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="25">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td align="center">

                                                    <table cellspacing="0" cellpadding="0" border="0" align="center">
                                                        <tbody>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td width="320">

                                                                <table style="width:100%;max-width:320px" cellspacing="0" cellpadding="0" border="0" align="center">
                                                                    <tbody>
                                                                    <tr>


                                                                        <td style="width:100%" valign="middle" height="52" align="center">

                                                                            <a href="{{ route('agency.dashboard') }}" style="text-decoration:none" target="_blank" data-saferedirecturl=""><img src="{{ asset('email-template-images/thanks-button-with-alfie.png') }}" style="width: 300px;"></a>

                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td align="center">

                                                    <table cellspacing="0" cellpadding="0" border="0" align="center">
                                                        <tbody>
                                                        <tr>
                                                            <td height="25">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td style="color:#9daec3;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:24px;width:100%" align="center">
                                                                Be sure to enter 1Platform Chart this week<br>its easy to do
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="25">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td width="320" align="center">
                                                                <?php $email = explode("@", $receiver->email)?>
                                                                <table style="width:100%;max-width:320px" cellspacing="0" cellpadding="0" border="0" align="center">
                                                                    <tbody>
                                                                    <tr>

                                                                        <td style="text-align:center" align="center">
                                                                            <a href="{{ $asset . "/" . $email[0] }}" target="_blank" data-saferedirecturl="#">
                                                                                <img src="{{ asset('email-template-images/percent-blue.png') }}" style="border:none" class="CToWUd" width="50" border="0">
                                                                            </a>
                                                                        </td>

                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>


                                            </tbody>
                                        </table>

                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                </tbody>
                            </table>


                        </td>
                    </tr>


                    <tr>
                        <td>

                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                    <td width="14">&nbsp;</td>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td height="30">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#9daec3;font-family:Helvetica,Arial,sans-serif;line-height:25px;font-size:14px;text-align:center">

                                                                <span style="color:#9daec3;">Your project is here<span> <a href="{{ $asset . "/" . $email[0] }}" style="color:#f95753;font-family:Helvetica,Arial,sans-serif;line-height:25px;font-size:14px;text-decoration:none;text-decoration:none!important" target="_blank" data-saferedirecturl="">{{ $asset . "/" . $email[0] }}</span></a><br>
                                                                <p style="color:#9daec3;">Share your success on social media</p>
                                                                <p><a href="{{Config::get('constants.facebook_profile')}}"><img src="{{asset('email-template-images/facebook.png')}}" width="25"></a>
                                                                <a href="{{Config::get('constants.instagram_profile')}}"><img src="{{asset('email-template-images/instagram.png')}}" width="25"></a>
                                                                <a href="{{Config::get('constants.twitter_profile')}}"><img src="{{asset('email-template-images/twitter.png')}}" width="25"></a></p>
                                                                <p style="color:#9daec3;">Do you want these emails?</p>
                                                                <a href="#" style="text-decoration: underlined; color: #fca829;">Unsubscribe</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="14">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>

                    </tbody>
                </table>
            </td>
            <td></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td height="70"></td>
            <td>&nbsp;</td>
        </tr>

        </tbody>
    </table>
</div>
</body>
</html>
