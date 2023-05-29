<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
<style>@import url('https://fonts.googleapis.com/css?family=Open+Sans');</style>
<div bgcolor="#E5EDF6" style="background:#f6f5f2;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">







    <table style="margin-top:0;text-align:center;width:100%" width="100%" cellspacing="0" cellpadding="0" bgcolor="#999999" align="center">
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
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:17px;">
                                                    <span style="color:#fc064c;">Hi {{ $customer->name }}</span>
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
                                                <td style="color:#8c8c8c;font-family:Open Sans,sans-serif;font-weight: 500;font-size:11px">
                                                    <span style="color:#fc064c;">{{$user->name}}</span> has added a product for you
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>
                                            @if(isset($chat->product['id']))
                                                @php $product = \App\Models\UserProduct::find($chat->product['id']) @endphp
                                            @if($product)
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 100%; font-size: 13px; margin-bottom: 5px; font-weight: bold; float: left;">
                                                        Title
                                                    </span>
                                                    <span style="width: 100%; color:#8c8c8c; float: left;">
                                                        {{$product->title}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 100%; font-size: 13px; margin-bottom: 5px; font-weight: bold; float: left;">
                                                        Price
                                                    </span>
                                                    <span style="width: 100%; color:#8c8c8c; float: left;">
                                                        {{$chat->product['price']}}{{strtoupper($user->profile->default_currency)}}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif
                                            @endif

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center">

                                                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:16px;" align="left">
                                                                    <a href="{{route('profile.with.tab',['tab' => 'chat'])}}"><button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">View / Reply</button></a>
                                                                </td>
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