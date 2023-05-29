<div class="btm_center_outer res_slider_outer">
        <div class="vetical_slide_sec">
            <ul class="bxslider">
                @foreach($verticalSliderItems as $key => $slide)
                    @if( $slide->type == "user" and $slide->user and $slide->user->active == '1' and $slide->user->private == NULL )
                        <?php $sliderUserCampaignDetails = $commonMethods->getUserCampaignDetails($slide->user->id); $sliderUserPersonalDetails = $commonMethods->getUserPersonalDetails($slide->user->id); ?>
                        <li onclick="window.location.href='{{ $sliderUserPersonalDetails['user_project_share_link'] }}'">
                            <div class="product_list_outer clearfix">
                                <div class="product_img_outer">
                                    <span><img src="{{ $commonMethods->getUserDisplayImageSliderVertical($slide->user->id) }}" alt="#" /></span>
                                </div>
                                <div class="product_det_outer">
                                    <label>{{ $slide->user->name }}</label>
                                    <b>{{ $sliderUserCampaignDetails['user_campaign_title'] }}</b>
                                    <div class="pro_rais_quant_otr clearfix">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="{{ asset('percent-images/'.$sliderUserCampaignDetails['user_campaign_amount_raised_percent'].'.png') }}" alt="#" /></a>
                                                <p>Raised {{ $sliderUserCampaignDetails['user_total_amount_raised'] }}</p>
                                            </li>
                                            <li>
                                                <a href="#"><img src="/images/sh_cart_icon.png" alt="#" /></a>
                                                <p>{{ $sliderUserCampaignDetails['user_total_products'] }} @if ($sliderUserCampaignDetails['user_total_products'] > 1) products @else product @endif</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @elseif( $slide->type == "stream" )
                    	@if(!$slide->stream) @php continue @endphp @endif
                        <li onclick="window.location.href='{{ asset("tv?video=" . $slide->stream->id) }}'">
                            <div class="product_list_outer clearfix">
                                <div class="product_img_outer">
                                    <span><img src="https://i.ytimg.com/vi/{{$slide->stream->youtube_id}}/mqdefault.jpg" alt="#" /></span>
                                </div>
                                <div class="product_det_outer">
                                    <label>{{$slide->stream->name}}</label>
                                    <b>{{$slide->stream->channel->title}}</b>
                                    <div class="pro_rais_quant_otr clearfix">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="/percent-images/default-percent.png" alt="#" /></a>
                                                <p>{{ date("d M Y h:i A", strtotime($slide->stream->created_at)) }}</p>
                                            </li>
                                            <li>
                                                <a class="live_now" href="#">Live Now </a>
                                                <p>Watch Now</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>