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


                <table style="padding: 15px 60px;background:#ffffff;border-width:1px;border-style:solid;border-color:#e6e6e6;max-width:500px;min-width:320px;text-align:left;width:100%" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
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
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="center">
                                                    Well done! <span style="font-weight: 600;">Your project has been successfully funded</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="line-height:160px; color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:130px;" align="center">
                                                    100%
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="center">
                                                    Share your success and let people know that your project is ready to go
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="cursor: pointer; padding: 3px;background: #737373;color: #fff;font-family: Open Sans,sans-serif;border-radius: 5px;font-size: 15px;">
                                                    <a style="color: #fff;text-decoration: none;" href="{{route('user.project.auto.share', ['username' => $user->username, 'type' => 'facebook_url'])}}">
                                                    <img style="height: 12px;" src="{{asset('images/face_spec_icon.png')}}"> Share  
                                                    </a>                     
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="cursor: pointer; padding: 3px;background: #737373;color: #fff;font-family: Open Sans,sans-serif;border-radius: 5px;font-size: 14px;">
                                                    <a style="color: #fff;text-decoration: none;" href="{{route('user.project.auto.share', ['username' => $user->username, 'type' => 'twitter_url'])}}">
                                                    <img style="width: 14px;" src="{{asset('images/tw_icon.png')}}"> Tweet          
                                                    </a>                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
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