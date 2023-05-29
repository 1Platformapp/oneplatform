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

                                            @if(!$checkout->user->isCotyso())
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 600;font-size:16px;">
                                                    <span style="color:#fc064c;"><span style="color:#999;">Hi</span> {{ $checkout->user->name }}</span>
                                                </td>
                                            </tr>
                                            @endif
                                            
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
                                                    <span style="color:#fc064c; font-weight: 600;">{{$checkout->customer_name}}</span> has purchased the following items from you.
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
                                                        @if($checkoutItem->type == 'donation_goalless')
                                                            Donation
                                                        @else
                                                            {{$checkoutItem->name}}
                                                        @endif
                                                        
                                                        @if($checkoutItem->type == 'music')
                                                        <br>
                                                        <span style="font-size: 10px; color: #000;">
                                                            ({{$checkoutItem->license}})
                                                        </span>
                                                        @elseif($checkoutItem->type == 'custom-product')
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
                                                        @endif
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{($checkoutItem->price>0)?$currencySymbol.number_format($checkoutItem->price, 2):'Free'}}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if($checkout->stripeSubscription)
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 70%; color:#8c8c8c; float: left;">
                                                        Subscription
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$currencySymbol.number_format($checkout->stripeSubscription->plan_amount, 2)}} / month
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif

                                            @if($checkout->user->isCotyso())

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 28px;" align="left">
                                                    <span style="color:#818181; float: left;"><b>Purchase Details</b></span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Name
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->name}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Street
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->address}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Country 
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->country}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        City
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->city}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Postcode
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->postcode}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Comment
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {!! $checkout->comment !!}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Email
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->email}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Phone
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        {{$checkout->customer ? $checkout->customer->contact_number : 'N/A'}}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 20%; color:#8c8c8c; float: left;">
                                                        Type
                                                    </span>
                                                    <span style="color:#8c8c8c; float: right;">
                                                        Instant
                                                    </span>
                                                </td>
                                            </tr>

                                            @endif  
                                            
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    Music licences and digital products will be automatically sent to the buyer.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#818181;font-family:Open Sans,sans-serif;font-weight: normal;font-size:12px;" align="left">
                                                    It is your responsibility to deliver any physical goods (apart from print on demand products)
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
                                                    <a href="{{route('profile')}}">
                                                        <button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">
                                                            <a style="color: #fff;text-decoration: none;" href="{{route('profile')}}?page=orders">
                                                                View my sales & purchases
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