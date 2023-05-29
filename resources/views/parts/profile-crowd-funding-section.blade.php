
@php $display = 'display: block;' @endphp

@if($page != 'crowdfunds')
    @php $display = 'display: none;' @endphp
@endif
<div id="profile_tab_05" class="pro_your_proj_sec pro_pg_tb_det" style="{{ $display }}">
    <div class="pro_main_tray">
        <div class="pro_tray_title">Manage Crowdfund Project</div>
    </div>
    <div class="pro_inp_list_outer">
        <div class="pro_explainer_outer">
            <div class="pro_explainer_inner">
                <div data-explainer-file="{{base64_encode('1DoZTNHrp6IqoIh9tZnHz3hlhoodUb6T3')}}" data-explainer-title="Crowdfunding" data-explainer-description="Add crowdfund projects" class="pro_explainer_each">
                    <div class="pro_explainer_anim">
                        <i class="fa fa-caret-right"></i>
                    </div>
                    <div class="pro_explainer_body">
                        <div class="pro_explainer_title">
                            Crowdfund Video
                        </div>
                    </div>
                </div>
            </div>
            <div class="pro_explainer_video instant_hide">
                <div class="pro_explainer_video_contain">
                    <div id="jwp_crowdfund"></div>
                </div>
            </div>
        </div>
    </div>
    <form id="save_project_form" action="{{ route('save.user.project') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <div class="pro_pg_tb_det_inner">
        @if(!Session::has('seller_stripe_prompt'))
        <div class="proj_accourdiun_sec">
            <div class="proj_accourdiun_outer">
                <h2>Project Type</h2>
                <div class="proj_acco_det proj_acco_pt">
                    <label class="pt_check_box_list {{ ($userCampaign->is_charity == '1') ? 'pro_gig_checkbx_select' : '' }}">Create Charity or Flexible Project <input {{ ($userCampaign->is_charity == '1') ? 'checked=checked' : '' }} name="project_type" type="radio" value="1" /></label>
                    <p>Use this option for non business projects, you will recieve the monies regardless of any target, Use this for Charity project        only
                    </p>

                    <label class="pt_check_box_list {{ ($userCampaign->is_charity == '0') ? 'pro_gig_checkbx_select' : '' }}">Create A Personal Project <input {{ ($userCampaign->is_charity == '0') ? 'checked=checked' : '' }} name="project_type" type="radio" value="0" /></label>
                    <p> Use this option for personal projects, your supporters only pay if you reach your target, this is popular as it gives
                        confidence to the buyer that you will have the funds to complete the project
                    </p>

                </div>
            </div>
            <div id="story_text_accordion" class="proj_accourdiun_outer">
                <h2>Project Information</h2>
                <div class="proj_acco_det proj_acco_pi">
                    <div class="proj_pi_flt_top clearfix">
                        <div class="proj_pi_flt_left">
                            <p>Project Title</p>
                        </div>
                        <div class="proj_pi_flt_right clearfix" style="width:70%;margin-top:0;">
                            <input value="{{ $userCampaign->title }}" name="project_title" type="text" value="" placeholder="What Is The Title Of Your Project?" />
                        </div>
                    </div>
                    <div class="proj_pi_flt_top clearfix">
                        <div class="proj_pi_flt_left">
                            <span><img src="images/youtube_img.png" alt="#" /></span>
                        </div>
                        <div class="proj_pi_flt_right clearfix" >
                            <p> Add a youtube video to your project to explain what it is all about </p>
                            <input data-campaign-id="{{ $userCampaign->id }}" name="video_url" type="text" value="{{ $userCampaign->project_video_url }}" class="pi_inp_lft pt_url_inp" placeholder="URL here" />
                            <input id="profile_video_form_submit" type="submit" value="Post" />
                        </div>
                    </div>
                    <input type="hidden" name="project_story_text" value="" id="project_story_text">
                    <div class="proj_bord_sec" style="border: none; padding: 0px;">
                        <!-- FLORA EDITOR HERE -->
                        <iframe onload="setIframeHeight(this.id)" id="full-screen-me" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" frameborder="0" wmode="transparent" src="{{ route('save.user.story.text', ['id' => $user->id]) }}"></iframe>
                        
                        <script type="text/javascript">
                                function getDocHeight(doc) {
                                    doc = doc || document;
                                    var body = doc.body, html = doc.documentElement;
                                    var height = Math.max( body.scrollHeight, body.offsetHeight, 
                                    html.clientHeight, html.scrollHeight, html.offsetHeight );
                                    $('#project_story_text').val(doc.getElementsByClassName("ck-editor__editable_inline")[0].innerHTML);
                                    return height;
                                }
                                function setIframeHeight(id) {
                                    var ifrm = document.getElementById(id);
                                    var doc = ifrm.contentDocument? ifrm.contentDocument: ifrm.contentWindow.document;
                                    ifrm.style.visibility = 'hidden';
                                    ifrm.style.height = "10px"; // reset to minimal height ...
                                    // IE opt. for bing/msn needs a bit added or scrollbar appears
                                    var displayAttr = $('#profile_tab_05').css('display');
                                    $('#profile_tab_05').css('display', 'block');
                                    $('#story_text_accordion .proj_acco_pi').removeClass('proj_acco_det');
                                    ifrm.style.height = getDocHeight( doc ) + 50 + "px";
                                    $('#profile_tab_05').css('display', displayAttr);
                                    $('#story_text_accordion .proj_acco_pi').addClass('proj_acco_det');
                                    ifrm.style.visibility = 'visible';
                                }
                        </script>
                    </div>
                </div>
            </div>
            <div class="proj_accourdiun_outer" >
                <h2>Project Amount And Duration</h2>
                <div class="proj_acco_det proj_acco_pi">
                    <div class="proj_amount_sec clearfix cant_edit_fields">
                        <h3>Amount</h3>
                        <p>Set the amount that you want to raise for your project. A minimum of 600USD - 350GBP is required. Once reached this goal can be exceeded</p>
                        <p> Once someone has contributed to this project you cannot change this*  </p>
                        <label class="proj_insp_wid input_with_currency_drop">
                            <div class="tot_usd_shiping">
                                <div class="proj_cont_right_inner drop_substi_subscrip_inner clearfix">
                                    <div class="drop_substi_curr">GBP</div>
                                    <input value="{{ $userCampaign->amount }}" class="tot_usd_val drop_substi_val" type="text" placeholder="0.00" name="project_amount" />
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="proj_det_sec clearfix">
                        <h3>Duration</h3>
                        <div class="proj_dur_inr_sec clearfix">
                            <p>How long will the Project run for? You can run a Project for up to 60 days</p>
                            <div class="proj_dur_sel_sec">
                                <span>{{ ( $userCampaign->duration != '' ) ? $userCampaign->duration : 'Days' }}</span>
                                <select id="project_duration" name="project_duration">
                                    <option value="">Days</option>
                                    <?php for($i =0; $i<=60; $i++){?>
                                    <option {{ ( $userCampaign->duration == $i ) ? 'selected=selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                    <?php }?>

                                </select>
                            </div>
                        </div>
                        <div class="proj_dur_inr_sec clearfix">
                            <p>This can only be extended once after you have saved.*  </p>
                            <mark>A project cannot run for more than 60 days</mark>
                        </div>
                    </div>

                    <!-- extend duration -->
                    <?php $extendDisplay = "display: none;";?>
                    @if($userCampaign->duration > 0)
                        <?php $extendDisplay = "";?>
                    @endif
                    <div class="proj_det_sec clearfix" style="{{ $extendDisplay }}">
                        <h3>Extend Duration</h3>
                        <div class="proj_dur_inr_sec clearfix">
                            <p>Extend project duration (This cannot pass 60 days)</p>
                            <div class="proj_dur_sel_sec">
                                <span>{{ ( $userCampaign->extend_duration != '' ) ? $userCampaign->extend_duration : 'Days' }}</span>
                                <select id="extend_duration" name="extend_duration" @if($userCampaign->extend_duration > 0) disabled @endif>
                                    <option value="">Days</option>
                                    <?php for($i =0; $i<=60; $i++){?>
                                    <option {{ ( $userCampaign->extend_duration == $i ) ? 'selected=selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                    <?php }?>

                                </select>
                            </div>
                        </div>
                        <div class="proj_dur_inr_sec clearfix">

                        </div>
                    </div>
                    <!-- extend duration -->

                </div>
            </div>
            <input type="hidden" id="is_live" value="{{ $liveFlag }}">
            <div class="proj_accourdiun_outer">
                <h2>Add Bonuses</h2>
                <div class="proj_acco_det proj_acco_bonus">
                    <p>Bonuses give users something back for supporting your project. So you could offer them a copy of your album. Or for those big spenders, something more personal, like a live performance.  </p>
                    <div class="proj_ship_flt_outer prof_btn_contain clearfix">
                        <ul>
                            <li><a class="add_new_bonus" href="#">Add New Bonus</a></li>
                        </ul>
                    </div>

                    <input type="hidden" id="user_campaign_id" value="{{ $userCampaign->id }}">

                    <div id="all_bonuses_section">
                        @include('parts.all_bonuses_section')
                    </div>

                </div>
            </div>
            <div class="proj_accourdiun_outer">
                <h2>Add Payment Details</h2>
                <div class="proj_acco_det proj_acco_payment">
                    <p style="color:#ee1e50 !important;">Please enter the correct stripe account as this cannot be changed once you have connected your account*</p>
                    @if($stripeUrl !="")
                    <a href="{{ $stripeUrl }}" class="pro_stript_btn"></a>
                    @endif
                    <p>To recieve the funds from your supporters for your project just connect to stripe. Your funds will be transferred 15 days after your project goal has been met (if you are making a flexible project) Any refunds can be made through stripe  </p>
                    <p>1Platform TV's fee is 5% from each donation you receive. Payment Processing fee is 1.4% + £0.20 + VAT for EEA issued cards and 2.9% + £0.20 + VAT for non-EEA issued cards. By continuing, you agree with 1Platform TV’s terms and privacy policy.</p>

                </div>
            </div>

            <label class="proj_cond_check {{ ( $userCampaign->title != '' ) ? 'proj_cond_check_active' : '' }}">I agree with 1Platform
                <a href="javascript:void(0)">Terms and conditions</a>
                <input {{ ( $userCampaign->title != '' ) ? 'checked=checked' : '' }} value="1" name="terms_agree" type="checkbox" />
            </label>
        </div>
        <div class="pay_btm_btn_outer clearfix">
            <ul>
                @if($userCampaignDetails['isLive'] == 0)
                <li><a id="preview_project" href="javascript:void(0)">Preview</a></li>
                <li><a id="save_project" href="javascript:void(0)">Save</a></li>
                @if($userCampaign->title != '')
                <li><a id="go_live_project" href="javascript:void(0)">Go Live</a></li>
                @endif
                @else
                <li><a id="save_project" href="javascript:void(0)">Save</a></li>
                @endif
                <?php $createButtonDisplay = "display: none;";?>
                @if( ($userCampaignDetails['campaignDaysLeft'] <= 0 || $userCampaignDetails['campaignSuccessful'] == 1 || $userCampaignDetails['campaignUnsuccessful'] == 1) && $userCampaign->amount > 0 && $userCampaign->status == "active" )
                    <?php $createButtonDisplay = "";?>
                @endif

                <li><a id="create_new_project" style="cursor: pointer; {{ $createButtonDisplay }}">Create a new project</a></li>


            </ul>
            <div style="float: left; margin-top: 10px;" class="proj_cont_flt_outer proj_bottom_description">
                <p>
                    By saving your project, you agree to our <a target="_blank" href="{{route('tc')}}">terms and conditions</a>
                </p>
            </div>
        </div>
        @else
            @include('parts.pro-stripeless-content', ['page' => 'crowdfund'])
        @endif
    </div>
    <input type="hidden" value="" id="save_and_preview" name="save_and_preview">
    <input type="hidden" value="" id="go_live" name="go_live">
    </form>
</div>

<link rel="stylesheet" href="{{asset('css/profile.crowdfund.css')}}">