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
                                                <td align="center">
                                                    <img src="{{asset('email-template-images/new/Asset%2063.png')}}">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="line-height: 0;" height="5">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #818181; font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;">
                                                    Your project ended on <span style="color: #fc064c; font-weight: 600;">{{date('d/m/Y')}}.</span> However your project did not hit its target goal.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-size:14px; font-weight: 600;">
                                                    What Happens Now?
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;">
                                                    The funds for your project will be returned to your project supporters. (This does not apply to charity and flexible projects)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;">
                                                    You will be unable to edit your current project, however you can start a new project on your 1Platform profile page. 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;">
                                                    When starting a new project, a new and exciting idea will always attract followers.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="cursor: pointer; padding: 3px;background: #737373;color: #fff;font-family: Open Sans,sans-serif;border-radius: 5px;font-size: 15px;">
                                                    <a style="color: #fff;text-decoration: none;" href="{{route('profile')}}?page=crowdfunds">
                                                    Start My Brand New Project  
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