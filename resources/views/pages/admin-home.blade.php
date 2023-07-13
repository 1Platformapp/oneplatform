@extends('templates.bisection-template')


@section('pagetitle') {{$user->name}} - Profile  @endsection

@section('page-level-css')

    <link rel="stylesheet" href="{{asset('css/profile.min.css?v=5.21')}}" />
@stop

@section('page-level-js')

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
            boxShadow: {
                'custom': '0 0 13px #818181',
            },
        }
      }
    }
  </script>
@stop

@section('header')

    @include('parts.header')
@stop

@section('top-section')
@stop

@section('audio-player')
@stop

@section('flash-message-container')

    @php $quickSetup = $user->quickSetupProfile() @endphp

    @if (Session::has('error'))

        <div class="error_span">
            <i class="fa fa-times-circle"></i>
            {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
        </div>

    @endif

    @if (Session::has('success'))

        <div class="success_span">
            <i class="fa fa-check-circle"></i>
            {{ (is_array(Session::get('success'))) ? Session::get('success')[0] : Session::get('success') }}
        </div>

    @endif

    <div class="js_message_contain instant_hide">
        <div class="error_span"></div>
        <div class="success_span"></div>
    </div>
@stop

@section('left-section')

    <div class="pro_left_sec_outer">
    	<div class="pro_acc_stats_outer">
    		<div class="pro_acc_stat_top">
    			<div class="pro_acc_stat_head">Account Statistics</div>
    		</div>
    		<div class="pro_acc_stat_sep"></div>
    		<div class="pro_acc_stat_btm">
    			<div class="pro_acc_stat_each">
    				<div class="pro_acc_stat_name">
    					Total Revenue
    				</div>
    				<div class="pro_acc_stat_val">
    					{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ number_format($purchaseParticulars['total_revenue'], 2) }}
    				</div>
    			</div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Singles Sold
                    </div>
                    <div class="pro_acc_stat_val">
                        {{$purchaseParticulars['singles_sold']}}
                    </div>
                </div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Albums Sold
                    </div>
                    <div class="pro_acc_stat_val">
                        {{$purchaseParticulars['albums_sold']}}
                    </div>
                </div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Products Sold
                    </div>
                    <div class="pro_acc_stat_val">
                        {{$purchaseParticulars['products_sold']}}
                    </div>
                </div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Fans
                    </div>
                    <div class="pro_acc_stat_val">
                        {{count($purchaseParticulars['fans'])}}
                    </div>
                </div>
                @php $agent = \App\Models\AgentContact::where(['contact_id' => $user->id, 'approved' => 1])->whereNotNull('agent_id')->first() @endphp
    			<div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Your Agent
                    </div>
                    <div title="{{$agent && $agent->agentUser?$agent->agentUser->activityStatus():''}}" class="pro_acc_stat_val">
                        @if($agent && $agent->agentUser)
                            <i class="fa fa-circle {{$agent->agentUser->activityStatus()}}"></i>&nbsp;
                            {{$agent->agentUser->name}}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
    		</div>
    	</div>

        <div class="pro_lat_sale">
            <div class="pro_lat_sale_top">
                <div class="pro_lat_sale_head">Latest Sales</div>
                <div class="pro_lat_sale_sub_head">Your latest sales</div>
            </div>
            <div class="pro_lat_sale_bottom">
                @if(count($topSales))
                @foreach($topSales as $key => $checkout)
                @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                @php $customerImage = $commonMethods->getUserDisplayImage($checkout->customer ? $checkout->customer->id : 0) @endphp
                <div class="pro_lat_sale_each">
                    <div class="pro_lat_sale_each_left">
                        <img class="trans_image" title="{{$checkout->customer_name}}" src="{{$customerImage}}" alt="#" />
                    </div>
                    <div class="pro_lat_sale_each_center">
                        <div class="pro_lat_sale_each_name">
                            {{$checkout->customer_name}}
                        </div>
                        <div class="pro_lat_sale_each_desc">
                            @if($checkout->type == 'crowdfund')
                                Crowdfund sale
                            @else
                                {{count($checkout->instantCheckoutItems)}}
                                {{count($checkout->instantCheckoutItems) == 1 ? 'item' : 'items'}}
                            @endif
                        </div>
                    </div>
                    <div class="pro_lat_sale_each_right">
                        {{($checkout->price>0)?$currencySymbol.number_format($checkout->price, 2):' Free'}}
                    </div>
                </div>
                @endforeach
                @else
                <div class="no_results">You do not have any sales yet</div>
                @endif
            </div>
        </div>
    </div>

@stop

@section('right-section')

    <div class="pro_right_sec_outer">

        <div class="pro_right_tb_det_outer">

            @include('parts.profile-chat')
        </div>
    </div>

@stop

@section('miscellaneous-html')

    <div id="body-overlay"></div>

    <div class="pro_confirm_delete_outer pro_page_pop_up clearfix" >

        <div class="pro_confirm_delete_inner clearfix">

            <div class="soc_con_top_logo clearfix">

                <a style="opacity: 0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}">
                    <div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="pro_confirm_delete_text clearfix">

                <div class="main_headline">Are You Sure You Want To Delete This Item?</div><br>
                <span class="error"></span>
            </div>
            <div class="pro_confirm_box_outer pro_submit_button_outer soc_submit_success clearfix">

                <div class="delete_yes pro_confirm_box_each" data-delete-id="" data-delete-item-type="" data-album-status="" data-album-music-id="" id="pro_delete_submit_yes">YES</div>
                <div class="delete_no pro_confirm_box_each" id="pro_confirm_delete_submit_no">NO</div>
            </div>
        </div>
    </div>

    <div class="pro_page_pop_up clearfix" id="switch_account_popup">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="soc_con_face_username clearfix">
                    <div class="main_headline">Switch to your contact account?</div><br>
                    <div class="pro_pop_text_light">
                        If you proceed, the system will log you out from your current account and will log into your contact's account
                    </div>
                </div>
                <br>
                <div id="proceed_switch_account" class="pro_button">Proceed</div>
            </div>
        </div>
    </div>
@stop

@section('bottom-section')
@stop







