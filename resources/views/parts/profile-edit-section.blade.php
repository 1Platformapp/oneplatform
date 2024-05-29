
<link href="{{asset('croppie/croppie-2.css?v=1.5')}}" type="text/css" rel="stylesheet">
<link href="{{asset('croppie/croppie.css?v=1.2')}}" type="text/css" rel="stylesheet">
<script src="{{asset('croppie/croppie.min.js')}}"></script>

<style>
    .user_bio_area { min-height: 300px; width: 100%; border: 1px solid #818181; padding: 10px; font-size: 14px; font-family: Open sans,sans-serif; }
    .pro_pg_tb_det { position: relative; }
    .p_tab_carosel_nav { display: flex; align-items: center; justify-content: space-between; width: 16%; position: absolute; top: 70px; left: 42%; }
    .p_tab_carosel_nav_each { font-size: 28px; color: #28a745; }
</style>

@php $display = 'display: block;' @endphp
@if($page != '' && $page != 'edit')
    @php $display = 'display: none;' @endphp
@endif

    <div id="profile_tab_01" class="pro_my_profil_sec pro_pg_tb_det" style="{{ $display }}">
        <div class="pro_pg_tb_det_inner">
            <div id="personal_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'info' || $subTab == '' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Personal Information</div>
                </div>
                <form autocomplete="off" action="{{isset($setupWizard) ? '' : route('save.user.profile')}}" method="post" enctype="multipart/form-data">
                    <input name="profile_image" accept="image/*" type="file" id="profile_image" style="display: none;">
                    {{ csrf_field() }}
                    <div class="pro_inp_list_outer">
                        <div class="clearfix pro_inp_outer">
                            <label>First Name *</label>
                            <div class="pro_inp_right"><input autocomplete="new-password" name="first_name" type="text" placeholder="First Name" value="{{ $userPersonalDetails['first_name'] }}" />  </div>
                        </div>
                        <div class="clearfix pro_inp_outer">
                            <label>Surname *</label>
                            <div class="pro_inp_right"><input autocomplete="new-password" name="surname" type="text" placeholder="Surname" value="{{ $userPersonalDetails['surname'] }}" />  </div>
                        </div>
                        @if(!$user->is_buyer_only)
                        <div class="clearfix pro_inp_outer">
                            <label>Visible Name *</label>
                            <div class="pro_inp_right"><input autocomplete="new-password" name="name" type="text" placeholder="Other users will see this name" value="{{ $userPersonalDetails['name'] }}" />  </div>
                        </div>
                        @endif
                        <div class="clearfix pro_inp_outer">
                            <label>Address</label>
                            <div class="pro_inp_right">
                                <input autocomplete="new-address"  name="address" type="text" placeholder="Address" value="{{ $userPersonalDetails['address'] }}" autocomplete="off" />
                            </div>
                        </div>
                        <div class="clearfix pro_inp_outer">
                            <label>Postcode</label>
                            <div class="pro_inp_right"><input autocomplete="new-postcode" name="postcode" type="text" placeholder="Add Postcode" value="{{ $userPersonalDetails['postcode'] }}" />  </div>
                        </div>
                        <div class="clearfix pro_inp_outer">
                            <label>Country *</label>
                            <div class="pro_inp_right simple_custom_dropdown simple_searchable">
                                <input autocomplete="off" type="text" placeholder="Enter here" name="cou_id" value="{{$userPersonalDetails['country'] == '' ? '' : $userPersonalDetails['country']}}">
                                <input type="hidden" name="country_id" value="{{$userPersonalDetails['country'] == '' ? '' : $userPersonalDetails['countryId']}}">
                                <i class="fa fa-search"></i>
                                <div class="clearfix country_results pro_custom_drop_res instant_hide">
                                    <div class="pro_country_list_drop">
                                        <ul></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix pro_inp_outer">
                            <label>City *</label>
                            <div class="pro_inp_right simple_custom_dropdown simple_searchable">
                                <input autocomplete="off" type="text" placeholder="Enter here" name="cit_id" value="{{$userPersonalDetails['city'] == '' ? '' : $userPersonalDetails['city']}}">
                                <input type="hidden" name="city_id" value="{{$userPersonalDetails['city'] == '' ? '' : $userPersonalDetails['cityId']}}">
                                <i class="fa fa-search"></i>
                                <div class="clearfix city_results pro_custom_drop_res instant_hide">
                                    <div class="pro_city_list_drop">
                                        <ul></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix pro_inp_outer">
                            <label>Website</label>
                            <div class="pro_inp_right">
                                <input name="website" type="text" placeholder="Website" value="{{$userPersonalDetails['website']}}"  />
                            </div>
                        </div><div class="clearfix pro_inp_outer">
                            <label>Phone</label>
                            <div class="pro_inp_right">
                                <div class="pro_inp_right">
                                    <input name="phone" type="text" placeholder="Telephone Contact" value="{{$userPersonalDetails['phone']}}"  />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix pro_inp_outer">
                            <label>Hear About</label>
                            <div class="pro_inp_right music_sec_opt_outer simple_custom_dropdown">
                                <span>{{ ($userPersonalDetails['hearAbout'] != '') ? $userPersonalDetails['hearAbout'] : 'Where did you hear about us?' }}</span>
                                <select name="hear_about">
                                    <option value="">Where did you hear about us?</option>
                                    <option {{ ($userPersonalDetails['hearAbout'] == 'Friend') ? 'selected' : '' }} value="Friend">Friend</option>
                                    <option {{ ($userPersonalDetails['hearAbout'] == 'Google Search') ? 'selected' : '' }} value="Google Search">Google Search</option>
                                    <option {{ ($userPersonalDetails['hearAbout'] == 'Email Marketing') ? 'selected' : '' }} value="Email Marketing">Email Marketing</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clearfix save_profile_outer edit_profile_btn_1"><a href="javascript:void(0)">Save</a></div>
            </div>
            <div id="email_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'email_section' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Account Settings</div>
                </div>
                <div class="pro_inp_list_outer">
                    <div class="clearfix pro_inp_outer">
                        <label>Email *</label>
                        <div class="pro_inp_right"><input readonly name="email_address" class="place_red" type="email" placeholder="change Email" value="{{ $userPersonalDetails['email'] }}" />  </div>
                    </div>
                    <div class="clearfix pro_inp_outer">
                        <label>Password</label>
                        <div class="pro_inp_right"><input autocomplete="off" readonly name="password" class="place_red" type="password" placeholder="change password"  />  </div>
                    </div>
                </div>
            </div>
            <div id="musical_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'media' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Media Information</div>
                </div>
                <div class="musical_intro {{$user->hasMusicalFilled()?'instant_hide':''}}">
                    <p class="section_note">
                        Here you add your skill for example, Singer, Musician, Photographer, Singer, Videographer, Producer, Agent etc
                    </p>
                    <div id="musical_intro_btn" class="clearfix edit_profile_btn_1">
                        <a href="javascript:void(0)">Add</a>
                    </div>
                    <hr>
                </div>
                <div class="musical_detail {{$user->hasMusicalFilled()?'':'instant_hide'}}">
                    <form action="{{isset($setupWizard) ? '' : route('save.user.profile')}}" method="post">
                        {{csrf_field()}}
                        <div class="pro_inp_list_outer">
                            <div class="pro_note">
                                <ul>

                                    <li>This will help people find you</li>
                                    <li>If you want to be an agent tick the option below. <a target="_blank" href="{{route('faq')}}">Click here</a> to learn more about 1platform agents</li>
                                </ul>
                            </div>
                            @php $skills = \App\Models\Skill::where('user_role_id', $user->role_id)->get() @endphp
                            <div class="clearfix pro_inp_outer">
                                <label>Main Skill *</label>
                                <div class="pro_inp_right music_sec_opt_outer simple_custom_dropdown">
                                    <span>{{ ($user->skills != '') ? $user->skills : 'Add Skill' }}</span>
                                    <select id="main_skill_select" data-skill="{{$user->skills}}"  name="skill">
                                        <option value='' disabled>Select a Skill</option>
                                        @foreach($skills as $skill)
                                            <option value="{{$skill->value}}">{{$skill->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix pro_inp_outer">
                                <label>Other Skill *</label>
                                <div class="pro_inp_right music_sec_opt_outer simple_custom_dropdown">
                                    <span>{{ ($user->sec_skill != '') ? $user->sec_skill : 'Add Skill' }}</span>
                                    <select id="sec_skill_select" data-skill="{{$user->sec_skill}}" name="sec_skill">
                                        <option value='' disabled>Select a Skill</option>
                                        @foreach($skills as $skill)
                                            <option value="{{$skill->value}}">{{$skill->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($user->role_id == 1)
                            <div class="clearfix pro_inp_outer further_skill_outer profile_custom_dropdown_outer">
                                <label>Instruments</label>
                                <div class="pro_inp_right pro_plus_icon">
                                    <input autocomplete="off" name="further_skills" type="text" placeholder="Type to search instruments" />
                                    <i class="fa fa-search"></i>
                                    <div class="clearfix pro_inp_outer pro_custom_drop_res left_adjusted pro_further_skill_list_drop_outer instant_hide">
                                        <div class="pro_further_skill_list_drop profile_custom_dropdown_inner">
                                            <ul></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="further_skills_results" class="clearfix profile_custom_dropdown_results_outer">
                                @if(count($userPersonalDetails['furtherSkillsArray']))
                                    @foreach($userPersonalDetails['furtherSkillsArray'] as $item)
                                    <div class="profile_custom_drop_each">
                                        <div class="profile_custom_drop_title">{{$item}}</div>
                                        <div class="profile_custom_drop_icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="clearfix pro_inp_outer">
                                <label>Genre</label>
                                <div class="pro_inp_right music_sec_opt_outer simple_custom_dropdown">
                                    <span>{{ ($userPersonalDetails['genreId'] != '') ? $userPersonalDetails['genre'] : 'Add Genre' }}</span>
                                    <select name="genre_id">
                                        <option value="">Add Genre</option>

                                        @foreach($genres as $key => $genre)
                                            <option {{ ($genre->id == $userPersonalDetails['genreId']) ? 'selected' : '' }} value="{{ $genre->id }}">{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="clearfix pro_inp_outer">
                                <label>Level *</label>
                                <div class="pro_inp_right music_sec_opt_outer simple_custom_dropdown">
                                    <span>{{ ($userPersonalDetails['level'] != '') ? $userPersonalDetails['level'] : 'Choose the level of your main skill' }}</span>
                                    <select name="level">

                                        <option value="">Choose the level of your main skill</option>
                                        <option {{ ($userPersonalDetails['level'] == 'Beginner') ? 'selected' : '' }} value="Beginner">Beginner</option>
                                        <option {{ ($userPersonalDetails['level'] == 'Intermediate') ? 'selected' : '' }} value="Intermediate">Intermediate</option>
                                        <option {{ ($userPersonalDetails['level'] == 'Professional') ? 'selected' : '' }} value="Professional">Professional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix pro_inp_outer">
                                <label>Agent</label>
                                <div style="display: flex; flex-direction: row;" class="pro_inp_right">
                                    @if($user->apply_expert==2)
                                    <input name="exp" readonly type="text" value="You are 1platform agent"  />
                                    @if($user->expert->pdf)
                                    <a class="pro_inp_right_link" download href="{{asset('agent-agreements').'/'.$user->expert->pdf}}">Agreement</a>
                                    @endif
                                    @elseif($user->apply_expert==1)
                                    <input name="exp" readonly type="text" value="Your request to be an agent is pending"  />
                                    @else
                                    <div class="clearfix pro_select_outer">
                                        <ul class="clearfix">
                                            <li>
                                                <text class="{{$user->apply_expert==1?'pro_gander_active':''}}">Apply to be a 1Platform agent
                                                    <input name="apply_for_expert" type="radio" value="1">
                                                </text>
                                            </li>
                                            <li>
                                                <text class="{{$user->apply_expert==1?'':'pro_gander_active'}}">No Thanks
                                                    <input name="apply_for_expert" type="radio" value="0">
                                                </text>
                                            </li>
                                        </ul>

                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix save_profile_outer edit_profile_btn_1"><a href="javascript:void(0)">Save</a></div>
                </div>
            </div>
            @php $serviceCategories = \App\Models\ServiceCategory::all() @endphp
            <div id="services_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'services' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                	<div class="pro_tray_title">Manage Your Services</div>
                	<div class="pro_tray_tabs">
                        <div class="pro_tray_sep"></div>
                		<div title="Add service" data-key="service_add" class="pro_tray_tab_each active">
                			<div class="pro_tray_tab_title"></div>
                			<div class="pro_tray_tab_icon">
                				<i class="fa fa-plus"></i>
                			</div>
                		</div>
                		<div class="pro_tray_sep"></div>
                		<div data-key="service_list" title="Edit services" class="pro_tray_tab_each">
                			<div class="pro_tray_tab_title"></div>
                			<div class="pro_tray_tab_icon">
                				<i class="fa fa-edit"></i>
                			</div>
                		</div>
                	</div>
                </div>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>Boost your income and fan base by providing services</li>
                            <li>The services will appear on your website</li>
                        </ul>
                    </div>
                </div>
                <div data-value="service_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
                    <form class="add_service_form" action="{{isset($setupWizard) ? '' : route('save.user.service')}}" method="post">
                        {{csrf_field()}}
                        <div class="pro_stream_input_each">
                            <div class="pro_input_icon">
                                <input autocomplete="off" placeholder="Enter a service name (e.g Photoshoot)" type="text" class="pro_stream_input pro_service_search" name="pro_service">
                            </div>
                            <div class="clearfix pro_services_results pro_custom_drop_res left_adjusted instant_hide">
                                <div class="pro_services_list_drop">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                        <div class="pro_stream_input_row">
                            <div class="pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select class="pro_service_price_option" name="pro_service_price_option">
                                        <option value="">Choose price</option>
                                        <option value="1">Add price</option>
                                        <option value="2">No price</option>
                                        <option value="3">POA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pro_stream_input_row">
                                <div class="pro_stream_input_each">
                                    <input disabled placeholder="Enter price" type="number" class="pro_stream_input pro_service_price" name="pro_service_price">
                                </div>
                                <div class="pro_stream_input_each">
                                    <div class="stream_sec_opt_outer">
                                        <select class="pro_service_price_interval" disabled name="pro_service_price_interval">
                                            <option value="">Choose pricing interval</option>
                                            <option value="no">No Interval</option>
                                            <option value="hour">Hour</option>
                                            <option value="day">Day</option>
                                            <option value="month">Month</option>
                                            <option value="year">Year</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix save_service_outer edit_profile_btn_1">
                            <a href="javascript:void(0)">Submit </a>
                        </div>
                    </form>
                </div>
                <div data-value="service_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">
                    <div id="">
                        @if(count($user->services))
                        @foreach($user->services as $userService)

                            <div class="music_btm_list">
                                <div class="edit_elem_top">
                                    <div class="m_btm_list_left">
                                        <ul class="music_btm_img_det">
                                            <li><a href="javascript:void(0)">{{ $userService->service_name }}</a></li>
                                        </ul>
                                    </div>

                                    <div class="m_btm_right_icons">
                                        <ul>
                                            <li>
                                                <a title="Edit" data-id="{{ $userService->id }}" class="m_btn_right_icon_each m_btm_edit active">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{ $userService->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="edit_elem_bottom">
                                    @include('parts.user-service-edit-template', ['service' => $userService])
                                </div>
                            </div>
                        @endforeach
                        @else
                            <br><br><br>
                            <div class="no_results">You have not added any services yet</div>
                        @endif
                    </div>
                </div>
            </div>
            <div id="portfolio_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'portfolio' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                	<div class="pro_tray_title">Manage Your Portfolio</div>
                	<div class="pro_tray_tabs">
                		<div class="pro_tray_sep"></div>
                        <div title="Add portfolio" data-key="portfolio_add" class="pro_tray_tab_each active">
                			<div class="pro_tray_tab_title"></div>
                			<div class="pro_tray_tab_icon">
                				<i class="fa fa-plus"></i>
                			</div>
                		</div>
                		<div class="pro_tray_sep"></div>
                		<div data-key="portfolio_list" title="Edit portfolio" class="pro_tray_tab_each">
                			<div class="pro_tray_tab_title"></div>
                			<div class="pro_tray_tab_icon">
                				<i class="fa fa-edit"></i>
                			</div>
                		</div>
                	</div>
                </div>
                <div class="pro_inp_list_outer">
                    <div class="pro_explainer_outer">
                        <div class="pro_explainer_inner">
                            <div data-explainer-file="{{base64_encode('14FjTvLyrualDG_DqdCDF-Nqs3fjwnsOl')}}" data-explainer-title="How to add your portfolio" data-explainer-description="Add portfolios to boost confidance of your fans" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Learn how to add your portfolio in 2 minutes
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_explainer_video instant_hide">
                            <div class="pro_explainer_video_contain">
                                <div id="jwp_portfolio"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-value="portfolio_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
                    <form enctype="multipart/form-data" class="add_port_form" action="{{isset($setupWizard) ? '' : route('save.user.portfolio')}}" method="post">
                        {{csrf_field()}}

                        <div class="element_container">
                            <div class="port_each_field">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Title</div>
                                </div>
                                <div class="port_field_body">
                                    <input type="text" class="port_field_text port_title" placeholder="Add Title" name="title" />
                                </div>
                            </div>
                            <div class="port_each_field">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Thumbnail</div>
                                </div>
                                <div class="port_field_body">
                                    <div data-id="main" class="demo-wrap upload-demo">
                                        <div class="upload-demo-wrap">
                                            <div class="init_croppie"></div>
                                        </div>
                                        <a class="btn file-btn">
                                        <i class="fa fa-upload"></i> <span>Choose a thumbnail</span>
                                        <input type="file" class="port_thumb_upload" value="Choose a file" accept="image/*" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="add_port_wid_outer">
                                <div class="port_wid_head">
                                    <span>Add Widget</span>
                                </div>
                                <div class="port_wid_drop_outer">
                                    <span class="top_adjust">
                                    <i class="fa fa-caret-up"></i>
                                    </span>
                                    <div class="port_wid_drop_inner">
                                        <div class="head">
                                            <span>Choose widget</span>
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <div data-id="heading" class="port_wid_drop_each add_element">
                                            <i class="fa fa-header"></i>
                                            <span>Add Heading</span>
                                        </div>
                                        <div data-id="paragraph" class="port_wid_drop_each add_element">
                                            <i class="fa fa-paragraph"></i>
                                            <span>Add Paragraph</span>
                                        </div>
                                        <div data-id="image" class="port_wid_drop_each add_element">
                                            <i class="fa fa-image"></i>
                                            <span>Add Image</span>
                                        </div>
                                        <div data-id="youtube" class="port_wid_drop_each add_element">
                                            <i class="fa fa-youtube"></i>
                                            <span>Add YouTube Video</span>
                                        </div>
                                        <div data-id="spotify" class="port_wid_drop_each add_element">
                                            <i class="fa fa-spotify"></i>
                                            <span>Add Spotify URL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-order="1" class="port_each_field port_field_checked">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Paragraph</div>
                                    <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                </div>
                                <div class="port_field_body">
                                    <textarea class="port_textarea main_info" placeholder="Write here" name="element[1][0][]"></textarea>
                                    <input type="hidden" class="extra_info" name="element[1][1][]" value="paragraph">
                                </div>
                            </div>
                            <div data-order="2" class="port_each_field port_field_checked">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">YouTube Video (optional)</div>
                                    <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                </div>
                                <div class="port_field_body">
                                    <input type="text" class="port_field_text main_info" placeholder="Add YouTube URL" name="element[2][0][]">
                                    <input type="hidden" class="extra_info" name="element[2][1][]" value="youtube">
                                </div>
                            </div>
                            <div class="port_each_field">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Connect a product with this portfolio (optional)</div>
                                </div>
                                <div class="port_field_body pro_stream_input_each">
                                    <div class="stream_sec_opt_outer">
                                        <select name="product">
                                            <option value="">Choose a product</option>
                                            @foreach($user->products as $product)
                                            <option value="{{$product->id}}">{{$product->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix save_portfolio_outer edit_profile_btn_1">
                            <a href="javascript:void(0)">Save </a>
                        </div>
                        <input type="hidden" value="" class="port_thumb_data" name="port_thumb_data" />
                    </form>
                </div>
                <div data-value="portfolio_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">
                    @if(count($user->portfolios))
                    @foreach($user->portfolios as $portfolio)
                        <div data-sort="port_{{$portfolio->id}}" class="music_btm_list elem_sortable">
                        	<div class="edit_elem_sort">
                        	    <div class="edit_elem_sort_up">
                        	        <i class="fa fa-hand-o-up"></i>
                        	    </div>
                        	    <div class="edit_elem_sort_down">
                        	        <i class="fa fa-hand-o-down"></i>
                        	    </div>
                        	</div>
                            <div class="edit_elem_top">
                                <div class="m_btm_list_left">
                                    <img src="{{asset('portfolio-images/'.$portfolio->displayImage())}}" alt="#" />
                                    <ul class="music_btm_img_det">
                                        <li><a href="javascript:void(0)">{{ $portfolio->title }}</a></li>
                                    </ul>
                                </div>

                                <div class="m_btm_right_icons">
                                    <ul>
                                        <li>
                                            <a title="Edit" data-id="{{ $portfolio->id }}" class="m_btn_right_icon_each m_btm_edit active">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{ $portfolio->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="edit_elem_bottom">
                                @include('parts.user-portfolio-edit-template', ['portfolio' => $portfolio])
                            </div>
                        </div>
                    @endforeach
                    @else
                        <br><br><br>
                        <div class="no_results">You have not added any portfolios yet</div>
                    @endif
                </div>
            </div>

            <div id="bio_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'bio' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Add Bio</div>
                </div>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>Here you can simply tell about yourself so users can connect with you.</li>
                        </ul>
                    </div>
                </div>
                <form action="{{isset($setupWizard) ? '' : route('save.user.profile')}}" method="post">
                    <div class="your_story_outer">
                        <div class="add_bio_text">
                            <b class="ibold" onmousedown="iBold()">Bold</b>
                            <div contenteditable="true" class="user_bio_area">{!! $userPersonalDetails['storyText'] !!}</div>
                        </div>
                        <!--<h2>Upload Images</h2>
                        <div class="pro_inp_list_outer">
                            <div class="pro_note">
                                <ul>
                                    <li>Upload upto 3 images that represent yourself, work or passion. These are not mandatory to add but if you do these will appear under your bio</li>
                                </ul>
                            </div>
                        </div>

                        @php $storyImages = explode(',', $story_images) @endphp
                        <div class="story_images_outer">
                            <div class="story_image_each">
                                <div data-id="story_image_0" class="demo-wrap upload-demo">
                                    <div class="upload-current">
                                        @if(isset($storyImages[0]) && $storyImages[0] != '')
                                        <div class="story_image_remove">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <img src="{{asset('user-story-images/'.$storyImages[0])}}" class="custom_file_thumb">
                                        @else
                                        <img src="{{asset('images/empty_story_image.png')}}" class="custom_file_thumb">
                                        @endif
                                    </div>
                                    <div class="upload-demo-wrap">
                                        <div class="init_croppie_story"></div>
                                    </div>
                                    <a class="btn file-btn">
                                        <i class="fa fa-upload"></i> <span>Upload an image</span>
                                        <input type="file" class="port_thumb_upload" value="Choose a file" accept="image/*" />
                                    </a>
                                </div>
                            </div>
                            <div class="story_image_each">
                                <div data-id="story_image_1" class="demo-wrap upload-demo">
                                    <div class="upload-current">
                                        @if(isset($storyImages[1]) && $storyImages[1] != '')
                                        <div class="story_image_remove">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <img src="{{asset('user-story-images/'.$storyImages[1])}}" class="custom_file_thumb">
                                        @else
                                        <img src="{{asset('images/empty_story_image.png')}}" class="custom_file_thumb">
                                        @endif
                                    </div>
                                    <div class="upload-demo-wrap">
                                        <div class="init_croppie_story"></div>
                                    </div>
                                    <a class="btn file-btn">
                                        <i class="fa fa-upload"></i> <span>Upload an image</span>
                                        <input type="file" class="port_thumb_upload" value="Choose a file" accept="image/*" />
                                    </a>
                                </div>
                            </div>
                            <div class="story_image_each">
                                <div data-id="story_image_2" class="demo-wrap upload-demo">
                                    <div class="upload-current">
                                        @if(isset($storyImages[2]) && $storyImages[2] != '')
                                        <div class="story_image_remove">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <img src="{{asset('user-story-images/'.$storyImages[2])}}" class="custom_file_thumb">
                                        @else
                                        <img src="{{asset('images/empty_story_image.png')}}" class="custom_file_thumb">
                                        @endif
                                    </div>
                                    <div class="upload-demo-wrap">
                                        <div class="init_croppie_story"></div>
                                    </div>
                                    <a class="btn file-btn">
                                        <i class="fa fa-upload"></i> <span>Upload an image</span>
                                        <input type="file" class="port_thumb_upload" value="Choose a file" accept="image/*" />
                                    </a>
                                </div>
                            </div>
                        </div>!-->
                    </div>
                </form>
                <div class="clearfix save_profile_outer edit_profile_btn_1">
                    <a href="javascript:void(0)">Save </a>
                </div>
            </div>
            <div id="home_layout_section" class="each_pro_edit_section sub_cat_data {{$subTab == 'design' ? '' : 'instant_hide'}}">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Your Website Design</div>
                </div>
                @if(Session::has('seller_stripe_prompt'))
                    @include('parts.pro-stripeless-content', ['page' => 'website_design'])
                @endif
                <div class="pro_inp_list_outer">

                </div>
                <h3 class="pro_edit_sub_head">Add profile image</h3>
                <div class="pro_edit_profile_image">
                    <img src="{{ $commonMethods::getUserDisplayImage($user->id) }}" alt="#" id="pro_edit_profile_image" />
                    <a href="#">Update your profile image</a>
                </div>
                <h3 class="pro_edit_sub_head">Choose layout</h3>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>Choose from 3 design layouts</li>
                        </ul>
                        <ul class="no_bullet">
                            <li>Background recommended size: 1920px x 1267px</li>
                            <li>Banner recommended size: 1920px x 300px</li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix pro_h_l_outer">
                    <div class="pro_h_l_head">

                        <div class="pro_h_l_btn_each_outer">
                            <div data-id="h_l_background_content" class="pro_h_l_btn_each {{$user->home_layout == 'background' ? 'active' : ''}}">
                                <div class="pro_h_l_btn_top">
                                    <div class="check_each_outer">
                                        <i class="fa fa-check {{$user->home_layout == 'background' ? '' : 'instant_hide'}}"></i>
                                    </div>
                                    <div class="check_each_name">Background (Default)</div>
                                </div>
                                <div class="pro_h_l_btn_bottom">
                                    <a class="check_each_action_btn manage_h_l_content"><i class="fa fa-plus"></i> Image</a>
                                    @if($user->username)
                                    <a href="{{route('user.home.preview', ['logo' => $user->home_logo,'layout' => 'background', 'params' => $user->username])}}" target="blank" class="check_each_action_btn"><i class="fa fa-eye"></i> Preview</a>
                                    @endif
                                </div>
                            </div>
                            <div id="h_l_background_content" class="each_h_l_content instant_hide">
                                <div class="pro_content_closer">
                                    <i class="fa fa-times"></i>
                                </div>
                                <div class="clearfix banner_editor_outer">
                                    <div class="banner_left">
                                        <div class="banner_sub_head">Upload new background</div>
                                        <div class="upload_new_banner">
                                            <div class="banner_inner">
                                                <i class="fa fa-upload"></i>
                                                <span class="text_nop">Choose new background</span>
                                                <input data-type="custom_background" data-id="display_new_background" class="instant_hide custom_media_file" type="file" id="background_file" accept="image/*" />
                                                <img src="" id="display_new_background" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="banner_right">
                                        <div class="banner_sub_head">Your current background</div>
                                        <div class="display_current">
                                            <div class="banner_inner">
                                                <img src="{{$user->custom_background != '' ? asset('user-media/background/'.$user->custom_background) : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_h_l_btn_each_outer">
                            <div data-id="h_l_banner_content" class="pro_h_l_btn_each {{$user->home_layout == 'banner' ? 'active' : ''}}">
                                <div class="pro_h_l_btn_top">
                                    <div class="check_each_outer">
                                        <i class="fa fa-check {{$user->home_layout == 'banner' ? '' : 'instant_hide'}}"></i>
                                    </div>
                                    <div class="check_each_name">Banner</div>
                                </div>
                                <div class="pro_h_l_btn_bottom">
                                    <a class="check_each_action_btn manage_h_l_content"><i class="fa fa-plus"></i> Image</a>
                                    @if($user->username)
                                    <a href="{{route('user.home.preview', ['logo' => $user->home_logo,'layout' => 'banner', 'params' => $user->username])}}" target="blank" class="check_each_action_btn"><i class="fa fa-eye"></i> Preview</a>
                                    @endif
                                </div>
                            </div>
                            <div id="h_l_banner_content" class="each_h_l_content instant_hide">
                                <div class="pro_content_closer">
                                    <i class="fa fa-times"></i>
                                </div>
                                <div class="clearfix banner_editor_outer">
                                    <div class="banner_left">
                                        <div class="banner_sub_head">Upload new banner</div>
                                        <div class="upload_new_banner">
                                            <div class="banner_inner">
                                                <i class="fa fa-upload"></i>
                                                <span class="text_nop">Choose New Banner</span>
                                                <input data-type="custom_banner" data-id="display_new_banner" class="instant_hide custom_media_file" type="file" id="banner_file" accept="image/*" />
                                                <img src="" id="display_new_banner" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="banner_right">
                                        <div class="banner_sub_head">Your current banner</div>
                                        <div class="display_current">
                                            <div class="banner_inner">
                                                <img src="{{$user->custom_banner != '' ? asset('user-media/banner/'.$user->custom_banner) : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_h_l_btn_each_outer">
                            <div data-id="h_l_standard_content" class="pro_h_l_btn_each {{$user->home_layout == 'standard' ? 'active' : ''}}">
                                <div class="pro_h_l_btn_top">
                                    <div class="check_each_outer">
                                        <i class="fa fa-check {{$user->home_layout == 'standard' ? '' : 'instant_hide'}}"></i>
                                    </div>
                                    <div class="check_each_name">Standard</div>
                                </div>
                                <div class="pro_h_l_btn_bottom">
                                    @if($user->username)
                                    <a href="{{route('user.home.preview', ['logo' => $user->home_logo, 'layout' => 'standard', 'params' => $user->username])}}" target="blank" class="check_each_action_btn"><i class="fa fa-eye"></i> Preview</a>
                                    @endif
                                </div>
                            </div>
                            <div id="h_l_standard_content" class="each_h_l_content instant_hide">
                                <div class="pro_content_closer">
                                    <i class="fa fa-times"></i>
                                </div>
                                This is the default layout
                            </div>
                        </div>
                    </div>

                </div>
                <h3 class="pro_edit_sub_head">Your Bio Video</h3>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>You can only add a YouTube video url here</li>
                        </ul>
                        <ul class="no_bullet">
                            <li>A promo video is only visible on banner  or standard layout</li>
                        </ul>
                    </div>
                </div>
                <div class="pro_inp_list_outer">
                    <div class="proj_pi_flt_top">
                        <div class="proj_pi_flt_left">
                            <span><img src="{{asset('images/youtube_img.png')}}" alt="#" /></span>
                        </div>
                        <div class="proj_pi_flt_right" >
                            <input data-profile-id="{{ $user->profile->id }}" name="bio_video_url" type="text" value="{{$userPersonalDetails['bioVideoUrl'] }}" class="pi_inp_lft pt_url_inp" placeholder="https://www.youtube.com/watch?v=123456789" />
                            <input id="user_bio_video_form_submit" type="submit" value="Post" />
                        </div>
                    </div>
                </div>

                <h3 class="pro_edit_sub_head">Choose logo</h3>
                <div class="pro_edit_text">
                    If you have a small logo place it here. Max width: 500px and Max height: 125px
                </div>
                <div class="clearfix pro_h_logo_outer">
                    <div class="pro_h_logo_head">
                        <div data-id="h_logo_standard_content" class="pro_h_logo_btn_each {{$user->home_logo == 'standard' ? 'active' : ''}}">
                            <div class="pro_h_logo_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->home_logo == 'standard' ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Standard (Default)</div>
                            </div>
                            <div class="pro_h_logo_btn_bottom">
                                @if($user->username)
                                <a href="{{route('user.home.preview', ['logo' => 'standard', 'layout' => $user->home_layout, 'params' => $user->username])}}" target="blank" class="check_each_action_btn"><i class="fa fa-eye"></i> Preview</a>
                                @endif
                            </div>
                        </div>
                        <div data-id="h_logo_custom_content" class="pro_h_logo_btn_each {{$user->home_logo == 'custom' ? 'active' : ''}}">
                            <div class="pro_h_logo_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->home_logo == 'custom' ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Custom</div>
                            </div>
                            <div class="pro_h_logo_btn_bottom">
                                <a class="check_each_action_btn manage_h_logo_content"><i class="fa fa-plus"></i> Image</a>
                                @if($user->username)
                                <a href="{{route('user.home.preview', ['logo' => 'custom', 'layout' => $user->home_layout, 'params' => $user->username])}}" target="blank" class="check_each_action_btn"><i class="fa fa-eye"></i> Preview</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pro_h_logo_content instant_hide">
                        <div class="pro_content_closer">
                            <i class="fa fa-times"></i>
                        </div>
                        <div class="pro_hl_content_inner">
                            <div id="h_logo_custom_content" class="each_h_logo_content instant_hide">
                                <div class="clearfix banner_editor_outer">
                                    <div class="banner_left">
                                        <div class="banner_sub_head">Upload new logo</div>
                                        <div class="upload_new_banner">
                                            <div class="banner_inner">
                                                <i class="fa fa-upload"></i>
                                                <span class="text_nop">Choose new logo</span>
                                                <input data-type="custom_logo" data-id="display_new_logo" class="instant_hide custom_media_file" type="file" id="logo_file" accept="image/*" />
                                                <img src="" id="display_new_logo" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="banner_right">
                                        <div class="banner_sub_head">Your custom logo</div>
                                        <div class="display_current">
                                            <div class="banner_inner">
                                                <img src="{{$user->custom_logo != '' ? asset('user-media/logo/'.$user->custom_logo) : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="pro_edit_sub_head">Your website tabs</h3>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>Choose which tab you want to display open on your website by default</li>
                            <li>Click on eye icon to hide tab that you don't want to show</li>
                            <li>Click on star icon to feature a tab on your page (one tab can be featured at one time)</li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix pro_def_h_t_btn_outer">
                    <div class="pro_h_dt_head">
                        <div data-id="1" class="pro_h_dt_btn_each {{$user->default_tab_home == 1 ? 'active' : ''}}">
                            <div class="pro_h_dt_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->default_tab_home == 1 ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Bio</div>
                            </div>
                        </div>
                        <div data-id="2" class="pro_h_dt_btn_each {{$user->default_tab_home == 2 ? 'active' : ''}}">
                            <div class="pro_h_dt_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->default_tab_home == 2 ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Music</div>
                            </div>
                            <div class="pro_h_tab_btn_bottom">
                                <i title="Hide" class="pro_tab_hide_show {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'active' : ''}} fa fa-eye-slash"></i>&nbsp;
                                <i title="Feature" class="pro_tab_feature {{$user->feature_tab_home == 2 ? 'active' : ''}} fa fa-star"></i>
                            </div>
                        </div>
                        <div data-id="3" class="pro_h_dt_btn_each {{$user->default_tab_home == 3 ? 'active' : ''}}">
                            <div class="pro_h_dt_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->default_tab_home == 3 ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Fans</div>
                            </div>
                            <div class="pro_h_tab_btn_bottom">
                                <i title="Hide" class="pro_tab_hide_show {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'active' : ''}} fa fa-eye-slash"></i>&nbsp;
                                <i title="Feature" class="pro_tab_feature {{$user->feature_tab_home == 3 ? 'active' : ''}} fa fa-star"></i>
                            </div>
                        </div>
                        <div data-id="4" class="pro_h_dt_btn_each {{$user->default_tab_home == 4 ? 'active' : ''}}">
                            <div class="pro_h_dt_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->default_tab_home == 4 ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Social</div>
                            </div>
                            <div class="pro_h_tab_btn_bottom">
                                <i title="Hide" class="pro_tab_hide_show {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'active' : ''}} fa fa-eye-slash"></i>&nbsp;
                                <i title="Feature" class="pro_tab_feature {{$user->feature_tab_home == 4 ? 'active' : ''}} fa fa-star"></i>
                            </div>
                        </div>
                        <div data-id="6" class="pro_h_dt_btn_each {{$user->default_tab_home == 6 ? 'active' : ''}}">
                            <div class="pro_h_dt_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->default_tab_home == 6 ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Store</div>
                            </div>
                            <div class="pro_h_tab_btn_bottom">
                                <i title="Hide" class="pro_tab_hide_show {{count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'active' : ''}} fa fa-eye-slash"></i>&nbsp;
                                <i title="Feature" class="pro_tab_feature {{$user->feature_tab_home == 6 ? 'active' : ''}} fa fa-star"></i>
                            </div>
                        </div>
                        <div data-id="5" class="pro_h_dt_btn_each {{$user->default_tab_home == 5 ? 'active' : ''}}">
                            <div class="pro_h_dt_btn_top">
                                <div class="check_each_outer">
                                    <i class="fa fa-check {{$user->default_tab_home == 5 ? '' : 'instant_hide'}}"></i>
                                </div>
                                <div class="check_each_name">Videos</div>
                            </div>
                            <div class="pro_h_tab_btn_bottom">
                                <i title="Hide" class="pro_tab_hide_show {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'active' : ''}} fa fa-eye-slash"></i>&nbsp;
                                <i title="Feature" class="pro_tab_feature {{$user->feature_tab_home == 5 ? 'active' : ''}} fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @if($user->hasActivePaidSubscription())
                <h3 class="pro_edit_sub_head">Your Website Icon</h3>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>This icon will get displayed in the address bar on your visitor's browser</li>
                            <li>1 Platform will use a default icon if its not provided</li>
                            <li>It should be a valid favicon icon having extension .ico</li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix pro_def_seo_btn_outer">
                    <div class="pro_seo_head">
                        <form id="pro_favicon_form" action="{{route('save.user.profile')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="pro_favicon_outer">
                                <img src="/{{$user->favicon_icon ? 'user-media/favicon/'.$user->favicon_icon : 'favicon.ico'}}" />
                                <div class="choose_icon">Update Favicon Icon</div>
                                <input type="file" class="pro_favicon_ico" name="pro_favicon_ico" />
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <h3 class="pro_edit_sub_head">Splash Area</h3>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>Splash area loads on your website page as a transparent foreground. It is an optional feature</li>
                            <li>You can choose a product or music track to display in it</li>
                        </ul>
                    </div>
                    <div class="port_each_field">
						<div class="port_field_label">
							<div class="port_field_label_text">Choose product or music (optional)</div>
						</div>
						<div class="port_field_body pro_stream_input_each">
							<div class="stream_sec_opt_outer">
								<form id="pro_splash_form" action="{{route('save.user.profile')}}" method="post">
								    {{csrf_field()}}
									<select name="pro_splash_item">
										<option value="">No splash</option>
                                        @if(count($user->products) == 0 && count($user->musics) == 0)
                                        <optgroup label="You have not added any music / product yet"></optgroup>
                                        @endif
										<optgroup label="Products">
										@foreach($user->products as $userProduct)
											<option {{$user->profile->splash && $user->profile->splash['type'] == 'product' && $user->profile->splash['id'] == $userProduct->id ? 'selected' : ''}} value="product_{{$userProduct->id}}">{{ $userProduct->title }}</option>
										@endforeach
										</optgroup>
										<optgroup label="Tracks">
										@foreach($user->musics as $userMusic)
											<option {{$user->profile->splash && $user->profile->splash['type'] == 'music' && $user->profile->splash['id'] == $userMusic->id ? 'selected' : ''}} value="music_{{$userMusic->id}}">{{ $userMusic->song_name }}</option>
										@endforeach
										</optgroup>
									</select>
								</form>
							</div>
						</div>
					</div>
                </div>
                <h3 class="pro_edit_sub_head">Search Engine Optimization</h3>
                <div class="pro_inp_list_outer">
                    <div class="pro_note">
                        <ul>
                            <li>Page title is displayed on search engine results pages (SERPs) as the clickable headline for your website. It is meant to be accurate and concise. It can be your name, skills, band name or a company name you represent or their combination. Its default value is your name</li>
                            <li>Page keywords includes popular phrases separated by comma that best represent your website page content</li>
                            <li>Page description provides a brief summary of your webpage. This also get displayed by the search engine beneath the page title on SERPs. Its default value is your bio</li>
                            <li>H1 heading is the most important heading on your web page. Search engines will use it to identify the topic of your page. Avoid overly general wording like Welcome, add something that deserves to be your website's main heading. It should be between 20 - 70 characters in length</li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix pro_def_seo_btn_outer">
                    <div class="pro_seo_head">
                        <form action="{{isset($setupWizard) ? '' : route('save.user.profile.seo')}}" method="post">
                            {{csrf_field()}}
                            <div class="seo_each_field">
                                <div class="seo_field_label">
                                    <div class="seo_field_label_text">Page Title</div>
                                </div>
                                <div class="seo_field_body">
                                    <input type="text" class="seo_field_text" placeholder="Add Page Title" name="seo_title" value="{{$user->profile->seo_title}}">
                                </div>
                            </div>
                            <div class="seo_each_field">
                                <div class="seo_field_label">
                                    <div class="seo_field_label_text">Page Keywords</div>
                                </div>
                                <div class="seo_field_body">
                                    <input type="text" class="seo_field_text" placeholder="Add Page Keywords" name="seo_keywords" value="{{$user->profile->seo_keywords}}">
                                    <input class="dummy_field" type="text" name="fakeusernameremembered">
                                </div>
                            </div>
                            <div class="seo_each_field">
                                <div class="seo_field_label">
                                    <div class="seo_field_label_text">Page Description</div>
                                </div>
                                <div class="seo_field_body">
                                    <textarea class="seo_field_textarea" placeholder="Add Page Description" name="seo_description">{{$user->profile->seo_description}}</textarea>
                                </div>
                            </div>
                            <div class="seo_each_field">
                                <div class="seo_field_label">
                                    <div class="seo_field_label_text">H1 Heading</div>
                                </div>
                                <div class="seo_field_body">
                                    <input type="text" class="seo_field_text" placeholder="Add H1 Heading" name="seo_h1" value="{{$user->profile->seo_h1}}">
                                    <input class="dummy_field" type="text" name="fakeusernameremembered">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix save_profile_outer edit_profile_btn_1"><a href="javascript:void(0)">Save</a></div>
                </div>
            </div>
            @if(!isset($isQuickSetup))
            <div id="domain_section" class="sub_cat_data {{$subTab == 'domain' ? '' : 'instant_hide'}} each_pro_edit_section">
                @if($user->hasActivePaidSubscription())

                @if($domain)
                    @if($domain->domain_url != NULL && $domain->dns_updated != NULL && $domain->status == 1 && $domain->admin_notified == 1)
                        @php $domainStatus = 'Connected'; @endphp
                    @elseif($domain->domain_url != NULL && $domain->dns_updated != NULL && $domain->status == 0 && $domain->admin_notified == 1)
                        @php $domainStatus = 'Requires Approval'; @endphp
                    @elseif($domain->domain_url == NULL || $domain->dns_updated == NULL)
                        @php $domainStatus = 'Not Connected'; @endphp
                    @else
                        @php $domainStatus = 'Connection Failed'; @endphp
                    @endif
                @else
                    @php $domainStatus = 'Not Connected'; @endphp
                @endif

                <div class="pro_main_tray">
                    <div class="pro_tray_title">Connect Your Domain</div>
                </div>
                <div class="clearfix curr_stat_outer">
                    <div class="each_curr_stat">
                        <div class="stat_head">Domain Status:</div>
                        <div class="stat_content">{{$domainStatus}}</div>
                    </div>
                    <div class="each_curr_stat">
                        <div class="stat_head">Domain Subscription:</div>
                        <div class="stat_content subscription_content">
                            Paid
                        </div>
                    </div>
                </div>
                <p>Your 1Platform.tv domain is 1platform.tv/team. You can point your own custom domain that you own like team.com by following the instructions below.</p><br>
                <p>
                    After completing all the below steps, 1Platform TV team will be automatically notified about this and it can take up to two days for the changes to “propagate” out to your many fans around the world. During this transition phase, some people visiting your custom domain might see your 1Platform TV home page, while others see your old site (if you have one). This is normal. You’ll know things are set up correctly when entering your custom domain into your web browser brings up your 1Platform TV site.
                </p><br>
                <div class="each_order_tab">
                    <i class="fa fa-globe"></i>
                    Add Your Domain URL
                    <div id="my_url" class="each_submit vertical_center proceed_submit">
                        @if($domain && $domain->domain_url != '')
                        <i class="fa fa-check"></i> Save
                        @else
                        <i class="fa fa-angle-double-right"></i> Save
                        @endif
                    </div>
                </div>
                <div class="each_tab_content">
                    <p>1Platform TV lets you use your base domain. Enter your domain in the given format and click the button in the headline of this section to save your domain URL.</p><br>
                    <p>Format: www.example.com</p>
                    <input id="domain_url" class="" type="text" name="domain_url" placeholder="www.example.com" value="{{$domain?$domain->domain_url:''}}" />
                    @if(!$domain || $domain->domain_url == null || $domain->domain_url == '')
                    <p>
                        If you don’t already own your custom domain, register it. 1Platform TV doesn’t register domains and doesn’t recommend companies who do, but here (in no particular order) are a few of the more popular registrars:
                    </p>
                    <ul class="register_domains">
                        <li><a target="_blank" href="http://easydns.com">EasyDNS</a></li>
                        <li><a target="_blank" href="http://www.godaddy.com">GoDaddy</a></li>
                        <li><a target="_blank" href="https://www.hostgator.com/">HostGator</a></li>
                        <li><a target="_blank" href="http://www.namecheap.com">NameCheap</a></li>
                        <li><a target="_blank" href="http://www.networksolutions.com">Network Solutions</a></li>
                        <li><a target="_blank" href="https://www.pairnic.com/index.html">pairNIC</a></li>
                        <li><a target="_blank" href="http://www.register.com">Register.com</a></li>
                    </ul>
                    @endif
                </div>
                <div class="each_order_tab">
                    <div class="each_tab_txt">
                        <i class="fab fa-app-store"></i>
                        Point Your Domain’s DNS Records at 1Platform TV
                    </div>
                    <div id="dns_updated" class="each_submit vertical_center proceed_submit">
                        @if($domain && $domain->dns_updated == 1)
                        <i class="fa fa-check"></i> Save
                        @else
                        <i class="fa fa-angle-double-right"></i> Save
                        @endif
                    </div>
                </div>
                <div class="each_tab_content">
                    <p>
                        The way you update DNS varies depending on your domain registrar. Please follow the instructions below. After completing every last step and checking them twice, click the button above.
                    </p><br>
                    <p>
                        1- Log into your domain registrar’s website.
                    </p><br>
                    <p>
                        2- Identify the base domain you want to modify.
                    </p><br>
                    <p>
                        3- Find the section for changing nameservers of your domain.
                    </p><br>
                    <p>
                        4- Edit your existing nameservers to the following<br>
                        Nameserver 1: <b>ns1.contabo.net</b><br>
                        Nameserver 2: <b>ns2.contabo.net</b><br>
                        Nameserver 3: <b>ns3.contabo.net</b>
                    </p><br>
                    <p>
                        5- After completing all the 4 steps above and checking them twice, click the button in the headline of this section.
                    </p><br>
                    <p>
                        Note: It normally takes upto 2 days for the nameservers to take effect. After changing the nameservers keep checking your domain's current nameservers from here.<br><b>https://www.whois.com/whois/example.com</b><br>Replace example.com with your own domain
                    </p>
                    <br>
                </div>
                @elseif($user->hasActiveFreeSubscription())
                    @include('parts.pro-stripeless-content', ['page' => 'domain', 'upgrade' => 1])
                @else
                    @include('parts.pro-stripeless-content', ['page' => 'domain'])
                @endif
            </div>
            @endif
            @if(!isset($isQuickSetup))
            <div id="favourites_section" class="sub_cat_data {{$subTab == 'favourites' ? '' : 'instant_hide'}} each_pro_edit_section">
            	<div class="">
                    <div class="font-medium text-lg">Your Favourite Musics</div>
                </div>
                <div class="each_tab_content user_musics_outer">
                    @php $favourites = (is_array($user->favourite_musics)) ? array_filter($user->favourite_musics) : array() @endphp
                    @if(count($favourites))
                        @foreach($favourites as $key => $musicId)
                            @php $music = \App\Models\UserMusic::find($musicId) @endphp
                            @if($music && $music->user)

                            	@if(count($music->privacy) && isset($music->privacy['status']) && $music->privacy['status'] == '1')

                            	    @include('parts.user-channel-music-private-template',['music'=>$music, 'type' => 'music'])
                            	    @php $musicLiked = 1; @endphp
                            	@else

                            	    @include('parts.user-channel-music-template',['music'=>$music])
                            	    @php $musicLiked = 1; @endphp
                            	@endif

                            @endif
                        @endforeach

                        @if(!isset($musicLiked) || $musicLiked != 1)
                            <div class="no_results_retry"><a href="{{ route('search') }}">LOOKING FOR SOME MUSIC?</a></div>
                            <div class="no_results">Here you can save what music you like</div>
                        @endif
                    @else
                    <div class="no_results_retry"><a href="{{ route('search') }}">LOOKING FOR SOME MUSIC?</a></div>
                    <div class="no_results">Here you can save what music you like</div>
                    @endif
                </div>
                <br><br>
                @if($user->hasActivePaidSubscription())
                <div class="">
                    <div class="font-medium text-lg">Your Favourite Industry Contacts</div>
                </div>
                <div class="each_tab_content">
                    @php $favCon = (is_array($user->favourite_industry_contacts)) ? array_filter($user->favourite_industry_contacts) : array() @endphp
                    @if(count($favCon))
                        <ul class="contracts_list grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($favCon as $key => $favConId)
                                @php $contact = \App\Models\IndustryContact::find($favConId) @endphp
                                @if($contact)
                                    @include('parts.industry-contact-template',['hasActiveSub' => Auth::user() && Auth::user()->hasActivePaidSubscription(), 'contact'=>$contact, 'isFav' => 1])
                                    @php $contactfav = 1; @endphp
                                @endif
                            @endforeach

                            @if(!isset($contactfav) || $contactfav != 1)
                                <div class="no_results">Here you can see your favourite industry contacts</div>
                            @endif
                        </ul>
                    @else
                    <div class="no_results">Here you can see your favourite industry contacts</div>
                    @endif
                </div>
                @endif
                <br><br>
                <div class="">
                    <div class="font-medium text-lg">Your Favourite Videos From TV</div>
                </div>
                <div class="each_tab_content tv_center_outer">
                    @php $tvFavourites = (is_array($user->favourite_streams)) ? array_filter($user->favourite_streams) : array() @endphp
                    @php $past_blacklist = array() @endphp
                    @if(count($tvFavourites))
                        @foreach($tvFavourites as $key => $streamId)
                            @php $stream = \App\Models\VideoStream::find($streamId) @endphp
                            @if($stream)
                                <div class="each_stream_outer each_fav_stream" data-source="{{$stream->source}}" data-id="{{$stream->id}}">
                                    @if($stream->source == 'youtube')
                                        @if($stream->default_thumb !== NULL)
                                            @php $thumb = 'https://www.duong.1platform.tv/public/stream-images/thumbs/one/'.$stream->default_thumb @endphp
                                        @else
                                            @php $thumb = 'https://img.youtube.com/vi/'.$stream->youtube_id.'/0.jpg' @endphp
                                        @endif
                                    @elseif($stream->source == 'google_drive')
                                        @if($stream->default_thumb !== NULL)
                                            @php $thumb = 'https://www.duong.1platform.tv/public/stream-images/thumbs/one/'.$stream->default_thumb @endphp
                                        @else
                                            @php $file = 'https://drive.google.com/thumbnail?id='.$stream->google_file_id.'&authuser=0&sz=w320-h180-n-k-rw' @endphp
                                        @endif
                                    @endif
                                    <div class="each_stream_inner tv_page_stream">
                                        <div class="each_stream_left">
                                            <a class="stream_thumb" href="javascript:void(0)">
                                                <img src="{{$thumb}}" />
                                            </a>
                                            <ul class="stream_det">
                                                <li class="stream_title">{{ str_limit($stream->name, 60) }}</li>
                                                <li class="stream_time">
                                                    {{$stream->time_formatted}}
                                                </li>
                                                <li class="stream_channel">{{ $stream->channel->title }}</li>
                                            </ul>
                                            <div class="each_stream_actions">
                                                <div class="stream_action stream_fav active">
                                                    <i class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $streamLiked = 1; @endphp
                            @endif
                        @endforeach

                        @if(!isset($streamLiked) || $streamLiked != 1)
                            <div class="no_results">Here you can save what videos from our TV you like</div>
                        @endif
                    @else
                    <div class="no_results">Here you can save what videos from our TV you like</div>
                    @endif
                </div>
                <br><br>
                <div class="">
                    <div class="font-medium text-lg">People You Follow</div>
                </div>
                <div class="each_tab_content">
                    @if(count($user->followings))
                        @foreach($user->followings as $key => $followingUser)
                            @if($followingUser->followeeUser)
                                <div data-href="{{route('user.home', ['params' => $followingUser->followeeUser->username])}}" class="clearfix tab_chanel_list each_user_following">
                                    <div class="summary">
                                        <a href="javascript:void(0)">
                                            <img class="" src="{{$commonMethods->getUserDisplayImage($followingUser->followeeUser->id)}}" alt="#">
                                        </a>
                                        <div class="tab_chanel_img_det">
                                            <a class="thismusic_user_name" href="javascript:void(0)">{{$followingUser->followeeUser->name}}</a>
                                        </div>
                                    </div>
                                </div>
                                @php $followingY = 1; @endphp
                            @endif
                        @endforeach
                        @if(!isset($followingY) || $followingY != 1)
                            <div class="no_results">Here you can see who you follow</div>
                        @endif
                    @else
                    <div class="no_results">Here you can see who you follow</div>
                    @endif
                </div>
                <br><br>
                <div class="">
                    <div class="font-medium text-lg">People Who Follow You</div>
                </div>
                <div class="each_tab_content">
                    @if(count($user->followers))
                        @foreach($user->followers as $key => $follower)
                            @if($follower->followerUser)
                                <div data-href="{{$follower->followerUser->username ? route('user.home', ['params' => $follower->followerUser->username]) : ''}}" class="clearfix tab_chanel_list each_user_following">
                                    <div class="summary">
                                        <a href="javascript:void(0)">
                                            <img class="" src="{{$commonMethods->getUserDisplayImage($follower->followerUser->id)}}" alt="#">
                                        </a>
                                        <div class="tab_chanel_img_det">
                                            <a class="thismusic_user_name" href="javascript:void(0)">{{$follower->followerUser->name}}</a>
                                        </div>
                                    </div>
                                </div>
                                @php $followerY = 1; @endphp
                            @endif
                        @endforeach
                        @if(!isset($followerY) || $followerY != 1)
                            <div class="no_results">Here you can see your followers</div>
                        @endif
                    @else
                    <div class="no_results">Here you can see your followers</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    @include('parts.audio-player')

    <div class="pro_page_pop_up clearfix" id="private_music_unlock_popup" data-type="" data-music-id="" data-mode="0">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="soc_con_face_username clearfix">
                    <div class="main_headline">This is a private music</div>
                    <div class="second_headline">To unlock it, enter the PIN below</div><br>
                    <input class="dummy_field" type="text" name="fakeusernameremembered">
                    <input placeholder="Enter PIN" type="text" id="unlock_pin" />
                    <div class="instant_hide error" id="unlock_pin_error">Required</div>
                </div>
                <br>
                <div id="unlock_private_music" class="pro_button">UNLOCK</div><br>
                <div class="pro_pop_dark_note">
                    <a href="#">How to get PIN?</a>
                </div>
            </div>
        </div>
    </div>

    <script>

        var mainSkill = $('#main_skill_select');
        var secSkill = $('#sec_skill_select');

        let mainSkillName = $('#main_skill_select').attr('data-skill');
        let secSkillName = $('#sec_skill_select').attr('data-skill');

        if(mainSkillName) {
            mainSkill.val(mainSkillName);
        }
        if(secSkillName) {
            secSkill.val(secSkillName);
        }

        $('.proceed_submit').click(function(){
            var thiss = $(this);
            if(!thiss.hasClass('busy')){
                thiss.addClass('busy');
                thiss.find('i').removeClass('fa-angle-double-right').removeClass('fa-times-circle').removeClass('fa-check').addClass('fa-spinner').addClass('fa').addClass('fa-spin');
                postSubmit(thiss);
            }
        });

        function postSubmit(thiss){

            var formData = new FormData();
            formData.append('id', thiss.attr('id'));
            formData.append('domain_url', $('#domain_url').val());
            $.ajax({

                url: '/saveUserDomain',
                type: 'POST',
                data: formData,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                dataType: "json",
                success: function (response) {
                    thiss.removeClass('busy');
                    if(response.success == 1){
                        if(thiss.attr('id') == 'unsub_dom' || thiss.attr('id') == 'payment_details'){
                            window.location.href = '/dashboard';
                        }else{
                            thiss.find('i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-check');
                        }
                    }else{
                        thiss.find('i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-angle-double-right');
                        alert(response.errorMessage);
                    }
                }
            });
        }

        $('.pro_edit_profile_image a, #pro_edit_profile_image').click(function(){

            $('#profile_image').trigger('click');
            return false;
        });
        $('.choose_icon').click(function(){

            $('.pro_favicon_ico').trigger('click');
            return false;
        });
        $('.upload_new_banner span, .upload_new_banner i').click(function(){
            var input = $(this).closest('.upload_new_banner').find('input');
            if(!input.closest('.banner_inner').hasClass('busy')){
                input.trigger('click');
            }
        });

        $('.pro_h_l_btn_top').click(function(){
            var thiss = $(this);
            $('.pro_h_l_btn_top i').addClass('instant_hide');
            thiss.find('i').removeClass('instant_hide');
            $('.each_h_l_content').addClass('instant_hide');
            $('.pro_h_l_content').addClass('instant_hide');
            $('.pro_h_l_btn_each').removeClass('active');
            thiss.closest('.pro_h_l_btn_each').addClass('active');

            var formData = new FormData();
            formData.append('id', thiss.closest('.pro_h_l_btn_each').attr('data-id'));
            $.ajax({

                url: '/saveUserHomeLayout',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {

                }
            });
        });

        $('.pro_h_logo_btn_top').click(function(){
            var thiss = $(this);
            $('.pro_h_logo_btn_top i').addClass('instant_hide');
            thiss.find('i').removeClass('instant_hide');
            $('.each_h_logo_content').addClass('instant_hide');
            $('.pro_h_logo_content').addClass('instant_hide');
            $('.pro_h_logo_btn_each').removeClass('active');
            thiss.closest('.pro_h_logo_btn_each').addClass('active');

            var formData = new FormData();
            formData.append('id', thiss.closest('.pro_h_logo_btn_each').attr('data-id'));
            $.ajax({

                url: '/saveUserHomeLogo',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {

                }
            });
        });

        $('.manage_h_l_content').click(function(){
            $('.each_h_l_content').addClass('instant_hide')
            var id = $(this).closest('.pro_h_l_btn_each_outer').find('.each_h_l_content').removeClass('instant_hide');
        });

        $('.manage_h_logo_content').click(function(){
            var id = $(this).closest('.pro_h_logo_btn_each').attr('data-id');
            $('.each_h_logo_content').addClass('instant_hide');
            $('.each_h_logo_content#'+id).removeClass('instant_hide');
            $('.pro_h_logo_content').removeClass('instant_hide');
        });

        $("#banner_file").change(function(){
            var thiss = $(this);
            var _URL = window.URL || window.webkitURL;
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    if(this.width >= 1350 && this.height <= 450){
                        $('#display_new_banner').parent().find('*').hide();
                        $('#display_new_banner').attr('src', this.src).show();
                        postMediaSubmit(thiss);
                    }else{
                        $('#banner_file').val('');
                        alert('The minimum width should be 1350px and maximum height should be 280px');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        });
        $("#background_file").change(function(){
            var thiss = $(this);
            var _URL = window.URL || window.webkitURL;
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    $('#display_new_background').parent().find('*').hide();
                    $('#display_new_background').attr('src', this.src).show();
                    postMediaSubmit(thiss);
                };
                img.src = _URL.createObjectURL(file);
            }
        });
        $("#logo_file").change(function(){
            var thiss = $(this);
            var _URL = window.URL || window.webkitURL;
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    if(this.width <= 500 && this.height <= 125){
                        $('#display_new_logo').parent().find('*').hide();
                        $('#display_new_logo').attr('src', this.src).show();
                        postMediaSubmit(thiss);
                    }else{
                        $('#logo_file').val('');
                        alert('The maximum width should be 500px and maximum height should be 125px');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        $("#profile_image").change(function(e){

            var data = e.originalEvent.target.files[0];

            if(data.size > 5*1024*1024) {
                alert('File cannot be more than 5MB');
                $(this).val('');
                return false;
            }

            var thiss = $(this);
            var _URL = window.URL || window.webkitURL;
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    if(this.width >= 650){
                        $('#body-overlay,#pro_uploading_in_progress_real').show();
                        setTimeout(function() {

                            $('.top_img_profile img,.pro_edit_profile_image img').attr('src', this.src);
                            $('#personal_section .save_profile_outer').trigger('click');
                        }, 500);
                    }else{
                        $('#profile_image').val('');
                        alert('The minimum width of profile image should be 650px');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        $(".pro_favicon_ico").change(function(e){

            var val = $(this).val().toLowerCase();
            var regex = new RegExp("(.*?)\.(.ico)$");
            if (!(regex.test(val))) {

                alert('The file must be a icon file having an extension ico');
            }else{

                setTimeout(function() {

                    $('#pro_uploading_in_progress_real, #body-overlay').show();
                    $('#pro_favicon_form').submit();
                }, 500);

            }
        });

        $('.pro_service_price_option').change(function(){

            var value = $(this).val();
            if(value != 1){
                $('.pro_service_price,.pro_service_price_interval').val('');
                $('.pro_service_price,.pro_service_price_interval').attr('disabled', 'disabled');
            }else{
                $('.pro_service_price,.pro_service_price_interval').removeAttr('disabled');
                $('.pro_service_price').focus();
            }
        });

        $('.multi_level_drop_outer .multi_level_member_up').click(function(){

            var thiss = $(this);
            var target = thiss.closest('.multi_level_member_each').find('.multi_level_member_down');
            if(target.length){

                var otherElems = thiss.closest('.multi_level_drop_outer').find('.multi_level_member_down').not(target);
                $(otherElems).each(function(){

                    $(this).slideUp('slow');
                    $(this).closest('.multi_level_member_each').find('.multi_level_member_ic i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                });

                target.slideToggle('slow');
                thiss.find('.multi_level_member_ic i').toggleClass('fa-chevron-right fa-chevron-down');
            }
        });

        $('.multi_level_member_up.end').click(function(){

            var thiss = $(this);
            $('.multi_level_member_up.end').not(thiss).removeClass('active');
            thiss.toggleClass('active');
            if(thiss.hasClass('active')){
                thiss.closest('form').find('.pro_service_val').val(thiss.attr('data-id'));
            }else{
                thiss.closest('form').find('.pro_service_val').val('');
            }
        });

        var $uploadCrop = new Array();
        $('.init_croppie').each(function(){

            var id = $(this).closest('.upload-demo').attr('data-id');
            $uploadCrop[id] = $(this).croppie({
                viewport: {
                    width: 300,
                    height: 160,
                    type: 'square'
                },
                enableExif: true,
                showZoomer: true,
            });
        });
        $('.init_croppie_story').each(function(){

            var id = $(this).closest('.upload-demo').attr('data-id');
            $uploadCrop[id] = $(this).croppie({
                viewport: {
                    width: 350,
                    height: 187,
                    type: 'square'
                },
                enableExif: true,
                showZoomer: true,
            });
        });

        $('.port_thumb_upload').on('change', function () { readCroppedFile(this); });

        $('body').delegate('.save_portfolio_outer', 'click', function(e){

            var form = $(this).closest('form');
            form.find('.has-danger').removeClass('has-danger');
            var error = 0;
            var title = form.find('.port_title');

            if(title.val() == ''){

                error = 1;
                title.addClass('has-danger');
            }

            if(!error){

                $('#body-overlay,#pro_uploading_in_progress_real').show();
                setTimeout(function() {
                    if(form.find('.upload-demo').hasClass('ready')){

                        var id = form.find('.upload-demo').attr('data-id');
                        $uploadCrop[id].croppie('result', {
                            type: 'canvas',
                            size: 'viewport'
                        }).then(function (resp) {

                            $(form).find('.port_thumb_data').val(resp);
                            form.submit();
                        });
                    }else{
                        form.submit();
                    }
                }, 500);
            }
        });

        $('.pro_content_closer').click(function(){

            $(this).parent().addClass('instant_hide');
        });

        $('.story_image_remove').click(function(){

            if(confirm('Are you sure you want to remove this image?')){

                var id = $(this).closest('.upload-demo').attr('data-id');
                var formData = new FormData();
                formData.append('id', id);
                $.ajax({

                    url: '/removeStoryImage',
                    type: "POST",
                    data: formData,
                    contentType:false,
                    cache: false,
                    processData: false,
                    success: function(data){

                        location.reload();
                    }
                });
            }
        });

        $('select[name="pro_splash_item"]').change(function(){

        	$(this).closest('form').submit();
        });

        function postMediaSubmit(thiss){

            thiss.closest('.banner_inner').addClass('busy');
            var formData = new FormData();
            formData.append('id', thiss.attr('data-type'));
            formData.append('background', $('#background_file').prop('files')[0]);
            formData.append('banner', $('#banner_file').prop('files')[0]);
            formData.append('logo', $('#logo_file').prop('files')[0]);

            $('#body-overlay,#pro_uploading_in_progress_real').show();

            $.ajax({

                url: '/saveUserMedia',
                type: 'POST',
                data: formData,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                dataType: "json",
                success: function (response) {

                    $('#body-overlay,#pro_uploading_in_progress_real').hide();

                    $(thiss).closest('.banner_inner').removeClass('busy').find('*').show();
                    $(thiss).closest('.banner_inner').find('img').hide();
                    if(thiss.attr('data-type') == 'custom_banner'){
                        $('#h_l_banner_content .display_current .banner_inner img').attr('src', response.image);
                        $('.pro_h_l_btn_each').removeClass('active');
                        $('.pro_h_l_btn_each[data-id="h_l_banner_content"]').addClass('active');
                    }
                    if(thiss.attr('data-type') == 'custom_logo'){
                        $('#h_logo_custom_content .display_current .banner_inner img').attr('src', response.image);
                    }
                    if(thiss.attr('data-type') == 'custom_background'){
                        $('#h_l_background_content .display_current .banner_inner img').attr('src', response.image);
                        $('.pro_h_l_btn_each').removeClass('active');
                        $('.pro_h_l_btn_each[data-id="h_l_background_content"]').addClass('active');
                    }
                    var pageUrl = window.location.href;
                    if(pageUrl.indexOf('profile-setup/design') !== -1){

                        location.reload();
                    }
                }
            });
        }

        function readCroppedFile(input) {
            var id = $(input).closest('.upload-demo').attr('data-id');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).closest('.upload-demo').find('.upload-current').addClass('instant_hide');
                    $(input).closest('.upload-demo').addClass('ready');
                    $uploadCrop[id].croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('[contenteditable]').on('paste',function(e) {

            e.preventDefault();
            var text;
            var clp = (e.originalEvent || e).clipboardData;
            if (clp === undefined || clp === null) {
                text = window.clipboardData.getData("text") || "";
                if (text !== "") {
                    if (window.getSelection) {
                        var newNode = document.createElement("span");
                        newNode.innerHTML = text;
                        window.getSelection().getRangeAt(0).insertNode(newNode);
                    } else {
                        document.selection.createRange().pasteHTML(text);
                    }
                }
            } else {
                text = clp.getData('text/plain') || "";
                if (text !== "") {
                    document.execCommand('insertText', false, text);
                }
            }
        });
    </script>
