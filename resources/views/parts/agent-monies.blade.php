@if($id == 'my-subscription-plan')

    @php
        $upcomingInvoice = null;
    @endphp

    <div class="my_sub_sec_inner">
        <h3><span class="head_text text-lg">My subscription plan</span></h3>
    </div>
    <div class="mt-5">
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
                                <a href="javascript:void(0)">Change Plan</a>
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
@elseif($id == 'my-purchases')
    @php
        $instantPurchases = \App\Models\StripeCheckout::where('customer_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
    @endphp
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="head_text text-lg">My purchases</span></h3>
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

        $('.purchase_download').click(function(){

            var thiss = $(this);
            var href = thiss.attr('href');
            if(href == '' || href == 'javascript:void(0)'){
                var checkoutItem = thiss.attr('data-checkout-item');
                var download = thiss.attr('data-download');
                var downloadAs = thiss.parent().parent().parent().find('.my_purchase_sec a').first().text();
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
        });
    </script>
@elseif($id == 'my-premium-videos')
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="head_text text-lg">My premium videos</span></h3>
        </div>
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
@elseif($id == 'my-subscriptions')
    <div class="mt-5">
        <div class="my_sub_sec_inner">
            <h3><span class="head_text text-lg">My subscriptions</span></h3>
        </div>
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
        <script>
            $(".cancel_subscription").click(function(){

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

            $(".details_subscription").click(function(){

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
        </script>
    </div>
@endif

<link rel="stylesheet" href="{{asset('css/profile.orders.css')}}">
