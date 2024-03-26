<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
<style>@import url('https://fonts.googleapis.com/css?family=Open+Sans');</style>
<div bgcolor="#E5EDF6" style="background:#f6f5f2;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">



    @php $commonMethods = new \App\Http\Controllers\CommonMethods() @endphp



    <table style="margin-top:0;text-align:center;width:100%" width="100%" cellspacing="0" cellpadding="0" bgcolor="#999999" align="center">
        <tbody>
        <tr>
            <td style="min-width:8px"></td>
            <td height="30px">&nbsp; </td>
            <td style="min-width:8px"></td>
        </tr>
        @if(!$checkout->user->isCotyso())
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
        @endif
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
                                    <td width="14">&nbsp;</td>
                                    <td>
                                        @if($checkout->user->isCotyso())
                                        <img width="200" src="{{asset('images/se_logo.jpg')}}">
                                        @endif
                                    </td>
                                    <td align="right" style="text-align:right;font-family:Open Sans,sans-serif;font-weight: 600;font-size:13px;" width="14">TSN_{{$checkout->id}}</td>
                                </tr>

                                <tr>
                                    <td width="14">&nbsp;</td>
                                    <td height="10">&nbsp;</td>
                                    <td width="14">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2" style="width: 90%;">

                                        <table style="width:100%" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 600;font-size:16px;">
                                                    <span style="color:#fc064c;"><span style="color:#999;">Hi admin</span></span>
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
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: 500;font-size:13px">
                                                    <span style="color:#fc064c; font-weight: 600;">{{$checkout->customer_name}}</span> has purchased the following print-on-demand merchandise from <span style="color:#fc064c; font-weight: 600;">{{$checkout->user->name}}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 28px;" align="left">
                                                    <span style="color:#818181; float: left;">Item </span>
                                                    <span style="color:#818181; float: right;">Price </span>
                                                </td>
                                            </tr>

                                            @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                                            @foreach($checkout->instantCheckoutItems as $checkoutItem)
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 70%; color:#8c8c8c; float: left;">
                                                        {{$checkoutItem->name}}
                                                        <br>
                                                        <span style="font-size: 10px; color: #000;">
                                                            (
                                                            {{$checkoutItem->quantity}}
                                                            @if($checkoutItem->size != 'None')
                                                             x {{$checkoutItem->size}}
                                                            @else
                                                             x
                                                            @endif
                                                            @if($checkoutItem->color != 'None')
                                                             {{$checkoutItem->color}}
                                                            @endif
                                                            )

                                                        </span>
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{($checkoutItem->price>0)?$currencySymbol.number_format($checkoutItem->price, 2):'Free'}}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                            <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:16px;" align="left">
                                                    <a href="{{route('agency.dashboard')}}">
                                                        <button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">
                                                            <a style="color: #fff;text-decoration: none;" href="https://www.duong.1platform.tv/admin/purchase/{{$checkout->id}}">
                                                                View details
                                                            </a>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
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
