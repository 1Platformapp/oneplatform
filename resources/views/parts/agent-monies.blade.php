@if($id == 'my-subscription-plan')

    @php
        $upcomingInvoice = null;
    @endphp

    <div class="my_sub_sec_inner">
        <h3><span class="head_text text-lg">My subscription plan</span></h3>
    </div>
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

@endif

<link rel="stylesheet" href="{{asset('css/profile.orders.css')}}">
