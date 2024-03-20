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
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    Well done! Your project <span style="font-weight: 600;">{{$campaign->title}}</span> is now live.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="12">&nbsp;</td>
                                            </tr>
                                            
                                            <tr>
                                                <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px" align="left">
                                                    You can view it on here: <a href="{{'https://www.1platform.tv/project/'.$user->username}}">https://www.1platform.tv/project/{{ $user->username }}</a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    You can now achieve your project goal - And here is how you do it
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    1 - Let your family and friends know about your doing
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    If you are trying to start a project, its good idea to tell everyone you know what you are doing. You may know some musicians who may benefit from your idea. Be sure they tell everyone where to find your project so they can support you.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    2 - Time to tell the world your project is happening!
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    Once you have told everyone you know about your project, tell everyone else. Social media is the greatest tool at your disposal.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center">
                                                    <a style="text-align: center; font-size: 13px; display: inline-block; background: rgb(52, 32, 133); color: #fff; border-radius: 2px; padding: 8px; cursor: pointer; text-decoration: none; border: 1px solid rgb(52, 32, 133);" href="{{route('user.project.auto.share', ['username' => $user->id, 'type' => 'facebook_url'])}}">
                                                        <i class="fa-brands fa-facebook-f"></i>
                                                        Facebook
                                                        <!-- <img src="https://www.1platform.tv/email-template-images/new/Asset_4.png"> -->
                                                    </a>
                                                    <a style="text-align: center; font-size: 13px; display: inline-block; background: rgb(12, 156, 240); color: #fff; border-radius: 2px; padding: 8px; cursor: pointer; text-decoration: none; border: 1px solid rgb(12, 156, 240);" href="{{route('user.project.auto.share', ['username' => $user->id, 'type' => 'twitter_url'])}}">
                                                        <i class="fab fa-twitter"></i>
                                                        Twitter
                                                        <!-- <img src="https://www.1platform.tv/email-template-images/new/Asset_5.png"> -->
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #fc064c;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    3 - Interact with your supporters and post updates
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color: #818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px;" align="left">
                                                    If you don't keep people updated on your project then it will look like nothing is happening. Talk to your supporters make a video thanking them.
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