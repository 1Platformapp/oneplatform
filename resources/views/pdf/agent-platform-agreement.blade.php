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
                                Agent Agreement With 1Platform TV
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 30px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">AGENT DETAILS</td>
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
                                {{$expert->user->name}}
                                <br>
                                {{$expert->user->email}}
                                <br>
                                {{$expert->user->contact_number}}
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
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">AGREEMENT DETAILS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        @if($expert->commission)
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                1Platform Fee: {{$expert->commission}}%
                                <br>
                                Agent will pay this fee to 1Platform from the commission earned by deals made directly through the chat
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        @endif
                        @if($expert->agent_from_platform_fee_type)
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                Agent Fee: {{$expert->agent_from_platform_fee}}{{$expert->agent_from_platform_fee_type == '2' ? '%' : 'GBP'}}
                                <br>
                                @if($expert->agent_from_platform_fee_type == '2')
                                    1Platform will pay this fee to agent (out of its fee share from a transaction) if an agent's user sell anything from the website/store
                                @elseif($expert->agent_from_platform_fee_type == '2')
                                    1Platform will pay this fee to agent once every month
                                @endif
                                <br><br>
                                Note: 1Platform will only pay the above fee when the agent's user has <br> 
                                1- Connected a stripe account with 1Platform<br>
                                2- Uploaded background image for the website<br>
                                3- Added bio from the profile<br>
                                4- Added atleast 3 products<br>
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        @endif
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">Terms & Conditions</td>
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
                                {!! nl2br($expert->terms) !!}
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