

@php $display = 'display: block;' @endphp

@if($page != 'orders')
    @php $display = 'display: none;' @endphp
@endif

<script src="js/profile-order-scroller.js" type="text/javascript"></script>
<div id="profile_tab_06" class="pro_your_order_sec-06 pro_pg_tb_det" style="{{ $display }}">

    <div class="pro_pg_tb_det_inner">

        <div id="my_purchases_section" class="sub_cat_data {{$subTab == '' || $subTab == 'purchases' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage Your Purchases</div>
            </div>
            <div class="each_tab_content">
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner">
                        <h3>
                            <span class="head_text">My subscription plan</span>
                            <i class="fa opened orders_bottom_arrow"></i>
                        </h3>
                        <div style="display: block;" class="profile_orders_slide_win">
                            <div class="current_sub_outer">

                            	@if($user->internalSubscription)
                            	    @php $package = explode('_', $user->internalSubscription->subscription_package) @endphp
                            		@php $status = $user->internalSubscription->subscription_status @endphp
                            	@else
                            		@php $package = null @endphp
                            		@php $status = null @endphp
                            	@endif

                                @if($user->is_buyer_only == 1)
                                <div class="pro_note">
                                    <ul>

                                        <li>Your account is only allowed to purchase on 1 Platform at the moment</li>
                                        <li>If you wish to start selling or promote your profile, you will need to upgrade your account</li>
                                        <li>Click the subscribe button below and start selling at 1 Platform</li>
                                    </ul>
                                </div>
                                @endif

                            	<div class="curr_sub_user_box {{ $package && $user->internalSubscription->subscription_status == 1 ? 'subscribed' : '' }}">
                            		<div class="curr_sub_user_left">
                            			<div class="curr_sub_user_ll">
                            				<div class="curr_sub_pics">
                            					<div class="sub_act_cover">
                            						<i class="fa {{$status ? 'fa-check-circle' : 'fa-times'}}"></i>
                            					</div>
                            					<img src="{{$commonMethods::getUserDisplayImage($user->id)}}">
                            				</div>
                            				<div class="curr_sub_cans">
                            					@if(!$status)
                            					<div class="int_sub_up">
                            						<a href="{{route('user.startup.wizard')}}">Subscribe</a>
                            					</div>
                            					@elseif($status && $package && $package[0] == 'silver')
                            					<div class="int_sub_up">
                            						<a href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}">Upgrade Plan</a>
                            					</div>
                            					@endif

                            					@if($package && ($package[0] == 'gold' || $package[0] == 'platinum'))
                            					<div class="int_sub_down">
	                            					<a href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}">Change Plan</a>
	                            				</div>
                            					@endif
                            				</div>
                            			</div>
                            			<div class="curr_sub_user_lr">
                            				<div class="curr_sub_det_each">
                            					Plan:<span class="hide_on_desktop"><br></span>
                            					@if($package)
                                                    @if($user->networkAgent() && $package[0] == 'silver')
                                                        Agency Premium
                                                    @else
                                						{{ucfirst($package[0])}} -
                                                        @if($package[1] > 0)
                                                        &pound;{{$package[1]}} / {{$package[2]}}
                                                        @else
                                                        Free
                                                        @endif
                                                    @endif
                            					@else
                            						N/A
                            					@endif
                            				</div>
                            				<div class="curr_sub_det_each">
                            					Start Date: <span class="hide_on_desktop"><br></span>
                            					@if($package)
                            						{{date('d/m/Y', strtotime($user->internalSubscription->created_at))}}
                            					@else
                            						N/A
                            					@endif
                            				</div>
                            				<div class="curr_sub_det_each">
                            					Subscription Status: <span class="hide_on_desktop"><br></span>
                            					@if($status)
                            						{{$status == 1 ? 'Active' : 'Not active'}}
                            					@else
                            						N/A
                            					@endif

                            				</div>
                            			</div>
                            		</div>
                            		<div class="curr_sub_user_right">
                            			<div class="curr_sub_next_each">
                            				Next Invoice Amount: <span class="hide_on_desktop"><br></span>
                            				@if($upcomingInvoice && count($upcomingInvoice))
                            					&pound;{{($upcomingInvoice['amount_due']/100)}}
                            				@else
                            					N/A
                            				@endif
                            			</div>
                            			<div class="curr_sub_next_each">
                            				Next Invoice Period: <span class="hide_on_desktop"><br></span>
                            				@if($upcomingInvoice && count($upcomingInvoice))
                            					{{date('d/m/Y', $upcomingInvoice['lines']['data'][0]['period']['start'])}}
                            					<span class="hide_on_mobile"> - </span>
                            					{{date('d/m/Y', $upcomingInvoice['lines']['data'][0]['period']['end'])}}
                            				@else
                            					N/A
                            				@endif
                            			</div>
                            			<div class="curr_sub_next_each">
                            				Next Invoice Date: <span class="hide_on_desktop"><br></span>
                            				@if($upcomingInvoice && count($upcomingInvoice))
                            					{{date('d/m/Y h:i A', $upcomingInvoice['next_payment_attempt'])}}
                            				@else
                            					N/A
                            				@endif
                            			</div>
                            		</div>
                            	</div>

                                @if($package && $package[1] > 0)
                            	<div class="curr_sub_invs">
                            		<div class="curr_sub_inv_head">
                            			<div class="curr_sub_inv_head_each">Payment Period</div>
                            			<div class="curr_sub_inv_head_each hide_on_mobile">Creation Date</div>
                            			<div class="curr_sub_inv_head_each hide_on_mobile">Fee</div>
                            			<div class="curr_sub_inv_head_each">Status</div>
                            			<div class="curr_sub_inv_head_each">Actions</div>
                            		</div>
                            		@if($user->internalSubscription)
                            		@foreach($user->internalSubscription->invoices as $invoice)
                            		<div class="curr_sub_body">
                            			<div class="curr_sub_inv_body_each">
                            				{{date('d/m/Y', $invoice->period_start)}}
                            				<span class="hide_on_mobile"> - </span>
                            				{{date('d/m/Y', $invoice->period_end)}}
                            			</div>
                            			<div class="curr_sub_inv_body_each hide_on_mobile">
                            				{{date('d/m/Y', $invoice->created_at_stripe)}}
                            			</div>
                            			<div class="curr_sub_inv_body_each hide_on_mobile">
                            				&pound;{{($invoice->amount_due/100)}}
                            			</div>
                            			<div class="curr_sub_inv_body_each">
                            				{{ucfirst($invoice->status)}}
                            				<span class="hide_on_mobile"> - </span>
                            				@if($invoice->status == 'paid')
                            				    <span class="invoice_status_info">
                            				    	{{date('d/m/Y', $invoice->paid_at_stripe)}}
                            				    </span>
                            				@elseif($invoice->next_payment_attempt)
                            				    <span class="invoice_status_info">
                            				    	{{date('d/m/Y', $invoice->next_payment_attempt)}}
                            				    </span>
                            				@endif
                            			</div>
                            			<div class="curr_sub_inv_body_each">
                            				<div class="curr_sub_inv_act_btn">
                            					<a target="_blank" href="{{$invoice->pay_invoice_url}}">View</a>
                            				</div>
                            				<div class="curr_sub_inv_act_btn">
                            					<a download href="{{$invoice->download_invoice_url}}">Download</a>
                            				</div>
                            			</div>
                            		</div>
                            		@endforeach
                            		@endif
                            	</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner">
                        <h3>
                            <span class="head_text">My purchases</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">

                            @foreach($instantPurchases as $checkout)
                                @if($checkout->user)
                                @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                                @foreach($checkout->instantCheckoutItems as $checkoutItem)
                                    @php $itemImage = $commonMethods->getItemImage($checkoutItem->id, $checkoutItem->source_table_id, $checkoutItem->type) @endphp
                                    @if($checkout->stripe_charge_id)
                                        @php $class = 'badge_success' @endphp
                                    @elseif($checkout->paypal_order_id)
                                        @php $class = 'badge_success' @endphp
                                    @elseif($checkout->error)
                                        @php $class = 'badge_error' @endphp
                                    @elseif($checkout->amount == 0)
                                        @php $class = 'badge_free' @endphp
                                    @else
                                        @php $class = 'badge_warning' @endphp
                                    @endif
                                    @if($checkoutItem->type == 'music' || $checkoutItem->type == 'album' || $checkoutItem->type == 'product' || $checkoutItem->type == 'project' || $checkoutItem->type == 'proferred-product' || $checkoutItem->type == 'custom-product')
                                    <div class="my_sub_sec_list my_purchase_list clearfix">
                                        <div class="sub_left_img">
                                            <span class="smart_badge {{$class}}">
                                                <img title="{{'You Purchased '.$checkoutItem->name.' from '.$checkout->user_name}}" src="{{$itemImage}}" alt="" />
                                                <div class="smart_badge_txt">
                                                    @if($class == 'badge_success')
                                                        <i class="fa fa-check-circle"></i> Paid
                                                    @elseif($class == 'badge_warning')
                                                        <i class="fa fa-clock-o"></i> Will Pay
                                                    @elseif($class == 'badge_free')
                                                        <i class="fa fa-clock-o"></i> Free
                                                    @else
                                                        <i class="fa fa-exclamation-triangle"></i> Failed
                                                    @endif
                                                </div>
                                            </span>
                                        </div>
                                        <div class="sub_right_sec my_date_sec">
                                            <a href="javascript:void(0)">
                                                {{($checkoutItem->price>0)?$currencySymbol.number_format($checkoutItem->price, 2):'Free'}}
                                                {{' - '.date('d/m/Y', strtotime($checkoutItem->created_at))}}
                                            </a>
                                        </div>
                                        <div class="sub_right_sec my_sub_right_sec">
                                            <a href="{{$checkout->user && $checkout->user->username ? route('user.home', ['params' => $checkout->user->username]) : 'javascript:void(0)'}}">{{$checkout->user_name}}</a>
                                        </div>
                                        <div class="sub_right_sec my_purchase_sec">
                                            <a href="javascript:void(0)">
                                                {{$checkoutItem->name}}
                                                @if($checkoutItem->type == 'custom-product')
                                                    @if($checkoutItem->size != 'None')
                                                        <br>{{$checkoutItem->quantity.' x '.$checkoutItem->size.' - '.$checkoutItem->color}}
                                                    @else
                                                        <br>{{$checkoutItem->quantity.' x '.$checkoutItem->color}}
                                                    @endif
                                                @endif
                                            </a>
                                        </div>
                                        @php $link = 'javascript:void(0)' @endphp
                                        @if($checkoutItem->type == 'product')
                                            @if($checkoutItem->file_name && $checkoutItem->file_name != '')
                                            @php
                                                list($first, $nameOnly) = explode('/', $checkoutItem->file_name);
                                                $link = route('download.product.file', ['name' => $nameOnly, 'directory' => 'buyer-ticket-files', 'title' => str_replace('/',' ',$checkoutItem->name)]);
                                            @endphp
                                            @endif
                                            @php $class = ''; @endphp
                                        @elseif($checkoutItem->type == 'project')
                                            @if($checkoutItem->file_name && $checkoutItem->file_name != '')
                                            @php
                                                $link = route('proffer.project.download.pdf', ['filename' => $checkoutItem->file_name, 'title' => $checkoutItem->name]);
                                            @endphp
                                            @endif
                                            @php $class = ''; @endphp
                                        @elseif($checkoutItem->type == 'proferred-product')
                                            @if($checkoutItem->file_name && $checkoutItem->file_name != '')
                                            @php
                                                $link = route('proffer.product.download.pdf', ['filename' => $checkoutItem->file_name, 'title' => $checkoutItem->name]);
                                            @endphp
                                            @endif
                                            @php $class = ''; @endphp
                                        @elseif($checkoutItem->type == 'custom-product')
                                            @php $link = 'javascript:void(0)'; @endphp
                                            @php $class = 'disabled'; @endphp
                                        @else
                                            @php $class = 'purchase_download'; @endphp
                                        @endif
                                        <div class="sub_button_sec my_purchases_dwnload clearfix">
                                            <label>
                                                <a class="{{$class}}" data-download="{{$checkoutItem->type}}" data-checkout-item="{{$checkoutItem->id}}" data-sourcet="{{$checkoutItem->source_table_id}}" href="{{$link}}"> Download <i class="fa fa-download"></i></a>
                                            </label>
                                        </div>
                                        <div class="sub_left_img">
                                            <span>&nbsp;</span>
                                        </div>
                                        <div class="sub_right_sec new_contact_sec" style="padding: 0;">
                                            <a class="contact_btn" data-checkout="{{$checkout->id}}" data-find-type="checkout_user">Contact Details</a>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner Bonus_Donators">
                        <h3>
                            <span class="head_text">My crowdfund purchases</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                            @foreach($crowdfundPurchases as $checkout)
                            @if($checkout->user)
                            @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                            @php $userImage = $commonMethods->getUserDisplayImage($checkout->user->id) @endphp
                            @if($checkout->stripe_charge_id)
                                @php $class = 'badge_success' @endphp
                            @elseif($checkout->paypal_order_id)
                                @php $class = 'badge_success' @endphp
                            @elseif($checkout->error)
                                @php $class = 'badge_error' @endphp
                            @elseif($checkout->amount == 0)
                                @php $class = 'badge_free' @endphp
                            @else
                                @php $class = 'badge_warning' @endphp
                            @endif
                                <div class="my_sub_sec_list clearfix">
                                    <div class="upper_sec">
                                        <div class="sub_sec_img_contain smart_badge {{$class}}">
                                            <img title="{{'You purchased from '.$checkout->user_name}}" src="{{$userImage}}" alt="" />
                                            <div class="smart_badge_txt">
                                                @if($class == 'badge_success')
                                                    <i class="fa fa-check-circle"></i> Paid
                                                @elseif($class == 'badge_warning')
                                                    <i class="fa fa-clock-o"></i> Will Pay
                                                @elseif($class == 'badge_free')
                                                    <i class="fa fa-clock-o"></i> Free
                                                @else
                                                    <i class="fa fa-exclamation-triangle"></i> Failed
                                                @endif
                                            </div>
                                        </div>
                                        <div class="sub_sec_name_desc_contain">
                                            <div class="sub_sec_name"><a href="#">{{$checkout->user->name}}</a></div>
                                            <div class="sub_sec_desc">{{$checkout->comment}}</div>
                                            <div class="sub_sec_det">
                                                @foreach($checkout->crowdfundCheckoutItems as $checkoutItem)
                                                <a href="javascript:void(0)">
                                                    {{($checkoutItem->type=='donation' ? 'Donation' : '')}}
                                                    {{$checkoutItem->name.' '.$currencySymbol.number_format($checkoutItem->price, 2)}}
                                                    {{($checkoutItem->delivery_cost ? ' - Delivery: '.$currencySymbol.number_format($checkoutItem->delivery_cost, 2) : '')}}
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="sub_sec_date_contain">
                                            {{date("d/m/y", strtotime($checkout->created_at))}} - {{$currencySymbol.number_format($checkout->amount)}}
                                        </div>
                                    </div>
                                    <div class="upper_sec">
                                        <div class="sub_sec_img_contain">&nbsp;</div>
                                        <div class="sub_sec_btns_contain">
                                            <a class="contact_btn" data-checkout="{{$checkout->id}}" data-find-type="checkout_user">Contact Details</a>
                                        </div>
                                        <div class="sub_sec_date_contain fake_date_sec_contain"></div>
                                    </div>
                                    @if($class == 'badge_error')
                                        <div data-id="{{$checkout->id}}" class="payment_response_outer">
                                            <div class="payment_response_upper">
                                                This payment has failed with a decline code <a class="pay_response_link" target="_blank" href="https://stripe.com/docs/declines/codes">{{$checkout->error}}</a><br>
                                                Click <a class="pay_response_link" href="{{route('payment.failed.retry', ['id' => $checkout->id])}}">here</a> to let us help you complete this payment.
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner Bonus_Donators">
                        <h3>
                            <span class="head_text">My premium videos</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                            <div class="my_sub_sec_list clearfix">
                            @foreach(\App\Models\UserLiveStream::all() as $key => $liveStream)
                                @if(Auth::user()->canWatchLiveStream($liveStream->id))
                                @php $streamYoutubeId = $commonMethods->getYoutubeIdFromUrl($liveStream->url) @endphp
                                @php $streamYoutubeTitle = $commonMethods->getVideoTitle($streamYoutubeId); @endphp
                                @php $imgSrc = $liveStream->thumbnail && $liveStream->thumbnail != '' ? asset('user-stream-thumbnails/'.$liveStream->thumbnail) : 'https://i.ytimg.com/vi/'.$streamYoutubeId.'/mqdefault.jpg' @endphp
                                <div class="music_btm_list clearfix">
                                    <div class="m_btm_list_left">
                                        <img src="{{$imgSrc}}" alt="#">
                                        <ul class="music_btm_img_det">
                                            <li><a target="_blank" href="{{$liveStream->user && $liveStream->user->username ? route('user.home.tab', ['params' => $liveStream->user->username, 'tab' => '5']) : 'javascript:void(0)'}}">{{$streamYoutubeTitle}}</a></li>
                                            <li>
                                                <p></p>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="m_btm_right_icons">
                                        <ul>
                                            <li>
                                                <a target="_blank" title="Watch" href="{{$liveStream->user && $liveStream->user->username ? route('user.home.tab', ['params' => $liveStream->user->username, 'tab' => '5']) : 'javascript:void(0)'}}" class="m_btn_right_icon_each active">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                            </div>
                        </div>

                    </div>
                </div>
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner">
                        <h3>
                            <span class="head_text">My subscriptions</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                            @foreach($user->artistSubscriptions as $stripeSubscription)
                                @php $currencySymbol = $commonMethods->getCurrencySymbol($stripeSubscription->plan_currency) @endphp
                                @php $userImage = $commonMethods->getUserDisplayImage($stripeSubscription->user->id) @endphp
                                @if($stripeSubscription->user)
                                    <div class="my_sub_sec_list clearfix">
                                        <div class="sub_left_img">
                                            <span>
                                                <img src="{{$userImage}}" alt="{{'Subscribed to '.$stripeSubscription->user->name}}" />
                                            </span>
                                        </div>
                                        <div class="sub_right_sec my_date_sec">
                                            <a href="javascript:void(0)">
                                                {{$currencySymbol.number_format($stripeSubscription->plan_amount, 2).'/'.$stripeSubscription->plan_interval.' - '.date('d/m/Y', strtotime($stripeSubscription->created_at)) }}
                                            </a>
                                        </div>

                                        <div class="sub_right_sec my_sub_right_sec">
                                            <a href="{{$stripeSubscription->user && $stripeSubscription->user->username ? route('user.home', ['params' => $stripeSubscription->user->username]) : 'javascript:void(0)'}}">{{$stripeSubscription->user->name}}</a>
                                        </div>
                                        <div class="sub_button_sec clearfix">
                                        	<label class="no_back"><input data-find="{{$stripeSubscription->id}}" data-find-type="subscription_offers" data-identity="{{$user->id}}" data-identity-type="subscription_customer" type="button" value="Details" class="details_subscription" /></label>
                                            <label class="cancel_subscription no_back" data-identity="{{$stripeSubscription->id}}"><input type="button" value="Cancel Subscription" /></label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if(!$user->is_buyer_only)
        <div id="my_sales_section" class="sub_cat_data {{$subTab == 'sales' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage Your Sales</div>
            </div>
            <div class="each_tab_content">

                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner Bonus_Donators">
                        <h3>
                            <span class="head_text">My crowdfund sales</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                            @foreach($crowdfundSales as $checkout)
                            @if($checkout->customer)
                            @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                            @php $customerImage = $commonMethods->getUserDisplayImage($checkout->customer->id) @endphp
                            @if($checkout->stripe_charge_id)
                                @php $class = 'badge_success' @endphp
                            @elseif($checkout->paypal_order_id)
                                @php $class = 'badge_success' @endphp
                            @elseif($checkout->error)
                                @php $class = 'badge_error' @endphp
                            @elseif($checkout->amount == 0)
                                @php $class = 'badge_free' @endphp
                            @else
                                @php $class = 'badge_warning' @endphp
                            @endif
                                <div class="my_sub_sec_list clearfix">
                                    <div class="upper_sec">
                                        <div class="sub_sec_img_contain smart_badge {{$class}}">
                                            <img title="{{$checkout->customer_name.' purchased from you'}}" src="{{$customerImage}}" alt="" />
                                            <div class="smart_badge_txt">
                                                @if($class == 'badge_success')
                                                    <i class="fa fa-check-circle"></i> Paid
                                                @elseif($class == 'badge_warning')
                                                    <i class="fa fa-clock-o"></i> Will Pay
                                                @elseif($class == 'badge_free')
                                                    <i class="fa fa-clock-o"></i> Free
                                                @else
                                                    <i class="fa fa-exclamation-triangle"></i> Failed
                                                @endif
                                            </div>
                                        </div>
                                        <div class="sub_sec_name_desc_contain">
                                            <div class="sub_sec_name"><a href="#">{{$checkout->customer_name}}</a></div>
                                            <div class="sub_sec_desc">{{$checkout->comment}}</div>
                                            <div class="sub_sec_det">
                                                @foreach($checkout->crowdfundCheckoutItems as $checkoutItem)
                                                <a href="javascript:void(0)">
                                                    {{($checkoutItem->type=='donation' ? 'Donation' : '')}}
                                                    {{$checkoutItem->name.' '.$currencySymbol.number_format($checkoutItem->price, 2)}}
                                                    {{($checkoutItem->delivery_cost ? ' - Delivery: '.$currencySymbol.number_format($checkoutItem->delivery_cost, 2) : '')}}
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="sub_sec_date_contain">
                                            {{date("d/m/y", strtotime($checkout->created_at))}} -  {{$currencySymbol.number_format($checkout->amount)}}
                                        </div>
                                    </div>
                                    <div class="upper_sec">
                                        <div class="sub_sec_img_contain">&nbsp;</div>
                                        <div class="sub_sec_btns_contain">
                                            <a class="contact_btn" data-checkout="{{$checkout->id}}" data-find-type="checkout_customer">Contact Details</a>
                                        </div>
                                        <div class="sub_sec_date_contain fake_date_sec_contain">
                                            <label>
                                                <input data-identity="{{$checkout->id}}" data-identity-type="checkout_user" type="submit" value="Send Thank You" class="send_thankyou" />
                                            </label>
                                        </div>
                                    </div>
                                    @if($class == 'badge_error')
                                        <div data-id="{{$checkout->id}}" class="payment_response_outer">
                                            <div class="payment_response_upper">
                                                This payment has failed with a decline code <a class="pay_response_link" target="_blank" href="https://stripe.com/docs/declines/codes">{{$checkout->error}}</a><br>
                                                Your customer has been notified about this error. However you can resend notification to your customer at <a class="pay_response_link notif_customer notif_at_email" href="javascript:void(0)">email address</a> | <a class="pay_response_link notif_customer notif_at_account" href="javascript:void(0)">1Platform account</a>
                                                <span class="hide_on_desktop">
                                                    | <a class="pay_response_link notif_customer notif_at_whatsapp" href="javascript:void(0)">WhatsApp</a>
                                                </span>. The notification contains a retry button to retry this payment with required information
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner">
                        <h3>
                            <span class="head_text">My subscribers and donators</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                            @foreach($stripeSubscriptions as $stripeSubscription)
                                @php $currencySymbol = $commonMethods->getCurrencySymbol($stripeSubscription->plan_currency) @endphp
                                @php $customerImage = $commonMethods->getUserDisplayImage($stripeSubscription->customer->id) @endphp
                                @if($stripeSubscription->customer)
                                    <div class="my_sub_sec_list clearfix">
                                        <div class="sub_left_img">
                                            <span>
                                                <img src="{{$customerImage}}" alt="{{$stripeSubscription->customer->name.' has subscribed you'}}" />
                                            </span>
                                        </div>
                                        <div class="sub_right_sec my_date_sec">
                                            <a href="javascript:void(0)">
                                                {{$currencySymbol.number_format($stripeSubscription->plan_amount, 2).'/'.$stripeSubscription->plan_interval.' - '.date('d/m/Y', strtotime($stripeSubscription->created_at)) }}
                                            </a>
                                        </div>

                                        <div class="sub_right_sec my_sub_right_sec">
                                            <a href="{{$stripeSubscription->customer && $stripeSubscription->customer->username ? route('user.home', ['params' => $stripeSubscription->customer->username]) : 'javascript:void(0)'}}">{{$stripeSubscription->customer->name}}</a>
                                        </div>
                                        <div class="sub_button_sec clearfix">
                                        	<label><input data-identity="{{$stripeSubscription->id}}" data-identity-type="subscription_user" type="submit" value="Send Thank You" class="send_thankyou" /></label>
                                            <label class="cancel_subscription no_back" data-identity="{{$stripeSubscription->id}}"><input type="button" value="Cancel Subscription" /></label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner Bonus_Donators">
                        <h3>
                            <span class="head_text">My sales</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                            @foreach($instantSales as $checkout)
                            @if(!($checkout->stripe_subscription_id && !$checkout->amount))
                            @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                            @php $customerImage = $commonMethods->getUserDisplayImage($checkout->customer ? $checkout->customer->id : 0) @endphp
                            @if($checkout->stripe_charge_id)
                                @php $class = 'badge_success' @endphp
                            @elseif($checkout->paypal_order_id)
                                @php $class = 'badge_success' @endphp
                            @elseif($checkout->error)
                                @php $class = 'badge_error' @endphp
                            @elseif($checkout->amount == 0)
                                @php $class = 'badge_free' @endphp
                            @else
                                @php $class = 'badge_warning' @endphp
                            @endif
                            <div class="my_sub_sec_list clearfix">
                                <div class="upper_sec">
                                    <div class="sub_sec_img_contain smart_badge {{$class}}">
                                        <img class="trans_image" title="{{$checkout->customer_name}}" src="{{$customerImage}}" alt="#" />
                                        <div class="smart_badge_txt">
                                            @if($class == 'badge_success')
                                                <i class="fa fa-check-circle"></i> Paid
                                            @elseif($class == 'badge_warning')
                                                <i class="fa fa-clock-o"></i> Will Pay
                                            @elseif($class == 'badge_free')
                                                <i class="fa fa-clock-o"></i> Free
                                            @else
                                                <i class="fa fa-exclamation-triangle"></i> Failed
                                            @endif
                                        </div>
                                    </div>
                                    <div class="sub_sec_name_desc_contain">
                                        <div class="sub_sec_name">
                                            <a class="trans_name" href="{{$checkout->customer && $checkout->customer->username ? route('user.home', ['params' => $checkout->customer->username]) : 'javascript:void(0)'}}">{{$checkout->customer_name}}</a>
                                        </div>
                                        <div class="sub_sec_desc">{{$checkout->comment}}</div>
                                        <div class="sub_sec_det">
                                            @foreach($checkout->instantCheckoutItems as $checkoutItem)
                                                @if($checkoutItem->type == 'music') @php $info = '('.$checkoutItem->license.')' @endphp
                                                @elseif($checkoutItem->type == 'donation_goalless') @php $info = 'Donation' @endphp
                                                @elseif($checkoutItem->type == 'custom-product') @php $info = ' (Your commission)' @endphp
                                                @else @php  $info = '' @endphp
                                                @endif
                                                <a href="javascript:void(0)">
                                                    {{$checkoutItem->name.$info.' '}}
                                                    @if($checkoutItem->type == 'custom-product')
                                                    	{{$currencySymbol.number_format($checkout->amount - ($checkout->application_fee + $checkout->stripe_fee + $checkout->delivery_cost), 2)}}
                                                        @if($checkoutItem->size != 'None')
                                                            <br>{{$checkoutItem->quantity.' x '.$checkoutItem->size.' - '.$checkoutItem->color}}
                                                        @else
                                                            <br>{{$checkoutItem->quantity.' x '.$checkoutItem->color}}
                                                        @endif
                                                    @else
                                                    	{{($checkoutItem->price>0)?$currencySymbol.number_format($checkoutItem->price, 2):' - Free'}}
                                                    @endif

                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="sub_sec_date_contain">
                                        {{date("d/m/y", strtotime($checkout->created_at))}} - {{$currencySymbol.number_format($checkout->amount, 2)}}
                                    </div>
                                </div>
                                <div class="upper_sec">
                                    <div class="sub_sec_img_contain">&nbsp;</div>
                                    <div class="sub_sec_btns_contain">
                                        <a data-checkout="{{$checkout->id}}" data-find-type="checkout_customer" class="contact_btn">Contact Details</a>
                                    </div>
                                    @if($checkout->stripe_payment_id)
                                    <div class="sub_sec_btns_contain transaction_btn">
                                        <a class="contact_btn" target="_blank" href="{{'https://dashboard.stripe.com/payments/'.$checkout->stripe_payment_id}}">
                                            Transaction ID: {{'TSN_'.$checkout->id}}
                                        </a>
                                    </div>
                                    @endif
                                    @if($checkout->paypal_order_id)
                                    <div class="sub_sec_btns_contain transaction_btn">
                                        <a class="contact_btn" target="_blank" href="{{'https://www.paypal.com/activities'}}">
                                            Transaction ID: {{'TSN_'.$checkout->id}}
                                        </a>
                                    </div>
                                    @endif
                                    <div class="sub_sec_date_contain fake_date_sec_contain">
                                        <label>
                                            <input data-identity="{{$checkout->id}}" data-identity-type="checkout_user" type="submit" value="Send Thank You" class="send_thankyou" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @if($user->expert && $user->apply_expert == 2)
                <div class="my_sub_sec">
                    <div class="my_sub_sec_inner Bonus_Donators">
                        <h3>
                            <span class="head_text">My agency</span>
                            <i class="fa fa-angle-down orders_bottom_arrow"></i>
                        </h3>
                        <div class="profile_orders_slide_win">
                        	@if($agentTransfers && count($agentTransfers))
	                            @foreach($agentTransfers as $transfer)
                                    @php $details = $transfer->decodeDescription() @endphp
		                            @php $currencySymbol = $commonMethods->getCurrencySymbol(strtoupper($transfer->currency)) @endphp
                                        @php $sellerImage = $commonMethods->getUserDisplayImage($details['seller']['id']) @endphp
                                        @if($transfer->stripe_transfer_id)
                                            @php $class = 'badge_success' @endphp
                                        @elseif($transfer->error)
                                            @php $class = 'badge_error' @endphp
                                        @else
                                            @php $class = 'badge_warning' @endphp
                                        @endif
                                        <div class="my_sub_sec_list clearfix">
                                            <div class="upper_sec">
                                                <div class="sub_sec_img_contain smart_badge {{$class}}">
                                                    <img class="trans_image" title="{{$details['seller']['name']}}" src="{{$sellerImage}}" />
                                                    <div class="smart_badge_txt">
                                                        @if($class == 'badge_success')
                                                            <i class="fa fa-check-circle"></i> Paid
                                                        @elseif($class == 'badge_warning')
                                                            <i class="fa fa-clock-o"></i> Queued
                                                        @else
                                                            <i class="fa fa-exclamation-triangle"></i> Failed
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="sub_sec_name_desc_contain">
                                                    <div class="sub_sec_name">
                                                        <a class="trans_name" href="javascript:void(0)">
                                                            {{$details['seller']['name']}}
                                                        </a>
                                                    </div>
                                                    <div class="sub_sec_desc"></div>
                                                    <div class="sub_sec_det">
                                                        <a href="javascript:void(0)">
                                                            Buyer: {{$details['buyer']['name']}}<br>
                                                            {{date('d/m/Y h:s A', strtotime($transfer->created_at))}}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="sub_sec_date_contain">
                                                    Your Commission {{$currencySymbol}}{{number_format(($transfer->amount/100), 2)}}
                                                </div>
                                            </div>
                                            <div class="upper_sec">
                                                <div class="sub_sec_img_contain">&nbsp;</div>
                                                @if($status && $transfer->stripe_transfer_id)
                                                <div class="sub_sec_btns_contain">
                                                    <a target="_blank" href="https://dashboard.stripe.com/payments" class="contact_btn downloadable">View on Stripe</a>
                                                </div>
                                                @elseif($transfer->error)
                                                <div class="payment_response_outer">
                                                    <div class="payment_response_upper">
                                                        The transfer to you has failed with an error message <a class="pay_response_link" href="javascript:void(0)">{{$transfer->error}}</a><br>
                                                        Please contact us at admin@1platform.tv for more information
                                                    </div>
                                                </div>
                                                @else
                                                <div class="payment_response_outer">
                                                    <div class="payment_response_upper">
                                                        The money will be be transferred to you soon.
                                                        Please contact us at admin@1platform.tv in case you need more assistance
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
	                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div id="summary_section" class="sub_cat_data  {{$subTab == 'summary' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Financial Summary</div>
            </div>
            <div class="order_tp_sec clearfix">
                <div class="inside_notic_sec">
                    <div class="inside_notic_left clearfix">

                        <div class="inside_notic_head">
                            <label>My Insights</label>
                        </div>
                        <div class="inside_notic_body">
                            <div class="ins_not_left">
                                <p>Singles Sold (inc free)</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $purchaseParticulars['singles_sold'] }}</p>
                            </div>
                            <div class="ins_not_left">
                                <p>Albums Sold</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $purchaseParticulars['albums_sold'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="inside_notic_right clearfix">
                        <div class="inside_notic_head">
                            <label>&nbsp;</label>
                        </div>
                        <div class="inside_notic_body">
                            <div class="ins_not_left">
                                <p>Products Sold</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $purchaseParticulars['products_sold'] }}</p>
                            </div>
                            <div class="ins_not_left">
                                <p>Total of Revenue</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ number_format($purchaseParticulars['total_revenue'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inside_notic_sec inside_notic_sec2 mCustomScrollbar">

                    <div class="inside_notic_left clearfix">

                        <div class="inside_notic_head">
                            <label>My Crowdfunder Updates</label>
                        </div>
                        <div class="inside_notic_body">
                            <div class="ins_not_left">
                                <p>Target Goal</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $userCampaignDetails['campaignGoal'] }}</p>
                            </div>
                            <div class="ins_not_left">
                                <p>Amount Raised</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised'] }}</p>
                            </div>
                            <div class="ins_not_left">
                                <p>Fans</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $userCampaignDetails['campaignDonators'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="inside_notic_right clearfix">

                        <div class="inside_notic_head">
                            <label>My Bonuses</label>
                        </div>
                        <div class="inside_notic_body profile_order_scroll">
                            @foreach($userCampaign->perks as $perk)
                            <div class="ins_not_left">
                                <p>{{ $perk->title }}</p>
                            </div>
                            <div class="ins_not_right">
                                <p>{{ $perk->items_claimed }}/{{ $perk->items_available }}</p>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($stripeUrl !="")

        @else

        <!--<br><br>
        <div class="order_tp_sec clearfix">
            <a target="_blank" class="pro_stript_btn connected" href="https://dashboard.stripe.com"></a>
        </div>!-->

        @endif
    </div>
</div>

<link rel="stylesheet" href="{{asset('css/profile.orders.css')}}">

<script type="text/javascript">
    function prepareDownloadPopup(downloads, sourceId){
        var downloadArray = downloads.split('#');
        if(downloadArray.length){
            for (var i = downloadArray.length - 1; i >= 0; i--) {
                if(downloadArray[i] != ''){
                    var eachDownload = downloadArray[i];
                    var downloadDetailArray = eachDownload.split('::');
                    var target = $('.music_zip_download_popup .pro_pop_download_each[data-type="'+downloadDetailArray[1]+'"]');
                    if(target.length){
                        if(downloadDetailArray[3] == 'cloud'){
                            target.attr('data-path', downloadDetailArray[0]);
                        }else{
                            target.attr('data-path', downloadDetailArray[4]);
                        }

                        target.attr('data-source', downloadDetailArray[3]);
                        target.attr('data-source-id', sourceId);
                        target.find('.item_size').text(Math.round(downloadDetailArray[2]/(1024*1024))+' MB');
                        target.removeClass('instant_hide');
                    }
                }

                $('.pro_page_pop_up').hide();
                $('.music_zip_download_popup,#body-overlay').show();
            }
        }
    }

    $('document').ready(function(){

        $('.pro_pop_download_each').click(function(){

            if($(this).attr('data-path') != '' && $(this).attr('data-source-id') != ''){

            	var browserWidth = $(window).width();

                if($(this).attr('data-source') == 'local'){

                	var dLink = '/downLoadMusicFile/'+$(this).attr('data-path')+'/'+$(this).attr('data-source-id');
                }else{

                	var dLink = '/google-cloud/file/download-as-stream/'+$(this).attr('data-path')+'/'+$(this).attr('data-source-id');
                }

                window.location.href = dLink;
            }
        });
        $('#close_download').click(function(){

            $('.music_zip_download_popup,#body-overlay').hide();
        });

        $('.int_sub_down').click(function(e){

        	e.preventDefault();
        	$('#internal_sub_unsub_popup, #body-overlay').show();
        });

        $('.notif_customer').click(function(){

            var id = $(this).closest('.payment_response_outer').attr('data-id');
            if($(this).hasClass('notif_at_email')){
                var text = 'Do you want to send email notification?';
                var type = 'email';
            }else if($(this).hasClass('notif_at_account')){
                var text = 'Do you want to send notification to 1Platform account?';
                var type = 'account';
            }else if($(this).hasClass('notif_at_whatsapp')){
                var text = 'Do you want to send notification to WhatsApp?';
                var type = 'whatsapp';
            }else{
                var text = '';
            }

            if(text != '' && id != ''){
                if(confirm(text)){
                   var formData = new FormData();
                   formData.append('id', id);
                   formData.append('type', type);
                   $.ajax({
                        url: '/payment-failed-notification',
                        type: 'POST',
                        data: formData,
                        contentType:false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            if(response.success){
                                location.reload();
                            }else{
                                alert(response.error);
                            }
                        }
                   });
                }
            }
        });
    });
</script>
