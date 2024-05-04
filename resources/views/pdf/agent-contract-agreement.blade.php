<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style>
            table { width: 100% !important; }
        </style>
    </head>
    <body @if(!isset($view))style="width:100%;" @endif>
        <div style="width:100%; padding-left: 12px; padding-right: 12px;">
            <div style="height: 30px;width:55%;"></div>

            <div style="color:#000; font-size: 17px; margin-top: 15px;">AGENT DETAILS</div>
            <div style="height: 15px;width:55%;"></div>

            <div style="color:#888;font-size: 14px;width:55%;">
                {{$agent->name}}<br>
                {{$agent->email}}<br>
                {{$agent->contact_number}}
            </div>
            <div style="height: 15px;width:55%;"></div>

            <div style="color:#000; font-size: 17px; margin-top: 15px;">ARTIST DETAILS</div>
            <div style="height: 15px;width:55%;"></div>

            <div style="color:#888;font-size: 14px;width:55%;">
                {{$contact->name}}<br>
                {{$contact->email}}
            </div>
            <div style="height: 15px;width:55%;"></div>

            <div style="color:#000; font-size: 17px; margin-top: 15px;">TERMS & CONDITIONS</div>
            <div style="font-size: 16px;color: #818181;margin: 10px 0;">
                {!! nl2br($contractDetails) !!}
                @if($contract->custom_terms)
                    <br/><br/>
                    {!! nl2br($contract->custom_terms) !!}
                @endif
            </div>

            <!-- @if($contract->contract->advisory_notes)
                <div style="height: 30px;"></div>
                <div style="color:#000; font-size: 17px; margin-top: 15px;">ADVISORY NOTES</div>
                <div style="height: 15px;"></div>
                <div style="font-size: 16px;color: #818181;margin: 10px 0;">
                    {!! nl2br($contract->contract->advisory_notes) !!}
                </div>
            @endif -->

            <div style="height: 45px;"></div>

            @if(count($signatures))
                <div style="height: 15px;"></div>
                <div style="display: flex; justify-content: space-between; width:100%;">
                    <div style="width:50%;">
                        <div style="text-align: center;">
                            <img style="max-width:150px; max-height: 100px;" src="{{public_path('signatures/'.$signatures['agent'])}}"><br /><br />
                            {{$legalNames['agent']}}
                        </div>
                        <div style="text-align: center;">
                            {{date('d-m-Y', strtotime($contract->created_at))}}
                        </div>
                    </div>
                    <div style="width:50%; display: flex; flex-direction: column; justify-content: flex-end;">
                        <div style="text-align: center;">
                            <img style="max-width:150px; max-height: 100px;" src="{{public_path('signatures/'.$signatures['artist'])}}"><br /><br />
                            {{$legalNames['artist']}}
                        </div>
                        <div style="text-align: center;">
                            {{date('d-m-Y')}}
                        </div>
                    </div>
                </div>

                <div style="height: 45px;"></div>
                <div>
                    <p style="font-size: 16px;color: #818181;margin: 10px 0;">
                        <span class="text-red-600 text-sm">Disclaimer:</span> {{Config('constants.disclaimer')}}
                    </p>
                </div>
            @endif
        </div>
    </body>
</html>
