<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
<style>@import url('https://fonts.googleapis.com/css?family=Open+Sans');</style>
<div bgcolor="#E5EDF6" style="background:#f6f5f2;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">




    @php $commonMethods = new \App\Http\Controllers\CommonMethods() @endphp


    <table style="margin-top:0;text-align:center;width:100%" width="100%" cellspacing="0" cellpadding="0" bgcolor="#737373" align="center">
        <tbody>
        <tr>
            <td style="min-width:8px"></td>
            <td height="30px">&nbsp; </td>
            <td style="min-width:8px"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr>
                        <td style="text-align:left" align="left">
                            <a style="margin: 0 auto 10px auto; font-size: 15px; color: #000; font-family: Open sans, sans-serif; letter-spacing: 1px; display: flex; align-items: center; text-decoration: none;" class="logo8" href="{{route('site.home')}}">
                                <img style="height: 22px;margin: 0 6px 0 0 !important;" src="https://www.1platform.tv/images/1logo8.png" alt="">
                                <div>Platform</div>
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
            <td style="text-align:center" width="500" align="center">


                <table style="padding: 15px 30px;background:#ffffff;border-width:1px;border-style:solid;border-color:#e6e6e6;max-width:500px;min-width:320px;text-align:left;width:100%" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
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
                                    <td style="width: 90%;">

                                        <table style="width:100%" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>

                                            <tr>
                                                <td height="60">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="line-height:100px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:70px;" align="center">
                                                    {{$commonMethods->getCurrencySymbol($checkout->currency).$checkout->amount}}
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
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;color: #818181; font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;">
                                                    You have received {{$commonMethods->getCurrencySymbol($checkout->currency).$checkout->amount}} support from <br><br>
                                                    <a style="text-decoration: none;" href="{{$checkout->customer->username ? route('user.home', ['params' => $checkout->customer->username]) : 'javascript:void(0)'}}"><span style="color: #fc064c; font-weight: 600;">{{$checkout->customer->name}}</span>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#fc064c;font-family:Open Sans,sans-serif;font-size:15px; font-weight: 600; text-align: center;">
                                                    <img src="{{asset('email-template-images/new/Asset%206.png')}}">
                                                    <a style="color: #fff;text-decoration: none;" href="{{route('user.project.auto.share', ['username' => $checkout->user->username, 'type' => 'facebook_url'])}}">
                                                        <img style="margin-left: -5px;" src="{{asset('email-template-images/new/Asset%208.png')}}">
                                                    </a>
                                                    <a style="color: #fff;text-decoration: none;" href="{{route('user.project.auto.share', ['username' => $checkout->user->username, 'type' => 'twitter_url'])}}">
                                                        <img style="margin-left: -5px;" src="{{asset('email-template-images/new/Asset%207.png')}}">
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    Music licences and digital products have been automatically sent to the buyer.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    It is your responsibility to deliver any physical goods (if applicable)
                                                </td>
                                            </tr>


                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    You must own the rights to any music you have sold and are bound by the conditions of licencing agreement.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    Each transaction is an agreement between the seller and the buyer and 1Platform has no part in this agreement.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    Please see terms and conditions for further details.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    Purchaser details can be found in 'My Sales and Purchases' section.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                            <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:16px;" align="left">
                                                    <a href="{{route('agency.dashboard')}}">
                                                        <button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">
                                                            <a style="color: #fff;text-decoration: none;" href="{{route('agency.dashboard')}}">
                                                                View my sales & purchases
                                                            </a>
                                                        </button>
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
