<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style>
            table { width: 100% !important; }
        </style>
    </head>
    <body>
        <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
            <tr>
                <td style="height: 10px;width:5%;vertical-align:top;"></td>
                <td style="width:90%;vertical-align:top;"></td>
                <td style="width:5%;vertical-align:top;"></td>
            </tr>
            <tr>
                <td style="width:5%;vertical-align:top;"></td>
                <td style="border: 1px solid #fc1356; box-shadow: 0 0 1px #fc1356; width:90%;vertical-align:top;">
                    <table align="center" style="width:95%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="height: 8px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #fc064c;font-size: 15px;font-weight: bold;width:50%;vertical-align:bottom;">Order Details</td>
                            <td colspan="2" align="right" style="width:50%; vertical-align:bottom; position: relative;">
                                <img width="250" style="position: absolute; right: 10px;" src="{{asset('user-product-thumbnails/'.$product->thumbnail) }}" />
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 30px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #737373;font-size: 15px;font-weight: 500;width:55%;vertical-align:bottom;">Order Date&nbsp;&nbsp;{{date('d/m/Y')}}</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 24px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #737373;font-size: 15px;font-weight: 500;width:55%;vertical-align:bottom;">Order Number&nbsp;&nbsp;{{$ticketNumber}}</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 24px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #fc064c;font-size: 15px;font-weight: bold;width:55%;vertical-align:bottom;">Billing Address</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 19px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #737373;font-size: 15px;font-weight: 500;width:55%;vertical-align:bottom; line-height: 20px;">{{$name}}<br />{{$address}}<br />{{$city}}<br />{{$postcode}}</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 31px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #fc064c;font-size: 15px;font-weight: bold;width:55%;vertical-align:bottom;">Your Event</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 31px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #737373;font-size: 15px;font-weight: bold;width:55%;vertical-align:bottom;">
                                {{$product->title}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 31px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #737373;font-size: 15px;font-weight: bold;width:55%;vertical-align:bottom;">
                                {{$product->date_time}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 28px;vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #737373;font-size: 15px;font-weight: bold;width:55%;vertical-align:bottom; line-height: 20px;">
                                {{$product->location}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 31px;vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="color: #737373;font-size: 15px;font-weight: 500;max-width:80% !important;vertical-align:bottom;line-height: 18px;">
                                {!!$product->description!!}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 25px;vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color: #fc064c;font-size: 15px;font-weight: bold;width:61%;vertical-align:bottom;">Ticket Terms And Conditions</td>
                            <td style="color: #fc064c;font-size: 15px;font-weight: bold;width:39%;vertical-align:bottom;"></td>
                        </tr>
                        <tr>
                            <td style="height: 25px;vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="color: #737373;font-size: 15px;font-weight: 500;max-width:80% !important;vertical-align:bottom;line-height: 18px;">
                                {!!$product->terms_conditions!!}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 15px;vertical-align:top;"></td>
                            <td style="vertical-align:top;"></td>
                        </tr>
                    </table>
                </td>
                <td style="width:5%;vertical-align:top;"></td>
            </tr>
        </table>
    </body>
</html>