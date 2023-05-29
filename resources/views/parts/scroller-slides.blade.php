

<div class="hm_lst_slid_outer">

    <div class="auto_content">

        <div class="hm_lst_slid_inner clearfix">

            <div id="owl-demo" class="owl-carousel owl-theme">
                
                @foreach($scrollerSlides as $key => $slide)

                    
                    
                    @if( $slide->type == "user" and $slide->user and $slide->user->active == '1' and $slide->user->private == NULL )

                        <?php 
                            $sliderUserCampaignDetails = $commonMethods->getUserRealCampaignDetails($slide->user->id); 
                            $sliderUserPersonalDetails = $commonMethods->getUserRealDetails($slide->user->id);
                            if($sliderUserCampaignDetails['campaignIsLive'] == '1' && $sliderUserCampaignDetails['campaignStatus'] == 'active'){
                                $hasCrowdFunds = 1;
                                $link = $sliderUserCampaignDetails['campaignUserInfo']['projectPage'];
                            }else{
                                $hasCrowdFunds = 0;
                                $link = $sliderUserCampaignDetails['campaignUserInfo']['homePage'];
                            }
                        ?>

                        <div class="hm_vid_list item" onclick="window.location.href='{{$link}}'">

                            <span><img src="{{ $commonMethods->getUserDisplayImageSlider($slide->user->id) }}" alt="#" /></span>

                            <div class="vid_lidt_det">

                                <a class="vid_list_name" href="#">{{ $slide->user->name }}</a>

                                <!--<p class="vid_list_title">{{ str_limit ( $sliderUserCampaignDetails['campaignTitle'], 25) }}</p>!-->

                                <ul>

                                    <li>

                                        <span class="vid_list_raise" style="background-image: url({{$hasCrowdFunds?$sliderUserCampaignDetails['campaignPercentImage']:asset('images/rsz_shop_bag.png')}})">
                                            @if($hasCrowdFunds)
                                                {{$sliderUserCampaignDetails['campaignCurrencySymbol'].$sliderUserCampaignDetails['amountRaised']}} <!--<span class="hide_ex_sm">raised</span>!-->
                                            @else
                                                Store
                                            @endif
                                        </span>

                                    </li>

                                    <li>

                                        <span class="vid_list_cart">{{ $sliderUserCampaignDetails['campaignProducts'] }} @if ($sliderUserCampaignDetails['campaignProducts'] > 1) products @else product @endif</span>

                                    </li>



                                </ul>

                            </div>



                            <div class="vid_list_hvr_outer">

                                <div class="vid_list_hvr_inner">

                                    <div class="vid_list_hvr">

                                        <ul>

                                            <li style="color: #fff;"><a href="#">{{  $sliderUserCampaignDetails['campaignTitle'] }}</a></li>

                                        </ul>



                                        <div style="color: #fff;">{!! $sliderUserPersonalDetails['storyText'] !!}</div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @elseif( $slide->type == "stream" )

                        @if(!$slide->stream || $slide->stream->youtube_id == '') @php continue @endphp @endif

                        <div class="hm_vid_list item" onclick="window.location.href='{{ asset("tv?video=" . $slide->stream->id) }}'">

                            <span><img src="https://i.ytimg.com/vi/{{$slide->stream->youtube_id}}/mqdefault.jpg" alt="#" /></span>

                            <div class="vid_lidt_det">

                                <a class="vid_list_name" href="#">{{ str_limit( $slide->stream->name, 25) }}</a>

                                <p class="vid_list_title">{{ str_limit( $slide->stream->channel->title, 25) }}</p>

                                <ul>

                                    <li>

                                        <!--<p>{{ date("d M Y h:i A", strtotime($slide->stream->created_at)) }}</p>!-->

                                    </li>



                                </ul>

                            </div>



                            <div class="vid_list_hvr_outer">

                                <div class="vid_list_hvr_inner">

                                    <div class="vid_list_hvr">

                                        <ul>

                                            <li style="color: #fff;">{{$slide->stream->name}}</li>

                                        </ul>



                                        <p style="color: #fff;">{{ $commonMethods->stripHtmlTags($slide->description) }}</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach
            </div>
        </div>
    </div>
</div>