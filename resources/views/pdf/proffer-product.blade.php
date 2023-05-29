<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style>
            table { width: 100% !important; }
        </style>
    </head>e>
    </head>
    <body style="width:1000px;" >
        <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
            <tr>
                <td style="width:100%;vertical-align:top;">
                    <table align="center" style="width:100%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="height: 8px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 24px; width:100%;vertical-align:bottom;text-align:center;">
                            {{strtoupper($product->title)}}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 30px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">PRODUCT ADDED BY</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$sellerDetails['name']}}
                                @if($sellerDetails['address'] != '')
                                <br>
                                {{$sellerDetails['address']}}
                                @endif
                                @if($sellerDetails['city'] != '' && $sellerDetails['country'] != '')
                                <br>
                                {{$sellerDetails['city'].' - '.$sellerDetails['country']}}
                                @endif
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">PRODUCT ADDED FOR</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$buyerDetails['name']}}
                                @if($buyerDetails['address'] != '')
                                <br>
                                {{$buyerDetails['address']}}
                                @endif
                                @if($buyerDetails['city'] != '' && $buyerDetails['country'] != '')
                                <br>
                                {{$buyerDetails['city'].' - '.$buyerDetails['country']}}
                                @endif
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">DATE OF CREATION</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{date('d/m/Y')}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">PRODUCT PRICE</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{number_format($price, 2).' '.strtoupper($sellerDetails['defaultCurrency'])}}
                            </td>   
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>