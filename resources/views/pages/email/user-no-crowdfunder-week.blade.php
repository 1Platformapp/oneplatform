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


                <table style="padding: 15px 20px;background:#ffffff;border-width:1px;border-style:solid;border-color:#e6e6e6;max-width:500px;min-width:320px;text-align:left;width:100%" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
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
                                                    Did you know on 1Platform platform you can create a fundraising project to achieve your musical dreams and ambitions<br><br>
                                                    Or you can help new and upcoming musicians with there fundraisers and projects
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:16px;" align="left">
                                                    How Do I Start My Project ?
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
                                                                <img src="{{asset('email-template-images/new/Asset%2024.png')}}">
                                                            </td>
                                                            <td style="padding-left: 20px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: left;" align="right">
                                                                With an 1Platform account starting a project is simple and easy.<br><br>Go to your profile and fill out the "Make your Project" section. You can even use this as the way of telling people about yourself if you don't want to start a project.
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
                                                                <img src="{{asset('email-template-images/new/Asset%2023.png')}}">
                                                            </td>
                                                            <td style="padding-left: 20px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: left;" align="right">
                                                                Be sure to be clear about your project so that potential supporters can see what you are trying to do and tell them why they should support your project.
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
                                                                <img src="{{asset('email-template-images/new/Asset%2021.png')}}">
                                                            </td>
                                                            <td style="padding-left: 20px; color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; text-align: left;" align="right">
                                                                Spread the word - make sure that people know about your project. Tell your family and friends through text, social media, or even word of mouth. Before you know it your project will be fully backed.
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
                                                            Start My Project
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