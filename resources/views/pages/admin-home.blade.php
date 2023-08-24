@extends('templates.bisection-template')


@section('pagetitle') {{$user->name}} - Profile  @endsection

@section('page-level-css')

    <link rel="stylesheet" href="{{asset('css/profile.min.css?v=5.21')}}" />
@stop

@section('page-level-js')

    <!--<script src="https://js.stripe.com/v3/"></script>!-->
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

    @include('parts.add-form-elements')

    @include('parts.basket-popups')

    <div id="body-overlay"></div>

    <div class="pro_page_pop_up clearfix" id="subscription_offers_popup">

        <div class="pro_soc_con_face_inner clearfix">
            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="soc_con_face_username clearfix">
                <div class="subscription_offers_in">
                    <img src="" class="profile_img" />
                    <div class="profile_heading"></div>
                    <div class="bullet_each bullet_one"></div>
                    <div class="bullet_each bullet_two"></div>
                    <div class="bullet_each bullet_three"></div>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="music_zip_download_popup pro_page_pop_up new_popup clearfix" style="z-index: 10;">

        <div class="pro_soc_con_face_inner clearfix">

        <div class="pro_pop_head">Download details</div>
            <div class="pro_pop_body">
                <div class="pro_body_in">
                    <div data-source-id="" data-path="" data-type="main" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Main File</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="license" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-file-pdf-o"></i></div>
                        <div class="pro_pop_each_item item_name">License PDF</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="loop_one" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Loop</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="loop_two" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Loop</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="loop_three" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Loop</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_one" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_two" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_three" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_four" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_five" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_six" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_seven" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                    <div data-source-id="" data-path="" data-type="stem_eight" class="pro_pop_download_each instant_hide">
                        <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                        <div class="pro_pop_each_item item_name">Stem</div>
                        <div class="pro_pop_each_item item_size"></div>
                        <div class="pro_pop_each_item item_download"><i class="fa fa-download"></i></div>
                    </div>
                </div>
            </div>
            <div class="pro_pop_foot">
                <div class="foot_help">
                    Having problems? Please try again or contact us via online chat
                </div>
                <div class="foot_action">
                    <div id="close_download" class="foot_action_btn">Close</div>
                </div>
            </div>
        </div>
    </div>

    <div class="pro_initiating_download in_progress pro_page_pop_up clearfix" style="z-index: 10;" id="pro_initiating_download">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">

                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            </div>
            <div class="soc_con_face_username clearfix">

                <h3>We are preparing your download. Do not refresh or navigate away.</h3><br><br><br>
            </div>
        </div>
    </div>

    <div class="pro_page_pop_up clearfix" id="chat_purchase_popup">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="project stage">
                    <div class="soc_con_face_username clearfix">
                        <div class="main_headline">Set up a new Project Agreement</div><br>
                        <select class="choose_customer_dropdown">
                            <option value="">Choose recipient</option>
                        </select>
                        <div class="instant_hide error choose_customer_error">Required</div>
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Title" type="text" class="title" />
                        <div class="instant_hide error title_error">Required</div>
                        <div class="pro_pop_multi_row">
                            <div class="each_col">
                                <select class="choose_end_term_dropdown">
                                    <option value="">Term Date</option>
                                    <option value="perpetual">Perpetual</option>
                                    <option value="custom">Let me write end term</option>
                                </select>
                                <div class="instant_hide error choose_end_term_error">Required</div>
                            </div>
                            <div class="each_col">
                                <input class="dummy_field" type="text" name="fakeusernameremembered">
                                <input disabled="disabled" placeholder="Eg. valid upto 01/01/2022" type="text" class="end_term" />
                                <div class="instant_hide error end_term_error">Required</div>
                            </div>
                        </div>
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Price" type="number" class="price" />
                        <div class="instant_hide error price_error">Required</div>
                        <textarea class="description" placeholder="Project description (i.e details/milestones/terms etc)"></textarea>
                        <div class="instant_hide error description_error">Required</div>
                    </div>
                </div>
                <div class="license stage">
                    <div class="soc_con_face_username clearfix">
                        <div class="main_headline">You are adding a bespoke license agreement</div><br>
                        <select class="choose_customer_dropdown">
                            <option value="">Choose recipient</option>
                        </select>
                        <div class="instant_hide error choose_customer_error">Required</div>
                        @if(Auth::check())
                        <select class="choose_agreement_music">
                            <option value="">Choose music</option>
                            @if(count(Auth::user()->musics))
                                @foreach(Auth::user()->musics as $music)
                                <option value="{{$music->id}}">{{$music->song_name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="instant_hide error choose_agreement_music_error">Required</div>
                        @endif
                        <div class="pro_pop_multi_row">
                            <div class="each_col">
                                <select class="choose_end_term_dropdown">
                                    <option value="">Term Date</option>
                                    <option value="perpetual">Perpetual</option>
                                    <option value="custom">Let me write end term</option>
                                </select>
                                <div class="instant_hide error choose_end_term_error">Required</div>
                            </div>
                            <div class="each_col">
                                <input class="dummy_field" type="text" name="fakeusernameremembered">
                                <input disabled="disabled" placeholder="Eg. valid upto 01/01/2022" type="text" class="end_term" />
                                <div class="instant_hide error end_term_error">Required</div>
                            </div>
                        </div>
                        <select class="choose_agreement_license">
                            <option selected value="bespoke">Bespoke Agreement</option>
                            @foreach(config('constants.licenses') as $key => $license)
                            <option value="{{$key}}">{{$license['name']}}</option>
                            @endforeach
                        </select>
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Price" type="number" class="price" />
                        <div class="instant_hide error price_error">Required</div>
                        <textarea class="license_terms" placeholder="Write all terms of use here"></textarea>
                        <div class="license_terms_error instant_hide error">Required</div>
                    </div>
                </div>
                <div class="product stage">
                    <div class="soc_con_face_username clearfix">
                        <div class="main_headline">You are adding a product</div><br>
                        <select class="choose_customer_dropdown">
                            <option value="">Choose recipient</option>
                        </select>
                        <div class="instant_hide error choose_customer_error">Required</div>
                        <select class="choose_product">
                            @if(Auth::user())
                            <option value="">Choose product</option>
                            @foreach(Auth::user()->products as $product)
                            <option value="{{$product->id}}">{{$product->title}}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="instant_hide error choose_product_error">Required</div>
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Price" type="number" class="price" />
                        <div class="instant_hide error price_error">Required</div>
                    </div>
                </div>
                <br>
                <div class="pro_button chat_purchase_send_btn">SUBMIT</div>
            </div>
            <div class="stage_two instant_hide">
                <div class="soc_con_face_username clearfix">
                    <div class="pro_pop_text_light text_center">
                        Successfully sent to <span class="pro_text_dark" id="sender_name"></span>. The user will be offered to accept
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

    <div class="pro_pop_chat_upload in_progress new_popup pro_page_pop_up clearfix" style="z-index: 10;">
        <div class="pro_soc_con_face_inner clearfix">
            <div class="pro_pop_head">Upload details</div>
            <div class="pro_pop_body">
                <div class="pro_body_in"></div>
                <div class="pro_pop_info">
                    It may take a while, please be patient. Do not refresh or navigate away from this page
                </div>
            </div>
            <div class="pro_pop_foot">
                <div class="foot_help">
                    Having problems? Please try again or contact us via online chat
                </div>
                <div class="foot_action">
                    <!--<div id="minify_upload" class="foot_action_btn">Hide</div>!-->
                </div>
            </div>
        </div>
    </div>

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

    <div class="pro_page_pop_up clearfix" id="get_agent_popup">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="soc_con_face_username clearfix">
                    <div class="primary_headline">Request to have an artist manager</div>
                    <div class="pro_pop_text_light text_normal">
                        Your request will be sent to <span class="pro_text_dark new_agent_name"></span>
                    </div>
                    <div class="current_agent instant_hide">
                        <div class="main_headline current_agent_name"></div>
                        <div class="pro_pop_text_light text_normal">is your current artist manager</div>
                    </div>
                    <div class="new_agent">
                        <div class="main_headline new_agent_name"></div>
                        <div class="pro_pop_text_light text_normal">is the manager you are requesting for</div>
                    </div>
                </div>
                <br><br>
                <div id="proceed_get_agent" class="pro_button">Send Request</div>
            </div>
            <div class="stage_two instant_hide">
                <div class="soc_con_face_username clearfix">
                    <div class="pro_pop_text_light text_center">
                        Your request has been sent to <span class="pro_text_dark new_agent_name"></span>. The manager will be resposible to process and reply to this request. Keep checking your email and 1Platform account for any updates regarding this request.
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

    <div class="pro_page_pop_up clearfix" id="add_chat_group_member_popup">
        <div class="pro_soc_con_face_inner clearfix">
            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="soc_con_face_username clearfix">
                    <div class="main_headline">Introduce a contact in this chat</div><br>
                    <div class="hide_on_mobile"><br></div>
                    <div class="pro_pop_multi_row">
                        <div class="each_col">
                            @if(Auth::check())
                            <select id="add_chat_group_member">
                                <option value="">Choose your contact</option>
                                <option value="add_by_code">Add contact by code</option>
                                @if(count($contacts))
                                    @foreach($contacts as $contact)
                                        @if(!$contact->contactUser || $contact->approved == NULL)
                                            @php continue @endphp
                                        @endif
                                        @php
                                            $isAgentUser = $user->isAgentOfContact($contact);
                                            $partnerUser = $isAgentUser ? $contact->contactUser : $contact->agentUser;
                                        @endphp
                                        <option value="{{$partnerUser->id}}">{{$partnerUser->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="instant_hide error" id="add_chat_group_member_error">Required</div>
                            @endif
                        </div>
                        <div class="each_col">
                            <input class="dummy_field" type="text" name="fakeusernameremembered">
                            <input disabled="disabled" placeholder="Enter Contact Code" type="text" id="add_chat_group_member_contact_code" />
                            <div class="instant_hide error" id="add_chat_group_member_contact_code_error">Required</div>
                        </div>
                    </div>
                </div>
                <br>
                <div id="send_add_chat_group_member" class="pro_button">SUBMIT</div>
            </div>
        </div>
    </div>

    <div data-currency="{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}" class="pro_page_pop_up clearfix" id="pay_quick_popup">

        <div class="pro_soc_con_face_inner clearfix">
            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="soc_con_face_username clearfix">
                    <div class="main_headline"></div>
                    <div class="second_headline"></div>
                    <div id="pay_quick_error" class="instant_hide m_e_card_pop_error"></div>
                    <div id="pay_quick_card_number" class="m_e_card_elem m_e_card_pop"></div>
                    <div class="pro_pop_multi_row">
                        <div class="each_col">
                            <input class="dummy_field" type="text" name="fakeusernameremembered">
                            <input placeholder="Card Name" type="text" id="pay_quick_card_name" />
                        </div>
                        <div class="each_col">
                            <div id="pay_quick_card_cvc" class="m_e_card_elem m_e_card_pop"></div>
                        </div>
                    </div>
                    <div class="pro_pop_multi_row">
                        <div id="pay_quick_card_expiry" class="m_e_card_elem m_e_card_pop"></div>
                    </div>
                </div>
                <br>
                <div id="pay_quick_final" class="pro_button">SUBMIT</div>
            </div>
        </div>
    </div>
    <div class="ind_con_details_popup pro_page_pop_up new_popup clearfix" style="z-index: 10; max-height:600px; overflow:auto">

        <div class="pro_soc_con_face_inner clearfix">
            <div style="padding: 10px 20px;" class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="pro_pop_head"></div>
            <div class="pro_pop_body">
                <div data-type="address" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-home"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="email" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-envelope"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="phone" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-phone"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="website" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-globe"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="facebook" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-facebook-square"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="twitter" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-twitter-square"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="instagram" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-instagram"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="youtube" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-youtube"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="soundcloud" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-soundcloud"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
                <div data-type="information" class="pro_pop_ind_con_each instant_hide">
                    <div class="pro_pop_each_ind_con_item item_type"><i class="fa fa-info-circle"></i></div>
                    <div class="pro_pop_each_ind_con_item item_name"></div>
                </div>
            </div>
            <div class="pro_pop_foot">
                <div class="foot_help">
                    If the listing details have changed let us know via online chat to the bottom right
                </div>
                <div class="foot_action">

                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
@stop

@section('bottom-section')
@stop







