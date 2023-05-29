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
                                                <td style="line-height: 0;" height="8">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    You haven't finished your project <span style="font-weight: bold;">{{$user->campaign() ? $user->campaign()->title : ''}}</span>. Once you have finished your campaign you will be able to achieve your project goals and raise the funds you need to bring your music to life.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:16px;" align="left">
                                                    Here is why you should finish your project
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    <table>
                                                        <tr>
                                                            <td align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2038.png')}}">
                                                            </td>
                                                            <td style="padding-left: 15px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: left;" align="right">
                                                                90% of the users are more likely to interact with your music. If you have a project users are more likely to interact with your page and will convince them to stick around your channel longer.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    <table>
                                                        <tr>
                                                            <td align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2037.png')}}">
                                                            </td>
                                                            <td style="padding-left: 15px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: left;" align="right">
                                                                1Platform TV is free to use website that allows you to make money from your music.<br><br>
                                                                That album or song you've always wanted to create could become a reality.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    <table>
                                                        <tr>
                                                            <td align="left">
                                                                <img src="{{asset('email-template-images/new/Asset%2036.png')}}">
                                                            </td>
                                                            <td style="padding-left: 26px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: left;" align="right">
                                                                You probably have a great idea for a project. Something new and unique. If you ae struggling for ideas see what other users are doing on 1Platform.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                            <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:16px;" align="left">
                                                    <a href="{{route('profile')}}">
                                                        <button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">
                                                            <a style="color: #fff;text-decoration: none;" href="{{route('profile')}}?page=crowdfunds">
                                                                Edit My Project
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