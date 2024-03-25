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


                <table style="padding: 15px 0px;background:#ffffff;border-width:1px;border-style:solid;border-color:#e6e6e6;max-width:500px;min-width:320px;text-align:left;width:100%" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
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
                                    <td style="">

                                        <table style="width:100%" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 600;font-size:16px;">
                                                    <span style="color:#fc064c;"><span style="color:#999;">Hi</span> {{ $user->name }}</span>
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
                                                <td style="color: #818181; font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;">
                                                    Now that you have joined 1Platform TV, you are probably wondering what you can do?<br><br>Well not to worry, click the buttons to find out.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: center;" align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2013.png')}}"><br><br>
                                                                <div style="padding: 5px; border: 1px solid #818181; border-radius: 5px;">
                                                                    <a style="text-decoration: none; color: #818181;" href="{{route('agency.dashboard.tab', ['tab' => 'management-plan'])}}">
                                                                        Start Your Project List
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: center;" align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2014.png')}}"><br><br>
                                                                <div style="padding: 5px; border: 1px solid #818181; border-radius: 5px;">
                                                                    <a style="text-decoration: none; color: #818181;" href="{{route('agency.dashboard.tab', ['tab' => 'contact-management'])}}">
                                                                        Create Your Network
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: center;" align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2015.png')}}"><br><br>
                                                                <div style="padding: 5px; border: 1px solid #818181; border-radius: 5px;">
                                                                    <a style="text-decoration: none; color: #818181;" href="{{route('profile.setup', ['page' => 'crowdfunding'])}}">
                                                                        Start A Crowdfunding Project
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: center;" align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2016.png')}}"><br><br>
                                                                <div style="padding: 5px; border: 1px solid #818181; border-radius: 5px;">
                                                                    <a style="text-decoration: none; color: #818181;" href="{{route('profile.setup.standalone', ['page' => 'music'])}}">
                                                                        Sell music & licences
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: center;" align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2017.png')}}"><br><br>
                                                                <div style="padding: 5px; border: 1px solid #818181; border-radius: 5px;">
                                                                    <a style="text-decoration: none; color: #818181;" href="{{route('profile.setup.standalone', ['page' => 'product'])}}">
                                                                        Sell tickets for your gigs
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: center;" align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2018.png')}}"><br><br>
                                                                <div style="padding: 5px; border: 1px solid #818181; border-radius: 5px;">
                                                                    <a style="text-decoration: none; color: #818181;" href="{{route('agency.dashboard')}}">
                                                                        And much more exciting stuff
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
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
