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
            <td height="20px">&nbsp; </td>
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
                                                    <span style="color:#fc064c;">Hi {{ $user->name }}</span>
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
                                                <td height="25">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="color:#8c8c8c;font-family:Open Sans,sans-serif;font-weight: 500;font-size:11px">
                                                    <span style="color:#fc064c;">{{ $customer->name }}</span> has just purchased the following items from you.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="22">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 28px;" align="left">
                                                    <span style="color:#8c8c8c; float: left;">Item </span>
                                                    <span style="color:#8c8c8c; float: right;">Price </span>
                                                </td>
                                            </tr>

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
                                                $album = $b->album; ?>

                                                <tr>
                                                    <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                            <span style="width: 70%; color:#8c8c8c; float: left;">
                                                                {{ $album->title }}<br>
                                                                <span style="font-size: 11px; color: #000;">
                                                                    (Album)
                                                                </span>
                                                            </span>
                                                        <span style="color:#8c8c8c; float: right;">{{ $currencySymbol.number_format($convertedAmount, 2) }} </span>
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

                                            <?php } else if($b->purchase_type == 'project'){ ?>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                        <span style="width: 70%; color:#8c8c8c; float: left;">Project<br>
                                                            <span style="font-size: 11px; color: #000;">{{ $b->instantItemTitle() }}</span>
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
                                                                <span style="font-size: 11px; color: #000;">{{ $b->price }}/month</span>
                                                            </span>
                                                            <span style="color:#8c8c8c; float: right;">
                                                                {{$convertedAmount>0?$currencySymbol.number_format($convertedAmount, 2):'Free'}} 
                                                            </span>
                                                    </td>
                                                </tr>

                                            <?php } else if($b->purchase_type == 'donation_goalless'){ ?>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: normal;font-size:13px; padding-bottom: 24px;" align="left">
                                                    <span style="width: 70%; color:#8c8c8c; float: left;">Contribution</span>
                                                    <span style="color:#8c8c8c; float: right;">{{ $currencySymbol.number_format($convertedAmount, 2) }} </span>
                                                </td>
                                            </tr>
                                            <?php }  
                                            }?>

                                            <tr>
                                                <td>

                                                    <table style="width: 100%;" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>

                                                        <tr>
                                                            <td style="color:#8c8c8c;font-family:Open Sans,sans-serif;font-weight: 500; font-size: 11px;width:100%; line-height: 24px;">
                                                                Customers will receive all digital products and licences.<br>
                                                                It is your responsibility to deliver any physical good.<br>
                                                                You can find customers details on the <a style="text-decoration: none;" href="{{ asset("/profile") }}?page=orders"><span style="color:#fc064c;">My Monies</span></a> page.
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td height="27">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-family:Open Sans,sans-serif;font-weight: 500;font-size:16px;" align="left">
                                                    <a href="{{ asset('/') . 'profile?email_user=' . $user->id }}"><button style="box-shadow: 3px 3px 5px #404040; border: 0; width: 100%; height: 25px; color: #fff; background-color: #999999; font-size: 14px; cursor: pointer;">View My Monies</button></a>
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