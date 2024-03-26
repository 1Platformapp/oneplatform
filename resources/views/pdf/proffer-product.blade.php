<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style>
            table { width: 100% !important; }
        </style>
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
                        <tr>
                            <td style="height:50px; width:100%; vertical-align:top;"></td>
                        </tr>
                        <tr><hr></tr>
                        <tr>
                            <td style="border-top:1px solid;">
                                <p style="font-size: 16px;color: #818181;margin: 10px 0;">
                                    <span style="color: red;">Disclaimer:</span> 1Platform is not responsible for any agreements made between users on the platform. 
                                    Our website serves as a platform for users to buy, sell, and collaborate. 
                                    We do not take responsibility for any disputes or legal issues arising from these interactions. 
                                    Users are advised to exercise caution and diligence when engaging with others on the platform. 
                                    By using our services, you agree that 1Platform cannot be held liable for any such disputes, 
                                    and you waive any right to take legal action against the platform.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>