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
        @if(!$user->isCotyso())
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
                                        @if($user->isCotyso())
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

                                            @if($user->isCotyso())
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 600;font-size:13px;">
                                                    <span style="color:#818181;">
                                                        Thank you for your purchase from Singing Experience
                                                    </span>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:17px;">
                                                    <span style="color:#fc064c;">Hi {{ $checkout->customer_name }}</span>
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

                                            @if(!$user->isCotyso())
                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#8c8c8c;font-family:Open Sans,sans-serif;font-weight: 500;font-size:11px">
                                                    You have purchased the following items from <span style="color:#fc064c;">{{ $user->name }}</span>
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 28px;" align="left">
                                                    <span style="color:#8c8c8c; float: left;">Item </span>
                                                    <span style="color:#8c8c8c; float: right;">Price </span>
                                                </td>
                                            </tr>
                                            @if(isset($customerBasket))
                                            <?php foreach($customerBasket as $b){
                                                $convertedAmount = $commonMethods->convert(strtoupper($user->profile->default_currency), $currency, $b->price);
                                                if($b->purchase_type == 'music' || $b->purchase_type == 'instant-license'){ 
                                                    if($b->music){
                                                        $music = $b->music;
                                                    }else{
                                                        $explode = explode('_', $b->extra_info);
                                                        $chat = \App\Models\UserChat::find($explode[1]);
                                                        $music = \App\Models\UserMusic::find($chat->agreement['music']);
                                                    }
                                                ?>

                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">{{ $music->song_name }}<br>
                                                            <span style="font-size: 11px; color: #000;">
                                                                @if(strpos($b->license, 'bespoke_') !== false)
                                                                {{'Bespoke License'}}
                                                                @else
                                                                {{ "(" . $b->license . ")" }}
                                                                @endif
                                                            </span>
                                                        </span>
                                                        <span style="color:#8c8c8c; float: right;">
                                                            {{$convertedAmount>0?$currencySymbol.number_format($convertedAmount, 2):'Free'}} 
                                                        </span>
                                                    </td>
                                                </tr>

                                            <?php } else if($b->purchase_type == 'album'){
                                                $album = $b->album;
                                            ?>
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">
                                                            {{ $album->name }}<br>
                                                            <span style="font-size: 11px; color: #000;">
                                                                (Album)
                                                            </span>
                                                        </span>
                                                    <span style="color:#8c8c8c; float: right;">{{ $currencySymbol.number_format($convertedAmount, 2) }} </span>
                                                </td>
                                            </tr>

                                            <?php } else if($b->purchase_type == 'donation_goalless'){ ?>

                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">Contribution</span>
                                                        <span style="color:#8c8c8c; float: right;">{{ $currencySymbol.number_format($convertedAmount, 2) }} </span>
                                                    </td>
                                                </tr>

                                            <?php } else if($b->purchase_type == 'project'){ ?>

                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">Project<br>
                                                            <span style="font-size: 11px; color: #000;">
                                                                {{ $b->instantItemTitle() }}
                                                            </span>
                                                        </span>
                                                        <span style="color:#8c8c8c; float: right;">
                                                            {{$convertedAmount>0?$currencySymbol.number_format($convertedAmount, 2):'Free'}} 
                                                        </span>
                                                    </td>
                                                </tr>
                                                
                                            <?php } else if($b->purchase_type == 'subscription'){ ?>

                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">Subscription<br>
                                                            <span style="font-size: 11px; color: #000;">
                                                                ({{ $b->price }} / month)
                                                            </span>
                                                        </span>
                                                        <span style="color:#8c8c8c; float: right;">
                                                            {{$convertedAmount>0?$currencySymbol.number_format($convertedAmount, 2):'Free'}} 
                                                        </span>
                                                    </td>
                                                </tr>

                                            <?php } else if($b->purchase_type == 'product' || $b->purchase_type == 'proferred-product'){
                                                if($b->product){
                                                    $product = $b->product;
                                                }else{
                                                    $explode = explode('_', $b->extra_info);
                                                    $chat = \App\Models\UserChat::find($explode[1]);
                                                    $product = \App\Models\UserProduct::find($chat->product['id']);
                                                }
                                                
                                             ?>

                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">{{ $product->title }}</span>
                                                        <span style="color:#8c8c8c; float: right;">{{ $currencySymbol.number_format($convertedAmount, 2) }} </span>
                                                    </td>
                                                </tr>
                                                @if($user->isCotyso() && $b->product && $b->product->voucher_id)
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-size:13px;padding-bottom:28px;">
                                                        <span style="color:#818181;">
                                                            Singing Experience is the UK's No 1 Recording Studios. Former hosts to One Direction, Blur, New Order and many others.
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-size:13px;padding-bottom:28px;">
                                                        <span style="color:#818181;">
                                                            <b>Your voucher code is given below.</b> Please keep this email safe as you will need to book your session
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-size:13px;padding-bottom:28px;">
                                                        <span style="color:#818181;">
                                                            Our booking portal is ready for you to place a booking using your voucher code. Music videos and photos will be uploaded on the portal after the experience. You will be able to download them by logging in to our booking portal with your voucher code.
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-size:13px;padding-bottom:28px;">
                                                        <span style="color:#818181;">
                                                            <b>Your voucher code: </b>{{$voucherCode}}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-size:13px;padding-bottom:28px;">
                                                        <span style="color:#818181;">
                                                            Stuart is tied in on this voucher and when you are ready to book in, he will assist you with your session
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-size:13px;padding-bottom:28px;">
                                                        <a style="text-decoration:none;padding:8px;background-color:#c3004d; color:#fff;" href="https://www.clients.singingexperience.co.uk">
                                                            Book Now
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endif

                                            <?php } } ?>
                                            @endif

                                            @if(isset($item))
                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">
                                                            @if($item['type'] == 'custom-product')
                                                                {{$item['title']}}
                                                            @else
                                                                {{$item['type']}}<br>
                                                            @endif
                                                            <span style="font-size: 11px; color: #000;">
                                                                @if($item['type'] == 'custom-product')

                                                                @else
                                                                    {{$item['title']}}
                                                                @endif
                                                                
                                                                @if($item['type'] == 'custom-product')
                                                                <br>
                                                                <span style="font-size: 10px; color: #000;">
                                                                    (
                                                                    {{$item['quantity']}}
                                                                    @if($item['size'] != 'None')
                                                                     x {{$item['size']}}
                                                                    @else
                                                                     x 
                                                                    @endif
                                                                    @if($item['color'] != 'None')
                                                                     {{$item['color']}}
                                                                    @endif
                                                                    )
                                                                </span>
                                                                @endif
                                                            </span>
                                                        </span>
                                                        <span style="color:#8c8c8c; float: right;">
                                                            {{$item['currSym'].$item['price']}} 
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if(!$user->isCotyso())
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:16px;" align="left">
                                                    <a href="{{$user->username?route('user.home', ['params' => $user->username]):'#'}}"><button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">View Sellers Profile</button></a>
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            @if(!$user->isCotyso())
                                            <tr>
                                                <td align="center">

                                                    <table cellspacing="0" cellpadding="0" border="0" align="center">
                                                        <tbody>
                                                        <tr>
                                                            <td style="color:#8c8c8c;font-family:Open Sans,sans-serif;font-weight: 500;font-size:10px;width:100%;" align="center">
                                                                To download your products go to <a style="text-decoration: none;" href="{{ asset("/profile") }}?page=orders"><span style="color:#fc064c;">My Purchases</span></a> in your profile.
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-size:13px;">
                                                    <span style="color:#818181;">
                                                        If you have any questions about your experience check out FAQs on our homepage
                                                        <a style="color:#fc064c;text-decoration:underline;" href="https://www.singingexperience.co.uk">
                                                            www.singingexperience.co.uk
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif

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