@if($id == 'my-subscription-plan')

    @php
        $upcomingInvoice = null;
    @endphp

    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My subscription plan</span></h3>
        </div>
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
                                <a href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}" class="text-white bg-[#007bff] p-[0.5rem] text-center rounded mt-1">Upgrade Plan</a>
                            </div>
                            @endif

                            @if($package && ($package[0] == 'gold' || $package[0] == 'platinum'))
                            <div class="flex flex-col gap-2">
                                @if($user->internalSubscription->cancel_at)
                                <div class="int_sub_down">
                                    <div class="text-black bg-[#ffc107] p-[0.5rem] text-center rounded mt-1 cursor">Cancellation Scheduled</div>
                                </div>
                                @else
                                <div class="int_sub_down">
                                    <a href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}" class="text-white bg-[#007bff] p-[0.5rem] text-center rounded mt-1">Change Plan</a>
                                </div>
                                <div class="int_sub_down">
                                    <div data-id="{{$user->internalSubscription->id}}" class="cancel-subscription text-white bg-[#ff5649] px-[0.5rem] py-[0.35rem] text-center rounded mt-1 cursor-pointer">Cancel Plan</div>
                                </div>
                                @endif
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
                        @if($user->internalSubscription->cancel_at)
                        <div class="curr_sub_det_each">
                            Cancel Date: <span class="hide_on_desktop"><br></span>
                            {{date('d/m/Y', strtotime($user->internalSubscription->cancel_at))}}
                        </div>
                        @endif
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
@elseif($id == 'my-purchases')
    @php
        $instantPurchases = \App\Models\StripeCheckout::where('customer_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
    @endphp
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My purchases</span></h3>
        </div>
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
                <div class="clearfix my_sub_sec_list my_purchase_list">
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
                        @php
                            $class = 'purchase_download';
                        @endphp
                    @endif
                    <div class="clearfix sub_button_sec my_purchases_dwnload">
                        <label>
                            <a class="{{$class}}" data-download-url="{{$checkoutItem->download_url}}" data-download="{{$checkoutItem->type}}" data-checkout-item="{{$checkoutItem->id}}" data-sourcet="{{$checkoutItem->source_table_id}}" href="{{$link}}"> Download <i class="fa fa-download"></i></a>
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
    <script>
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

        $('body').delegate( ".pro_pop_download_each", "click", function(e){

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

        $('body').delegate( "#close_download", "click", function(e){

            $('.music_zip_download_popup,#body-overlay').hide();
        });

        $('.int_sub_down').click(function(e){

            e.preventDefault();
            $('#internal_sub_unsub_popup, #body-overlay').show();
        });

        $('body').delegate( ".purchase_download", "click", function(e){

            var thiss = $(this);
            var href = thiss.attr('href');
            if(href == '' || href == 'javascript:void(0)'){
                var checkoutItem = thiss.attr('data-checkout-item');
                var download = thiss.attr('data-download');
                var downloadUrl = thiss.attr('data-download-url');
                var downloadAs = thiss.parent().parent().parent().find('.my_purchase_sec a').first().text();

                if(downloadUrl != null) {
                    window.open(downloadUrl, '_blank');
                } else {
                    $('#body-overlay,.pro_initiating_download').show();
                    $.ajax({

                        url: '/prepare-zip',
                        type: 'POST',
                        data: {'type': download, 'user': '{{Auth::user()->id}}', 'checkout_item': checkoutItem, 'download_as': downloadAs},
                        cache: false,
                        dataType: 'json',
                        success: function (response) {

                            $('#body-overlay,.pro_initiating_download').hide();
                            if(response.success == 1 && response.download_link != ''){
                                window.location.href = response.download_link;
                            }else if(response.success == 1 && response.cloud_download != ''){
                                prepareDownloadPopup(response.cloud_download, thiss.attr('data-sourcet'));
                            }
                        }
                    });
                }
            }
        });
    </script>
@elseif($id == 'my-premium-videos')
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My premium videos</span></h3>
        </div>
        @foreach(\App\Models\UserLiveStream::all() as $key => $liveStream)
            @if(Auth::user()->canWatchLiveStream($liveStream->id))
            @php $streamYoutubeId = $commonMethods->getYoutubeIdFromUrl($liveStream->url) @endphp
            @php $streamYoutubeTitle = $commonMethods->getVideoTitle($streamYoutubeId); @endphp
            @php $imgSrc = $liveStream->thumbnail && $liveStream->thumbnail != '' ? asset('user-stream-thumbnails/'.$liveStream->thumbnail) : 'https://i.ytimg.com/vi/'.$streamYoutubeId.'/mqdefault.jpg' @endphp
            <div class="clearfix music_btm_list">
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
@elseif($id == 'my-subscriptions')
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My subscriptions</span></h3>
        </div>
        @foreach($user->artistSubscriptions as $stripeSubscription)
            @php $currencySymbol = $commonMethods->getCurrencySymbol($stripeSubscription->plan_currency) @endphp
            @php $userImage = $commonMethods->getUserDisplayImage($stripeSubscription->user->id) @endphp
            @if($stripeSubscription->user)
                <div class="clearfix my_sub_sec_list">
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
                    <div class="clearfix sub_button_sec">
                        <label class="no_back"><input data-find="{{$stripeSubscription->id}}" data-find-type="subscription_offers" data-identity="{{$user->id}}" data-identity-type="subscription_customer" type="button" value="Details" class="details_subscription" /></label>
                        <label class="cancel_subscription no_back" data-identity="{{$stripeSubscription->id}}"><input type="button" value="Cancel Subscription" /></label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@elseif($id == 'my-sales')
    @php
        $instantSales = \App\Models\StripeCheckout::where('user_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
    @endphp
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My sales</span></h3>
        </div>
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
            <div class="clearfix my_sub_sec_list">
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
@elseif($id == 'my-crowdfund-purchases')
    @php
        $crowdfundPurchases = \App\Models\StripeCheckout::where('customer_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
    @endphp
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My crowdfund purchases</span></h3>
        </div>
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
                <div class="clearfix my_sub_sec_list">
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
@elseif($id == 'my-crowdfund-sales')
    @php
        $crowdfundSales = \App\Models\StripeCheckout::where('user_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
    @endphp
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My crowdfund sales</span></h3>
        </div>
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
                <div class="clearfix my_sub_sec_list">
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
@elseif($id == 'my-subscribers-donators')
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="text-lg head_text">My subscribers and donators</span></h3>
        </div>
        @foreach($user->stripe_subscriptions as $stripeSubscription)
            @php $currencySymbol = $commonMethods->getCurrencySymbol($stripeSubscription->plan_currency) @endphp
            @php $customerImage = $commonMethods->getUserDisplayImage($stripeSubscription->customer->id) @endphp
            @if($stripeSubscription->customer)
                <div class="clearfix my_sub_sec_list">
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
                    <div class="clearfix sub_button_sec">
                        <label><input data-identity="{{$stripeSubscription->id}}" data-identity-type="subscription_user" type="submit" value="Send Thank You" class="send_thankyou" /></label>
                        <label class="cancel_subscription no_back" data-identity="{{$stripeSubscription->id}}"><input type="button" value="Cancel Subscription" /></label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@elseif($id == 'financial-summary')
    @php
        $instantPurchases = \App\Models\StripeCheckout::where('customer_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
        $instantSales = \App\Models\StripeCheckout::where('user_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
        $crowdfundPurchases = \App\Models\StripeCheckout::where('customer_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
        $crowdfundSales = \App\Models\StripeCheckout::where('user_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
        $topSales = \App\Models\StripeCheckout::where('user_id', $user->id)->orderBy('id' , 'desc')->take(5)->get();

        $singlesSold = $albumsSold = $totalRevenue = $productsSold = 0;
        $fans = [];
        foreach ($instantSales as $key => $checkout) {
            foreach ($checkout->instantCheckoutItems as $key => $instantCheckoutItem) {

                if($instantCheckoutItem->type == 'music'){
                    $singlesSold++;
                }
                if($instantCheckoutItem->type == 'album'){
                    $albumsSold++;
                }
                if($instantCheckoutItem->type == 'product'){
                    $productsSold++;
                }
                if($instantCheckoutItem->type == 'custom-product'){
                    $productsSold++;
                }
                if($checkout->customer && !in_array($checkout->customer->id, $fans)){
                	$fans[] = $checkout->customer->id;
                }
            }

            $checkAmount = $checkout->application_fee ? $checkout->amount - $checkout->application_fee : $checkout->amount;
            $totalRevenue += $commonMethods->convert($checkout->currency, strtoupper($user->profile->default_currency), $checkAmount);
        }
        foreach ($crowdfundSales as $key => $checkout) {

            if($checkout->stripe_charge_id){

                $totalRevenue += $commonMethods->convert($checkout->currency, strtoupper($user->profile->default_currency), $checkout->amount);
            }
            if($checkout->customer && !in_array($checkout->customer->id, $fans)){
                $fans[] = $checkout->customer->id;
            }
        }

        $purchaseParticulars['fans'] = $fans;
        $purchaseParticulars['singles_sold'] = $singlesSold;
        $purchaseParticulars['albums_sold'] = $albumsSold;
        $purchaseParticulars['products_sold'] = $productsSold;
        $purchaseParticulars['total_revenue'] = $totalRevenue;
        $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id);
        $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();
    @endphp
    <div class="mt-5">
        <div class="inside_notic_sec">
            <div class="clearfix inside_notic_left">

                <div class="inside_notic_head flex justify-between items-center">
                    <label>My Insights</label>
                    <a href="https://dashboard.stripe.com/" target="_blank" class="no-underline bg-blue-600 text-white rounded-md text-center py-2 px-6 cursor-pointer">My Stripe Dashboard</a>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Singles Sold (inc free)</p>
                                <p class="text-sm text-gray-500 truncate">{{ $purchaseParticulars['singles_sold'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Albums Sold</p>
                                <p class="text-sm text-gray-500 truncate">{{ $purchaseParticulars['albums_sold'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Products Sold</p>
                                <p class="text-sm text-gray-500 truncate">{{ $purchaseParticulars['products_sold'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Total Revenue</p>
                                <p class="text-sm text-gray-500 truncate">{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ number_format($purchaseParticulars['total_revenue'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inside_notic_sec">
            <div class="clearfix inside_notic_left">
                <div class="inside_notic_head">
                    <label>My Crowdfunder Updates</label>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Target Goal</p>
                                <p class="text-sm text-gray-500 truncate">{{ $userCampaignDetails['campaignGoal'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Amount Raised</p>
                                <p class="text-sm text-gray-500 truncate">{{ $userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">Fans</p>
                                <p class="text-sm text-gray-500 truncate">{{ $userCampaignDetails['campaignDonators'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inside_notic_sec">
            <div class="clearfix inside_notic_left">

                <div class="inside_notic_head">
                    <label>My Bonuses</label>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach($userCampaign->perks as $perk)
                    <div class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="flex-1 min-w-0">
                            <div class="cursor-pointer focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">{{ $perk->title }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $perk->items_claimed }}/{{ $perk->items_available }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $('body').delegate( ".send_thankyou", "click", function(e){

        var thiss = $(this);

        var identity = thiss.attr('data-identity');
        var find = identity;
        var identityType = thiss.attr('data-identity-type');
        if(identityType == 'checkout_user'){
            var findType = 'thank_customer';
        }else if(identityType == 'subscription_user'){
            var findType = 'thank_subscriber';
        }

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': findType, 'find': find, 'identity_type': identityType, 'identity': identity},
            success: function(response) {
                if(response.success == 1){
                    var customer = response.data.id;
                    var email = response.data.email;
                    var name = response.data.name;
                    var userHomeLink = response.data.profilePageLink;
                    var originalImage = response.data.profileImageOriginal;

                    thank_you_user_name = name;
                    thank_you_user_id = customer;
                    thank_you_user_email = email;
                    thank_you_user_photo = originalImage;
                    thank_you_user_share_url = userHomeLink;
                    thank_you_type = identityType;
                    thank_you_id = identity;
                    type_id = '';
                    payment_type = '';

                    $(".soc_share_images").show();
                    $(".soc_share_buttons").show();
                    $(".email_box").hide();
                    $(".email_button").hide();
                    $('.pro_send_email_outer #thank_you_image').attr('src', thank_you_user_photo);
                    $(".pro_send_email_outer").show();
                    $('#body-overlay').show();
                }else{
                    alert(response.error);
                }
            }
        });
    });
    $('body').delegate( "#share_project_popup .hm_fb_icon_share", "click", function(e){

        var baseUrl = $('#base_url').val();
        var name = encodeURIComponent($(this).closest('#share_project_popup').attr('data-name'));
        var imageName = $(this).closest('#share_project_popup').attr('data-share-image');
        var elm = '/'+name+'/'+btoa(imageName);

        $('#url_share_link').val(baseUrl+'url-share/'+'project_'+window.currentUserId+elm);
        facebookShare('url');

    });

    $('body').delegate( "#share_project_popup .hm_tw_icon_share", "click", function(e){

        var baseUrl = $('#base_url').val();
        var name = encodeURIComponent($(this).closest('#share_project_popup').attr('data-name'));
        var imageName = $(this).closest('#share_project_popup').attr('data-share-image');
        var elm = '/'+name+'/'+btoa(imageName);

        $('#url_share_link').val(baseUrl+'url-share/'+'project_'+window.currentUserId+elm);
        twitterShare('url');
    });

    $('body').delegate( "#thank_via_email_btn", "click", function(e){

        $("#thankyou_email_text").text("");
        $(".soc_share_images").hide();
        $(".soc_share_buttons").hide();
        $(".email_box").show();
        $(".email_button").show();
    });

    $("#send_thankyou_email").click(function () {

        var message = $("#thankyou_email_text").val();

        if(message != ''){

            var formData = new FormData();
            formData.append('email', thank_you_user_email);
            formData.append('name', thank_you_user_name);
            formData.append('message', message);
            formData.append('type_id', type_id);
            formData.append('payment_type', payment_type);

            $.ajax({

                url: '/sendThanksEmail',
                type: "POST",
                data: formData,
                dataType: 'html',
                contentType:false,
                cache: false,
                processData: false,

                success: function(data){

                    $(".pro_send_email_outer").hide();
                    $('#body-overlay').hide();
                    $("#thankyou_email_text").val('');
                }
            });
        }
    });

    $("#facebook_share").click(function () {

        var baseUrl = $('#base_url').val();
        $('#url_share_user_name').val(thank_you_user_name);
        $('#url_share_link').val(baseUrl+'url-share/'+'profilethankyou_'+thank_you_user_id+'_'+window.currentUserId+'_'+thank_you_type+'_'+thank_you_id+'/'+encodeURIComponent('Thank You '+thank_you_user_name)+'/'+btoa(thank_you_user_photo));
        facebookShare('url');
    });

    $("#twitter_share").click(function () {

        var baseUrl = $('#base_url').val();
        $('#url_share_user_name').val(thank_you_user_name);
        $('#url_share_link').val(baseUrl+'url-share/'+'profilethankyou_'+thank_you_user_id+'_'+window.currentUserId+'_'+thank_you_type+'_'+thank_you_id+'/'+encodeURIComponent('Thank You '+thank_you_user_name)+'/'+btoa(thank_you_user_photo));
        twitterShare('url');
    });

    $('body').delegate( ".cancel_subscription", "click", function(e){

        if(confirm('Do you really want to end this subscription?')){
            var thiss = $(this);
            var identity = thiss.attr('data-identity');
            $.ajax({

                url: "/cancelSubscription",
                dataType: "json",
                type: 'post',
                data: {'id': identity},
                success: function(response) {
                    if(response.success == 1){
                        alert('Subscription has been sucessfully cancelled');
                        thiss.closest('.my_sub_sec_list').remove();
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('body').delegate( ".details_subscription", "click", function(e){

        var thiss = $(this);
        var identity = thiss.attr('data-identity');
        var identityType = thiss.attr('data-identity-type');
        var find = thiss.attr('data-find');
        var findType = thiss.attr('data-find-type');

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': findType, 'find': find, 'identity_type': identityType, 'identity': identity},
            success: function(response) {
                if(response.success == 1){

                    var image = response.data.image;
                    var heading = response.data.heading;
                    var bulletOne = response.data.bulletOne;
                    var bulletTwo = response.data.bulletTwo;
                    var bulletThree = response.data.bulletThree;

                    $('#subscription_offers_popup .profile_img').attr('src', image);
                    $('#subscription_offers_popup .profile_heading').text(heading);
                    $('#subscription_offers_popup .bullet_one').text(bulletOne);
                    $('#subscription_offers_popup .bullet_two').text(bulletTwo);
                    $('#subscription_offers_popup .bullet_three').text(bulletThree);

                    $('#subscription_offers_popup,#body-overlay').show();
                }else{
                    alert(response.error);
                }
            }
        });
    });

    $('body').delegate('.cancel-subscription', 'click', function(e){

        if(confirm('Do you want to cancel your subscription?')){
            $.ajax({
                url: '/cancel-user-plan',
                dataType: "json",
                type: 'post',
                data: {},
                success: function(response) {
                    location.reload();
                }
            });
        }
    });

    $('body').delegate( ".contact_btn:not(.downloadable)", "click", function(e){

        var thiss = $(this);
        var checkout = thiss.attr('data-checkout');
        var find = checkout;
        var findType = thiss.attr('data-find-type');

        if(findType == 'checkout_user'){
            var identityType = 'checkout_customer';
        }else if(findType == 'checkout_customer'){
            var identityType = 'checkout_user';
        }

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': findType, 'find': find, 'identity_type': identityType, 'identity': checkout},
            success: function(response) {
                if(response.success == 1){
                    var name = response.data.name;
                    var email = response.data.email;
                    if(identityType == 'checkout_user'){
                        var postcode = response.data.postcode;
                        var address = response.data.address;
                        var city = response.data.city;
                        var country = response.data.country;

                        $("#cont_popup_address").html(address+'<br>'+postcode+'<br>'+city+'<br>'+country);
                    }else{
                        $("#cont_popup_address").html('');
                    }

                    $("#cont_popup_name").text(name);
                    $("#cont_popup_email").text(email);
                    $("#contact_popup").show();
                    $('#body-overlay').show();
                }else{
                    alert(data.error);
                }
            }
        });
    });
</script>

<link rel="stylesheet" href="{{asset('css/profile.orders.css')}}">
