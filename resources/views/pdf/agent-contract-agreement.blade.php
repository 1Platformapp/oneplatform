<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style>
            table { width: 100% !important; }
        </style>
    </head>
    <body @if(!isset($view))style="width:100%;" @endif>
        <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
            <tr>
                <td style="width:100%;vertical-align:top;">
                    <table align="center" style="width:100%; padding-left: 12px;  padding-right: 12px;" cellpadding="0" cellspacing="0" >
                        <!-- <tr>
                            <td style="height: 8px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#000;font-size: 24px; width:100%;vertical-align:bottom;">
                                1Platform Network Agency
                            </td>
                        </tr> -->
                        <tr>
                            <td style="height: 30px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#000; font-size: 17px;  width:100%;vertical-align:bottom;">AGENT DETAILS</td>
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
                                {{$agent->name}}
                                <br>
                                {{$agent->email}}
                                <br>
                                {{$agent->contact_number}}
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
                            <td style="color:#000; font-size: 17px;  width:100%;vertical-align:bottom;">ARTIST DETAILS</td>
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
                                {{$contact->name}}
                                <br>
                                {{$contact->email}}
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
                            <td style="color:#000; font-size: 17px;  width:100%;vertical-align:bottom;">TERMS & CONDITIONS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr style="max-width:100%;">
                            <td colspan="3" style="font-size: 16px;color: #818181;margin: 10px 0;width:120%;vertical-align:bottom;">
                                {!! $contractDetails.'<br /><br />'.$contract->custom_terms !!}
                            </td>
                        </tr>
                        @if($contract->contract->advisory_notes)
                        <tr>
                            <td style="height: 15px"></td>
                        </tr>
                        <tr>
                            <td style="color:#000; font-size: 17px;  width:100%;vertical-align:bottom;">ADVISORY NOTES</td>
                        </tr>
                        <tr>
                            <td style="height: 15px"></td>
                        </tr>
                        <tr style="max-width:100%;">
                            <td colspan="3" style="font-size: 16px;color: #818181;margin: 10px 0;vertical-align:bottom;">
                                {!! $contract->contract->advisory_notes !!}
                            </td>
                        </tr>
                        @endif
                        @if(count($signatures))
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr style="max-width:100%;">
                            <td style="width:49%;vertical-align:top;">
                                <img style="max-width:150px; max-height: 100px;" src="{{public_path('signatures/'.$signatures['agent'])}}"><br /><br />
                                {{$legalNames['agent']}}
                            </td>
                            <td style="width:2%;vertical-align:top;"></td>
                            <td style="width:49%;vertical-align:top;">
                                <img style="max-width:150px; max-height: 100px;" src="{{public_path('signatures/'.$signatures['artist'])}}"><br /><br />
                                {{$legalNames['artist']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr style="max-width:100%;">
                            <td style="width:49%;vertical-align:top;">
                                {{date('d-m-Y', strtotime($contract->created_at))}}
                            </td>
                            <td style="width:2%;vertical-align:top;"></td>
                            <td style="width:49%;vertical-align:top;">
                                {{date('d-m-Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 45px;"></td>
                        </tr>
                        <tr style="max-width:100%;">
                            <td colspan="3">
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
                        @endif
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
