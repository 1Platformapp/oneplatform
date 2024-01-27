@php $display = 'display: block;' @endphp

@if($page != 'media')
    @php $display = 'display: none;' @endphp
@endif

<div id="profile_tab_02" class="pro_my_music_sec pro_pg_tb_det" style="{{ $display }}">
    <div class="pro_pg_tb_det_inner">
        <div id="sample-audio-spectrum"></div>
        <div id="add_music_section" class="sub_cat_data {{$subTab == '' || $subTab == 'add-music' ? '' : 'instant_hide'}}">
            @if($user->internalSubscription)
            <form data-add="1" id="my-music-form" action="{{ route('save.user.profile_musics') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="duration" class="music_file_duration" value="0" />
            <div class="pro_music_info">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Upload Music & Manage Licenses</div>
                </div>
                @if(Session::has('seller_stripe_prompt'))
                    @include('parts.pro-stripeless-content', ['page' => 'add music'])
                @endif
                <div class="pro_inp_list_outer">
                    <div class="pro_explainer_outer">
                        <div class="pro_explainer_inner">
                            <div data-explainer-file="{{base64_encode('1-yMNUO4QVqmjSKI9J4JF78I7KggbeWP9')}}" data-explainer-title="License One" data-explainer-description="License video one" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Example 1
                                    </div>
                                </div>
                            </div>
                            <div data-explainer-file="{{base64_encode('1NlUeAlflUaf11oSwy-3xoIrb3tDAUjwy')}}" data-explainer-title="License One" data-explainer-description="License video two" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Example 2
                                    </div>
                                </div>
                            </div>
                            <div data-explainer-file="{{base64_encode('1T9uatfsnSPtTtA8rSz3jrzFPw--479o_')}}" data-explainer-title="License One" data-explainer-description="License video three" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Example 3
                                    </div>
                                </div>
                            </div>
                            <div data-explainer-file="{{base64_encode('1SSKe8-Ua6b2gntrU9MKFnHQxy4d1gB-8')}}" data-explainer-title="License One" data-explainer-description="License video four" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Example 4
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_explainer_video instant_hide">
                            <div class="pro_explainer_video_contain">
                                <div id="jwp_license"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pro_music_search pro_music_info no_border">
                    <div class="pro_note">
                        <ul>
                            <li>When users purchase a music license they will get the full wav files for professional use</li>
                            <li>If users purchase without license (for personal use) they will get the single track in MP3 format</li>
                        </ul>
                    </div>
                </div>
                <div class="pro_upload_video music_thum_sec clearfix">
                    <div class="pro_left_video_img">
                        <span class="upload_vieo_img" onclick="$('#music_thumb').trigger('click'); return false;">
                        	<img style="cursor: pointer;" src="{{asset('images/p_music_thum_img.png?v=1.2')}}" id="display-music-thumb" />
                        </span>
                        <a href="#" onclick="$('#music_thumb').trigger('click'); return false;">
                        	Add Artwork
                        </a>
                        <input accept="image/*" type="file" style="display: none;" name="music_thumb" id="music_thumb">
                    </div>
                    <div class="pro_left_video_img pro_file_uploader">
                        <span class="upload_vieo_img">
                        	<img class="music_file_button" style="cursor: pointer;" src="{{asset('images/p_music_thum_img.png?v=1.2')}}" />
                        </span>
                        <a class="p_music_filename" href="javascript:void(0)">Upload Music File</a>
                    </div>
                    <div class="pro_right_video_det"></div>
                </div>
            </div>

            <div class="music_sec_acourdiun_outer">

                <div class="music_sec_imput_outer">
                    <input type="file" name="music-file" class="music-file" style="display: none;" />
                    <ul>
                        <li><label><input type="text" placeholder="Name of the song" id="song_name" name="song_name" /></label></li>
                        <li style="display: none"><label><input type="text" placeholder="Name of the album" id="album_name" name="album_name" /></label></li>
                        <li>
                            <label><input type="text" placeholder="BPM" name="bpm" /></label>
                        </li>
                        <li class="pro_music_instruments_outer">
                            <label class="pro_input_icon">
                                <input autocomplete="off" type="text" placeholder="Search here to add instruments" name="instruments" />
                                <i class="fa fa-search"></i>
                            </label>
                            <div class="music_instruments_results pro_custom_drop_res instant_hide clearfix">
                                <div class="pro_instruments_list_drop">
                                    <ul></ul>
                                </div>
                            </div>
                            <div class="music_instruments_saved clearfix"></div>
                        </li>

                        <li>
                            <div class="music_sec_opt_outer">
                                <span>Genre</span>
                                <select id="dropdown_one" name="dropdown_one">
                                    <option value="">Genre</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="music_sec_opt_outer">
                                <span>Mood</span>
                                @php $moods = \App\Models\Mood::orderBy('id', 'asc')->get() @endphp
                                <select id="dropdown_two" name="dropdown_two">
                                    <option value="">Mood</option>
                                    @foreach($moods as $mood)
                                    <option value="{{$mood->name}}">{{$mood->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li class="pro_music_moods_outer">
                            <label class="pro_input_icon">
                                <input autocomplete="off" type="text" placeholder="Search here to add more moods" name="more_moods" />
                                <i class="fa fa-search"></i>
                            </label>
                            <div class="music_moods_results pro_custom_drop_res instant_hide clearfix">
                                <div class="pro_moods_list_drop">
                                    <ul></ul>
                                </div>
                            </div>
                            <div class="music_moods_saved clearfix"></div>
                        </li>
                    </ul>

                </div>

                <div class="music_sec_imput_outer lyrics_outer">
                    <ul>
                        <li>
                            <textarea name="lyrics" placeholder="Add Information / Lyrics / About / Etc"></textarea>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pro_m_license_pric_sec not_last_child">
                <div class="music_license_button">
                	<div class="music_license_head">Non License Fee</div>
                </div>
                <b>This option is for a user to buy a personal use only. If you enter 0 it will be free if u leave it empty the personal option will not show</b>
                <div class="music_ice_listing">
                    <ul>
                        <li class="each_license optional clearfix">
                        	<div class="each_license_body">
                        		<p class="p_lic_left">Personal use only</p>
                        		<input type="number" class="p_lic_right" placeholder="(0.99)" name="personal_use_only" min="0" />
                        	</div>
                        	<div class="each_license_terms">
                        		<div class="each_license_terms_handle">
                        		    <i class="fa fa-angle-down"></i>
                        		</div>
                        		<div class="each_license_terms_each">
                        		    <div class="each_license_topen">
                        		        <div class="each_license_topen_text">
                        		            For personal use only
                        		        </div>
                        		    </div>
                        		</div>
                        	</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pro_m_license_pric_sec music_license_expand">
                <div class="music_license_button">
                	<div class="music_license_head">Music Licensing <span>(Click to license this music)</span></div>
	                <div class="music_license_expand_button">
	                	<i class="fa fa-angle-down"></i>
	                </div>
	            </div>
	            <div class="music_license_expansion">
	            	<div class="music_license_rail_each">
	            		<div class="music_license_rail_button">
	            			<div class="music_license_rail_head">License Stems / Loops</div>
	            			<div class="music_license_rail_expand_button">
	            				<i class="fa fa-angle-down"></i>
	            			</div>
	            		</div>
	            		<div class="music_license_rail_expansion">
	            			<div class="pro_m_license_pric_sec not_last_child">
	            			    <b>The buyers who purchase without license (for personal use) can download</b>
	            			    <div class="pro_note">
	            			        <ul>
	            			            <li>Music main file</li>
	            			            <li>Personal use agreement in PDF</li>
	            			        </ul>
	            			    </div>
	            			    <b>The buyers who purchase with a license can download</b>
	            			    <div class="pro_note">
	            			        <ul>
	            			            <li>Music main file</li>
	            			            <li>Music Loops and stems</li>
	            			            <li>Respective license agreement in PDF</li>
	            			        </ul>
	            			    </div>
	            			    <div class="mu_down_uploader">
	            			        <div class="mu_down_main_sec">
	            			            <div class="mu_down_head">Add Loops</div>
	            			            <div class="each_row">
	            			                <div data-type="loop_one" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Loop</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			                <div data-type="loop_two" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Loop</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			            </div>
	            			            <div data-type="loop_three" class="mu_down_each">
	            			                <input  type="file" class="mu_down_file instant_hide" />
	            			                <div class="mu_down_file_button">
	            			                    <div class="mu_down_btn_text">Add Loop</div>
	            			                    <div class="mu_down_file_name instant_hide"></div>
	            			                    <i class="fa fa-plus"></i>
	            			                </div>
	            			            </div>
	            			        </div>
	            			        <div class="mu_down_main_sec">
	            			            <div class="mu_down_head">Add Stems</div>
	            			            <div class="each_row">
	            			                <div data-type="stem_one" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			                <div data-type="stem_two" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			            </div>
	            			            <div class="each_row">
	            			                <div data-type="stem_three" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			                <div data-type="stem_four" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			            </div>
	            			            <div class="each_row">
	            			                <div data-type="stem_five" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			                <div data-type="stem_six" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			            </div>
	            			            <div class="each_row">
	            			                <div data-type="stem_seven" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			                <div data-type="stem_eight" class="mu_down_each">
	            			                    <input  type="file" class="mu_down_file instant_hide" />
	            			                    <div class="mu_down_file_button">
	            			                        <div class="mu_down_btn_text">Add Stem</div>
	            			                        <div class="mu_down_file_name instant_hide"></div>
	            			                        <i class="fa fa-plus"></i>
	            			                    </div>
	            			                </div>
	            			            </div>
	            			        </div>
	            			    </div>
	            			</div>
	            		</div>
	            	</div>

	            	<div class="music_license_rail_each">
	            		<div class="music_license_rail_button">
	            			<div class="music_license_rail_head">License Prices</div>
	            			<div class="music_license_rail_expand_button">
	            				<i class="fa fa-angle-down"></i>
	            			</div>
	            		</div>
	            		<div class="music_license_rail_expansion">
	            			<div class="pro_m_license_pric_sec">
	            				<div class="pro_note">
	            				    <ul>
	            				        <li>Default Price: Use this option to automatically add an average price for each license</li>
	            				        <li>Free: Use this option to make all the licenses free of cost</li>
	            				        <li>POA: It stands for Price On Application or to make a particular license as POA type POA instead of a price below. <a class="inline_info" data-title="1 Platform: World's first bespoke licensing" href="https://www.youtube.com/embed/EksAIXYMEow?autoplay=0&origin={{config('constants.primaryDomain')}}&rel=0">Click here</a> to learn more about POA</li>
	            				        <li>Custom: Choose this option and then enter your custom price in a field below. This will change all the licenses to that price</li>
	            				        <li>Leave Empty: Use this option to remove prices from all licenses below</li>
	            				    </ul>
	            				</div>
	            				<b>Price the licenses below. You can use mass assignment tools if you wish. <a class="inline_info" data-title="1 Platform: World's first bespoke licensing" href="https://www.youtube.com/embed/EksAIXYMEow?autoplay=0&origin={{config('constants.primaryDomain')}}&rel=0">Click here</a> to learn more about licensing</b>
	            			    <div class="license_tools_outer">
	            			        <div class="license_fill_options_outer">
	            			        	<div data-id="1" class="license_fill_options_each">Default Prices</div>
	            			        	<div data-id="2" class="license_fill_options_each">Free</div>
	            			        	<div data-id="3" class="license_fill_options_each">POA</div>
	            			        	<div data-id="4" class="license_fill_options_each">Custom</div>
	            			        	<div data-id="5" class="license_fill_options_each">Leave Empty</div>
	            			        </div>
	            			        <div class="license_custom_price_outer">
	            			            <input type="number" value="" class="license_custom_price" placeholder="Enter Price (applies to ticked licenses below)">
	            			        </div>
	            			    </div>
	            			    <div class="music_ice_listing">
	            			        <ul>
	            			        	@foreach(config('constants.licenses') as $key => $license)

	            			            <li class="clearfix each_license optional" data-price="{{$license['price']}}">
	            			                <div class="each_license_body">
	            			                	<div class="license_check_outer">
	            			                	    <input type="checkbox">
	            			                	</div>
	            			                	<p class="p_lic_left">{{$license['name']}}</p>
	            			                	<input type="text" class="p_lic_right" placeholder="({{$license['price']}})" name="{{$license['input_name']}}" />
	            			                </div>
	            			                <div class="each_license_terms">
	            			                	<div class="each_license_terms_handle">
	            			                	    <i class="fa fa-angle-down"></i>
	            			                	</div>
	            			                	<div class="each_license_terms_each">
	            			                	    @php $licenseTermRec = \App\Models\LicenseTerms::find($license['terms_id']) @endphp
	            			                	    @if($licenseTermRec && count($licenseTermRec->terms))
	            			                	        @foreach($licenseTermRec->terms as $value)
                                                            <div class="each_license_topen">
                                                                <div class="each_license_topen_text">
                                                                    {{$value}}
                                                                </div>
                                                            </div>
                                                        @endforeach
	            			                	    @endif
	            			                	</div>
	            			                </div>
	            			            </li>
	            			            @endforeach
	            			        </ul>
	            			    </div>
	            			</div>
	            		</div>
	            	</div>
	            	<br><br>
	            </div>
            </div>

            <div class="pro_m_chech_outer">
                <ul>
                    <input type="hidden" id="is_full_ownership" name="is_full_ownership" value="0">
                    <input type="hidden" id="use_of_licenses_perpetual" name="use_of_licenses_perpetual" value="0">
                    <input type="hidden" class="allow_bespoke_license_offer" name="allow_bespoke_license_offer" value="0">
                    <li><span id="full_ownership">I agree that I have full ownership of my music</span></li>
                    <li><span class="bespoke_license_offer">Allow bespoke license offers for this music</span></li>
                    <li><span id="licenses_perpetual">I agree to these <a href="#">terms and conditions</a></span></li>
                </ul>
            </div>

            <div class="save_music_outer edit_profile_btn_1 clearfix">
                <a href="javascript:void(0)">Upload</a>
            </div>

            </form>
            @endif
        </div>

        <div id="my_products_section" class="sub_cat_data {{$subTab == 'products' ? '' : 'instant_hide'}}">
            @if($user->internalSubscription)

    	            <div class="pro_music_info">
    	                <div class="pro_main_tray">
                            <div class="pro_tray_title">Manage Your Products</div>
                            <div class="pro_tray_tabs">
                                <div class="pro_tray_sep"></div>
                                <div title="Add product" data-key="product_add" class="pro_tray_tab_each active">
                                    <div class="pro_tray_tab_title"></div>
                                    <div class="pro_tray_tab_icon">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div class="pro_tray_sep"></div>
                                <div data-key="product_list" title="Edit products" class="pro_tray_tab_each">
                                    <div class="pro_tray_tab_title"></div>
                                    <div class="pro_tray_tab_icon">
                                        <i class="fa fa-edit"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Session::has('seller_stripe_prompt'))
                            @include('parts.pro-stripeless-content', ['page' => 'add products'])
                        @endif
    	            </div>
                    <div data-value="product_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
                        <div class="pro_note">
                            <ul>
                                <li>Create your products, gigs or tickets and promote/sell them on your website</li>
                                <li>You can also create printed products and sell them on your website</li>
                            </ul>
                        </div>
                        <form id="prod_gig_form" action="{{isset($setupWizard) ? '' : route('save.user.profile_prod_gigs')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="pro_options_outer">
                                <div data-href="pro_option_one" class="pro_options_each {{$content == null || $content == 'product' ? 'active' : ''}}">
                                    <div class="pro_option_name">
                                        Product
                                    </div>
                                    <div class="pro_option_desc">
                                        Ideal for your ready made products
                                    </div>
                                </div>
                                <div data-href="pro_option_two" class="pro_options_each {{$content == 'pod' ? 'active' : ''}}">
                                    <div class="pro_option_name">
                                        Print
                                    </div>
                                    <div class="pro_option_desc">
                                        You design it, we print and ship it to your fans
                                    </div>
                                </div>
                            </div>
                            <div data-id="pro_option_two" class="pro_option_body_each pro_m_license_pric_sec {{$content == 'pod' ? '' : 'instant_hide'}}">
                                @if($userPersonalDetails['countryId'] == 213 || $userPersonalDetails['countryId'] == 214)
                                <div data-id="pro_design_st1" class="pro_design_expand enabled">
                                    <div class="music_license_button">
                                        <div class="music_license_head">Step 1 - Choose Your design</div>
                                    </div>
                                    <div id="pro_design_st1_error" class="error_span design_error instant_hide">
                                        <i class="fa fa-exclamation-triangle"></i> Choose your design image
                                    </div>
                                    @if(count($user->productDesigns))
                                    <h3 class="pro_edit_sub_head">Choose from your existing designs</h3>
                                    <div class="pro_inp_list_outer">
                                        <div class="pro_note">
                                            <ul>
                                                <li>If you've already uploaded images, you can use these files again to create different products for your store</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pro_design_exist">
                                        <div class="pro_design_exist_in">
                                            @foreach($user->productDesigns as $designImage)
                                            <div class="pro_design_exist_each">
                                                <div class="pro_design_each_thumb">
                                                    <img src="{{asset('prints/uf_'.$user->id.'/templates/'.$designImage->file_name)}}">
                                                </div>
                                                <input type="radio" value="{{$designImage->id}}" name="pro_design_value" />
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="save_design_step_one edit_profile_btn_1 clearfix">
                                            <a href="javascript:void(0)">Continue</a>
                                        </div>
                                    </div>
                                    <h3 class="pro_edit_sub_head">Or upload a new design</h3>
                                    @else
                                    <h3 class="pro_edit_sub_head">Upload a new design</h3>
                                    @endif
                                    <div class="pro_inp_list_outer">
                                        <div class="pro_note">
                                            <ul>
                                                <li>Please use JPEG, PNG or GIF. We do not accept vector or PSD files</li>
                                                <li>Image file size should be less than 10MB</li>
                                                <li>Image dimension should be at least 800px on either side</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" id="pro_prod_design" />
                                    <div class="pro_design_new_outer">
                                        <div class="pro_design_new">
                                            <input accept="image/jpeg,image/gif,image/png" type="file" id="pro_design_file" name="pro_design_file" />
                                        </div>
                                        <div class="save_design_step_one edit_profile_btn_1 clearfix">
                                            <a href="javascript:void(0)">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-id="pro_design_st2" class="pro_m_license_pric_sec pro_design_expand instant_hide">
                                    <div class="music_license_button">
                                        <div class="music_license_head">Step 2 - Choose Design Type</div>
                                        <div class="music_license_expand_button">
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                    </div>
                                    <div class="pro_design_expansion instant_hide">
                                        <div class="pro_design_st_2_outer">
                                            <div class="pro_design_st_2_each">
                                                <div id="flexible_color_design_file" class="pro_design_st2_thumb">
                                                    <img src="">
                                                </div>
                                                <div class="pro_design_st2_picker">
                                                    <div class="pro_dst2_picker_field">
                                                        <input type="radio" name="pro_design_st2" value="1" />
                                                    </div>
                                                    <div class="pro_dst2_picker_name">
                                                        Single Color (flexible)
                                                    </div>
                                                </div>
                                                <div class="pro_design_st2_notes">
                                                    <div class="pro_note">
                                                        <ul>
                                                            <li>This print process is for single colour designs only, and those that DO NOT include shading or fine detail</li>
                                                            <li>The advantage of this process is flexibility - the logo colour is not fixed, and so your fans can choose any of the colour combos we offer at any time</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pro_design_st_2_each">
                                                <div id="fixed_color_design_file" class="pro_design_st2_thumb">
                                                    <img src="">
                                                </div>
                                                <div class="pro_design_st2_picker">
                                                    <div class="pro_dst2_picker_field">
                                                        <input checked type="radio" name="pro_design_st2" value="2" />
                                                    </div>
                                                    <div class="pro_dst2_picker_name">
                                                        Full Color (fixed)
                                                    </div>
                                                </div>
                                                <div class="pro_design_st2_notes">
                                                    <div class="pro_note">
                                                        <ul>
                                                            <li>This print process is for images of more than one colour, or those that include shading or fine detail</li>
                                                            <li>Your image will be printed EXACTLY as shown in the previews</li>
                                                            <li>If you would like to know how to make your image transparent, and therefore not have your background printed on your products</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save_design_step_two edit_profile_btn_1 clearfix">
                                            <a href="javascript:void(0)">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-id="pro_design_st3" class="pro_m_license_pric_sec pro_design_expand">
                                    <div class="music_license_button">
                                        <div class="music_license_head">Step 2 - Choose Product</div>
                                        <div class="music_license_expand_button">
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                    </div>
                                    <div class="pro_design_expansion instant_hide">
                                        <div class="pro_design_st3_notes">
                                            <div class="pro_note">
                                                <ul>
                                                    <li>Here you can drag your design to change position,zoom in,zoom out or roll over to change its angle</li>
                                                    <li>This is what your design will look like on a medium sized product</li>
                                                    <li>We will save this image so that you can use it for other products too</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="pro_design_st_3_outer">
                                            <div class="pro_design_st_3_each">
                                                <div class="pro_design_st3_prod_outer">
                                                    <div class="d_manipulator">
                                                        <div class="d_manipulator_in">
                                                            <div class="d_manipulator_area">
                                                                <img data-rotate="0" class="d_manipulator_elem" src="" />
                                                            </div>
                                                        </div>
                                                        <div class="d_manipulator_tools">
                                                            <div id="upload_design_rr" class="d_manipulator_tool_each">
                                                                <i class="fa fa-rotate-right"></i>
                                                            </div>
                                                            <div id="upload_design_rl" class="d_manipulator_tool_each">
                                                                <i class="fa fa-rotate-left"></i>
                                                            </div>
                                                            <div id="upload_design_zi" class="d_manipulator_tool_each">
                                                                <i class="fa fa-plus"></i>
                                                            </div>
                                                            <div id="upload_design_zo" class="d_manipulator_tool_each">
                                                                <i class="fa fa-minus"></i>
                                                            </div>
                                                            <div id="upload_design_center" class="d_manipulator_tool_each">
                                                                <i class="fa fa-align-center"></i>
                                                            </div>
                                                            <div id="upload_design_refresh" class="d_manipulator_tool_each">
                                                                <i class="fa fa-refresh"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="port_each_field">
                                                        <div class="port_field_label">
                                                            <div class="port_field_label_text">Name Your Product</div>
                                                        </div>
                                                        <div class="pro_stream_input_each">
                                                            <input class="pro_stream_input" name="prod_name" type="text" placeholder="Product Name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pro_design_st_3_each">
                                                @php $proWomen = \App\Models\CustomProduct::find(1) @endphp
                                                @php $proMen = \App\Models\CustomProduct::find(2) @endphp
                                                @php $proHoodies = \App\Models\CustomProduct::find(3) @endphp
                                                @php $proMugs = \App\Models\CustomProduct::find(4) @endphp
                                                @php $proCaps = \App\Models\CustomProduct::find(5) @endphp
                                                <div class="pro_design_st3_prod_options">
                                                    @if($proWomen->status == 1)
                                                    <div data-type="women" data-pos-left="130" data-pos-top="85" data-width="130" data-height="160" class="pro_design_st3_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img src="{{asset('images/test/design/women/image-white.jpg')}}" />
                                                        </div>
                                                        <div class="st3_prod_option_action">
                                                            <div class="st3_prod_option_name">
                                                                Women's
                                                            </div>
                                                            <div class="st3_prod_option_field">
                                                                <input type="radio" name="pro_prod_value" value="{{$proWomen->id}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($proMen->status == 1)
                                                    <div data-type="men" data-pos-left="128" data-pos-top="85" data-width="130" data-height="160" class="pro_design_st3_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img src="{{asset('images/test/design/men/image-royal-blue.jpg')}}" />
                                                        </div>
                                                        <div class="st3_prod_option_action">
                                                            <div class="st3_prod_option_name">
                                                                Men's
                                                            </div>
                                                            <div class="st3_prod_option_field">
                                                                <input type="radio" name="pro_prod_value" value="{{$proMen->id}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($proHoodies->status == 1)
                                                    <div data-type="hoodies" data-pos-left="140" data-pos-top="85" data-width="130" data-height="160" class="pro_design_st3_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img src="{{asset('images/test/design/hoodies/image-grey.jpg')}}" />
                                                        </div>
                                                        <div class="st3_prod_option_action">
                                                            <div class="st3_prod_option_name">
                                                                Hoodies
                                                            </div>
                                                            <div class="st3_prod_option_field">
                                                                <input type="radio" name="pro_prod_value" value="{{$proHoodies->id}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($proMugs->status == 1)
                                                    <div data-type="mugs" data-pos-left="140" data-pos-top="50" data-width="230" data-height="280" class="pro_design_st3_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img src="{{asset('images/test/design/mugs/image-white.jpg')}}" />
                                                        </div>
                                                        <div class="st3_prod_option_action">
                                                            <div class="st3_prod_option_name">
                                                                Mugs
                                                            </div>
                                                            <div class="st3_prod_option_field">
                                                                <input type="radio" name="pro_prod_value" value="{{$proMugs->id}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($proCaps->status == 1)
                                                    <div data-type="caps" data-pos-left="100" data-pos-top="100" data-width="200" data-height="120"class="pro_design_st3_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img src="{{asset('images/test/design/caps/image-royal-blue.jpg')}}" />
                                                        </div>
                                                        <div class="st3_prod_option_action">
                                                            <div class="st3_prod_option_name">
                                                                Caps
                                                            </div>
                                                            <div class="st3_prod_option_field">
                                                                <input type="radio" name="pro_prod_value" value="{{$proCaps->id}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save_design_step_three edit_profile_btn_1 clearfix">
                                            <a href="javascript:void(0)">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-id="pro_design_st4" class="pro_m_license_pric_sec pro_design_expand">
                                    <div class="music_license_button">
                                        <div class="music_license_head">Step 3 - Choose Product Color</div>
                                        <div class="music_license_expand_button">
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                    </div>
                                    <div id="pro_design_st4_error" class="error_span design_error instant_hide">
                                        <i class="fa fa-exclamation-triangle"></i> Select at least one color
                                    </div>
                                    <div class="pro_design_expansion instant_hide">
                                        <div class="pro_design_st3_notes">
                                            <div class="pro_note">
                                                <ul>
                                                    <li>Choose which colors this product should be available to your fans</li>
                                                    <li>You must make your product available in at least one color</li>
                                                    <li>You can also choose which color should be the default</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="pro_design_st_3_outer">
                                            <div class="pro_design_st_3_each">
                                                <div class="pro_design_st4_prod_outer">
                                                    <img src="">
                                                </div>
                                                <div class="port_each_field">
                                                    <div class="port_field_label">
                                                        <div class="port_field_label_text">Choose Default Color</div>
                                                    </div>
                                                    <div class="port_field_body pro_stream_input_each">
                                                        <div class="stream_sec_opt_outer">
                                                            <select name="pro_prod_color_default"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pro_design_st_3_each">
                                                @php $proWomen = \App\Models\CustomProduct::find(1) @endphp
                                                @php $proMen = \App\Models\CustomProduct::find(2) @endphp
                                                @php $proHoodies = \App\Models\CustomProduct::find(3) @endphp
                                                @php $proMugs = \App\Models\CustomProduct::find(4) @endphp
                                                @php $proCaps = \App\Models\CustomProduct::find(5) @endphp
                                                @if($proWomen->status == 1)
                                                <div data-colors-for="women" class="pro_design_st3_prod_options instant_hide">
                                                    @foreach($proWomen->colors as $color)
                                                    @php $colorSlug = str_slug($color) @endphp
                                                    <div class="pro_design_st4_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img data-src="{{asset('images/test/design/women').'/image-'.$colorSlug.'.jpg'}}" src="" />
                                                        </div>
                                                        <div class="st4_prod_option_action">
                                                            <div class="st4_prod_option_field">
                                                                <input checked type="checkbox" value="{{$colorSlug}}" />
                                                            </div>
                                                            <div class="st4_prod_option_name">
                                                                {{$color}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                @if($proMen->status == 1)
                                                <div data-colors-for="men" class="pro_design_st3_prod_options instant_hide">
                                                    @foreach($proMen->colors as $color)
                                                    @php $colorSlug = str_slug($color) @endphp
                                                    <div class="pro_design_st4_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img data-src="{{asset('images/test/design/men').'/image-'.$colorSlug.'.jpg'}}" src="" />
                                                        </div>
                                                        <div class="st4_prod_option_action">
                                                            <div class="st4_prod_option_field">
                                                                <input checked type="checkbox" value="{{$colorSlug}}" />
                                                            </div>
                                                            <div class="st4_prod_option_name">
                                                                {{$color}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                @if($proCaps->status == 1)
                                                <div data-colors-for="caps" class="pro_design_st3_prod_options instant_hide">
                                                    @foreach($proCaps->colors as $color)
                                                    @php $colorSlug = str_slug($color) @endphp
                                                    <div class="pro_design_st4_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img data-src="{{asset('images/test/design/caps').'/image-'.$colorSlug.'.jpg'}}" src="" />
                                                        </div>
                                                        <div class="st4_prod_option_action">
                                                            <div class="st4_prod_option_field">
                                                                <input checked type="checkbox" value="{{$colorSlug}}" />
                                                            </div>
                                                            <div class="st4_prod_option_name">
                                                                {{$color}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                @if($proMugs->status == 1)
                                                <div data-colors-for="mugs" class="pro_design_st3_prod_options instant_hide">
                                                    @foreach($proMugs->colors as $color)
                                                    @php $colorSlug = str_slug($color) @endphp
                                                    <div class="pro_design_st4_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img data-src="{{asset('images/test/design/mugs').'/image-'.$colorSlug.'.jpg'}}" src="" />
                                                        </div>
                                                        <div class="st4_prod_option_action">
                                                            <div class="st4_prod_option_field">
                                                                <input checked type="checkbox" value="{{$colorSlug}}" />
                                                            </div>
                                                            <div class="st4_prod_option_name">
                                                                {{$color}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                @if($proHoodies->status == 1)
                                                <div data-colors-for="hoodies" class="pro_design_st3_prod_options instant_hide">
                                                    @foreach($proHoodies->colors as $color)
                                                    @php $colorSlug = str_slug($color) @endphp
                                                    <div class="pro_design_st4_prod_option_each">
                                                        <div class="st3_prod_option_thumb">
                                                            <img data-src="{{asset('images/test/design/hoodies').'/image-'.$colorSlug.'.jpg'}}" src="" />
                                                        </div>
                                                        <div class="st4_prod_option_action">
                                                            <div class="st4_prod_option_field">
                                                                <input checked type="checkbox" value="{{$colorSlug}}" />
                                                            </div>
                                                            <div class="st4_prod_option_name">
                                                                {{$color}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="save_design_step_four edit_profile_btn_1 clearfix">
                                            <a href="javascript:void(0)">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-id="pro_design_st5" class="pro_m_license_pric_sec pro_design_expand">
                                    <div class="music_license_button">
                                        <div class="music_license_head">Step 4 - Edit Product Prices and Commission</div>
                                        <div class="music_license_expand_button">
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                    </div>
                                    <div class="pro_design_expansion instant_hide">
                                        <div class="pro_design_st3_notes">
                                            <div class="pro_note">
                                                <ul>
                                                    <li>Choose a sale price for your product below. We've set it at a sensible default which works for most people. The price you set will be inclusive of UK VAT</li>
                                                    <li>The minimum price you can set is <span class="pro_design_min_price"></span></li>
                                                    <li>The commission is the amount you make from each product sold and is calculated automatically from the sale price</li>
                                                    <li>We add a small percentage to your commission if the sale price you set is above our recommended level</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="pro_design_st_5_outer">
                                            <div class="port_each_field">
                                                <div class="port_field_label">
                                                    <div class="port_field_label_text">Price (min <span class="pro_design_min_price"></span>)</div>
                                                </div>
                                                <div class="port_field_body">
                                                    <input type="text" class="port_field_text" placeholder="Enter Price" name="pro_prod_price">
                                                </div>
                                            </div>
                                            <div class="pro_design_st_5_commission">
                                                <div class="pro_design_st_5_comm">
                                                    <div class="pro_design_st_5_comm_txt">Your commission</div>
                                                    <div class="pro_design_st_5_comm_val">13.45 GBP</div>
                                                </div>
                                                <div class="pro_design_st_5_comm_calc">Recalculate</div>
                                            </div>
                                        </div>
                                        <div class="save_design_step_five edit_profile_btn_1 clearfix">
                                            <a href="javascript:void(0)">Submit</a>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <img src="{{asset('images/printed-4.jpg')}}">
                                @endif
                            </div>
                            <div data-id="pro_option_one" class="pro_option_body_each {{$content == null || $content == 'product' ? '' : 'instant_hide'}}">
                                <div class="pro_upload_video music_thum_sec clearfix">
                                    <div class="pro_left_video_img">
                                        <span class="upload_vieo_img" onclick="$('#product_thumb').trigger('click'); return false;"> <img src="{{asset('images/p_music_thum_img.png?v=1.2')}}" alt="#" id="display-product-thumb" /></span>
                                        <a style="color:#ec2450; cursor: pointer;" onclick="$('#product_thumb').trigger('click'); return false;">Add Thumbnail</a>
                                        <input accept="image/*" type="file" style="display: none;" name="product_thumb" id="product_thumb">
                                    </div>
                                    <div class="pro_right_video_det">
                                        <p>Add your product here. Fill all the relevant fields</p>
                                    </div>
                                </div>
                                <div class="pro_stream_input_each">
                                    <input placeholder="Product Title" type="text" class="pro_stream_input product_title" name="product_title">
                                </div>
                                <div class="pro_stream_input_each">
                                    <textarea placeholder="Description" class="pro_news_textarea" name="product_description"></textarea>
                                </div>
                                <div class="pro_stream_input_each">
                                    <textarea placeholder="Add items as bullets separated by comma i.e item 1,item 2,item 3" class="pro_news_textarea" name="product_includes"></textarea>
                                </div>
                                <div class="pro_stream_input_each">
                                    <input class="pro_stream_input" type="number" placeholder="Product Quantity (Leave empty if unlimited or does not apply)" name="product_amount_available" min="1" />
                                </div>
                                <div class="pro_stream_input_row">
                                    <div class="pro_stream_input_each">
                                        <div class="stream_sec_opt_outer">
                                            <select class="pro_product_price_option" name="pro_product_price_option">
                                                <option value="addprice">Add price</option>
                                                <option value="poa">POA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pro_stream_input_each">
                                        <input class="product_price pro_stream_input" type="number" placeholder="Price" name="product_price" min="1" />
                                    </div>
                                </div>
                                <div class="pro_stream_input_row">
                                    <div class="pro_stream_input_each">
                                        <div class="stream_sec_opt_outer">
                                            <select class="pro_product_shipping_option" name="pro_product_shipping_option">
                                                <option value="">Does this product require shipping?</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pro_stream_input_row">
                                        <div class="pro_stream_input_each">
                                            <input class="local_delivery pro_stream_input" type="number" min="1" placeholder="Local Delivery" name="local_delivery" disabled />
                                        </div>
                                        <div class="pro_stream_input_each">
                                            <input class="international_shipping pro_stream_input" type="number" min="1" placeholder="International Shipping" name="international_shipping" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="pro_stream_input_row">
                                    <div class="pro_stream_input_each">
                                        <div class="stream_sec_opt_outer">
                                            <select class="pro_product_ticket_option" name="pro_product_ticket_option">
                                                <option value="">Is this product a ticket for a gig/event?</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pro_stream_input_row">
                                        <div class="pro_stream_input_each">
                                            <input class="product_ticket_date_time pro_stream_input" type="text" placeholder="Date And Time" name="date_time" disabled />
                                        </div>
                                        <div class="pro_stream_input_each">
                                            <input class="product_ticket_location pro_stream_input" type="text" placeholder="Location/city" name="location" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="pro_stream_input_each">
                                    <textarea disabled class="product_ticket_terms pro_news_textarea" placeholder="Ticket terms and conditions (if any)" name="terms_conditions"></textarea>
                                </div>
                                <div class="proj_cont_flt_outer proj_bottom_description">
                                    <p>
                                        By clicking Save, you agree to our <a target="_blank" href="{{route('tc')}}">terms and conditions</a>
                                    </p>
                                </div>
                                <div class="save_product_outer edit_profile_btn_1 clearfix">
                                    <a href="javascript:void(0)">Submit</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div data-value="product_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">

                        <div class="pro_note">
                            <ul>
                                <li>The list below will display the products or gigs/tickets you have created</li>
                                <li>Promote them by clicking the star icon next to it</li>
                                <li>You can change the order of their appearance on your website</li>
                            </ul>
                        </div>
                        @if(count($user->products) > 0)
                            @foreach($user->products as $userProduct)
                                <div data-sort="product_{{$userProduct->id}}" class="pro_prod_outer elem_sortable music_btm_list">
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
                                            <img src="{{ $commonMethods::getUserProductLeftThumbnail($userProduct->id) }}" alt="#" />
                                            <ul class="music_btm_img_det">
                                                <li>
                                                    <label>{{ $userProduct->title }}</label>
                                                    @if($userProduct->voucher_id)
                                                    <div>
                                                        <p>{{$vouchers[$userProduct->voucher_id]['name']}}</p>
                                                    </div>
                                                    @endif
                                                    @if($userProduct->quantity != NULL)
                                                    <div class="clearfix">
                                                        <p>{{ $userProduct->items_claimed }} out of {{ $userProduct->items_available }}</p>
                                                    </div>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0)" title="Feature" class="m_btm_star {{ ( $userProduct->featured == '1' ) ? 'active' : '' }}" data-product-id="{{ $userProduct->id }}">
                                                    <i class="fa fa-star"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="{{$userProduct->id}}" class="m_btm_edit" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="m_btm_del" title="Delete" data-del-id="{{ $userProduct->id }}" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="edit_elem_bottom">
                                        @include('parts.user-product-edit-template', ["product" => $userProduct])
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <br><br><br>
                            <div class="no_results">You have not added any products yet</div>
                        @endif
                    </div>
            @endif
        </div>
        <div id="videos_section" class="sub_cat_data {{$subTab == 'videos' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage YouTube / SoundCloud Links</div>
                <div class="pro_tray_tabs">
                    <div class="pro_tray_sep"></div>
                    <div title="Add video" data-key="video_add" class="pro_tray_tab_each active">
                        <div class="pro_tray_tab_title"></div>
                        <div class="pro_tray_tab_icon">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                    <div class="pro_tray_sep"></div>
                    <div data-key="video_list" title="Edit videos" class="pro_tray_tab_each">
                        <div class="pro_tray_tab_title"></div>
                        <div class="pro_tray_tab_icon">
                            <i class="fa fa-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
            @if(Session::has('seller_stripe_prompt'))
                @include('parts.pro-stripeless-content', ['page' => 'add videos'])
            @endif
            <div class="pro_note">
                <ul>
                    <li>You can add YouTube or SoundCloud Links here</li>
                    <li>All links must be music related to you or the platform. You must own the copyrights</li>
                    <li>You will be able to optionally use a YouTube link and apply for 1Platform chart competition (Coming soon)</li>
                </ul>
            </div>
            @if($user->internalSubscription)
                <div data-value="video_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
                    <form action="{{isset($setupWizard) ? '' : route('post-user-competition-video')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="pro_music_info">
                            <div class="pro_stream_input_outer">
                                <div class="pro_stream_input_each">
                                    <input class="pro_stream_input video_url" name="video_url" type="text" placeholder="Paste Your URL" />
                                </div>
                                <!--
                                <div class="pro_stream_input_each">
                                    <div class="stream_sec_opt_outer">
                                        <select class="video_chart_entry" name="showCart">
                                            <option value="">Do you want to submit this upload to 1Platform chart competition?</option>
                                            <option value="1">Yes</option>
                                            <option value="0">Not at the moment</option>
                                        </select>
                                    </div>
                                </div>
                                !-->
                                <div class="proj_cont_flt_outer proj_bottom_description">
                                    <p>
                                        By clicking Submit, you agree to our
                                        <a target="_blank" href="{{route('tc')}}">terms and conditions</a>
                                    </p>
                                </div>
                                <div class="save_video_outer edit_profile_btn_1 clearfix">
                                    <a href="javascript:void(0)">Submit</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div data-value="video_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">
                    @foreach($user->uploads as $key => $video)
                    <div id="uvideo_{{$video->id}}" class="pro_prod_outer music_btm_list">
                        <div class="edit_elem_top">
                            <div class="m_btm_list_left">
                                <img src="{{ ( $video->type == 'soundcloud' ) ? asset('img').'/soundcloud.png' : 'https://i.ytimg.com/vi/'.$video->video_id.'/mqdefault.jpg' }}" alt="{{$video->title}}">
                                <ul class="music_btm_img_det">
                                    <li>
                                        <label>{{$video->title}}</label>
                                        <div class="clearfix">
                                            <p>{{$video->user->name}}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" class="m_btm_del" title="Delete" data-del-id="{{$video->id}}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div id="social_section" class="sub_cat_data {{$subTab == 'social-media' ? '' : 'instant_hide'}} pro_my_profil_sec">
        	@if($user->internalSubscription)
            <div class="pro_main_tray">
                <div class="pro_tray_title">Add Your Social Media Accounts (Appears On Your Social Tab)</div>
            </div>
            <div class="pro_social_btn_outer clearfix">
                <ul>
                    <li><a class="pro_soc_icon_fb {{ ( $userSocialAccountDetails['facebook_account'] != '' ) ? 'connected' : 'not-connected' }}" href="#"></a></li>
                    <li><a class="pro_soc_icon_youtube {{ ( $userSocialAccountDetails['youtube_account'] != '' ) ? 'connected' : 'not-connected' }}" href="#"></a></li>
                    <!--<li><a class="pro_soc_icon_inst {{ ( $userSocialAccountDetails['instagram_user_id'] != '' ) ? 'connected' : 'not-connected' }}" href="#"></a></li>!-->
                    <li><a class="pro_soc_icon_tweet {{ ( $userSocialAccountDetails['twitter_account'] != '' ) ? 'connected' : 'not-connected' }}" href="#"></a></li>
                    <!--<li><a class="pro_soc_icon_cloud not-connected" href="#"></a></li>!-->
                    <li><a class="pro_soc_icon_singnal {{($userSocialAccountDetails['spotify_artist_id'] != '') ? 'connected' : 'not-connected'}}" href="#"></a></li>
                </ul>
            </div>
            @endif
        </div>
        <div id="live_streams_section" class="sub_cat_data pro_my_profil_sec {{$subTab == 'premium-videos' ? '' : 'instant_hide'}}">
            @if($user->internalSubscription)
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Manage Premium Videos</div>
                    <div class="pro_tray_tabs">
                        <div class="pro_tray_sep"></div>
                        <div title="Add premium video" data-key="premium_add" class="pro_tray_tab_each active">
                            <div class="pro_tray_tab_title"></div>
                            <div class="pro_tray_tab_icon">
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                        <div class="pro_tray_sep"></div>
                        <div data-key="premium_list" title="Edit premium videos" class="pro_tray_tab_each">
                            <div class="pro_tray_tab_title"></div>
                            <div class="pro_tray_tab_icon">
                                <i class="fa fa-edit"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has('seller_stripe_prompt'))
                    @include('parts.pro-stripeless-content', ['page' => 'add premium videos'])
                @endif
                <div class="pro_inp_list_outer">
                    <div class="pro_explainer_outer">
                        <div class="pro_explainer_inner">
                            <div data-explainer-file="{{base64_encode('1M8-j494LHTZD9KY7rvocYYICpdKGechk')}}" data-explainer-title="Premium Video" data-explainer-description="Add premium videos" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Premium Video
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_explainer_video instant_hide">
                            <div class="pro_explainer_video_contain">
                                <div id="jwp_premium"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-value="premium_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
                    <form id="add_live_streams_form" action="{{route('user.live.stream.create')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="pro_music_info">
                            <div class="pro_upload_video music_thum_sec clearfix">
                                <div class="pro_left_video_img">
                                    <span class="upload_vieo_img">
                                        <img src="/images/p_music_thum_img.png?v=1.2" alt="#" id="display-stream-thumb" class="display-stream-thumb" />
                                    </span>
                                    <a class="display-stream-thumb">Add Thumbnail</a>
                                    <input accept="image/*" type="file" style="display: none;" name="live_stream_thumb" class="live_stream_thumb" />
                                </div>
                                <div class="pro_right_video_det">
                                    <p>You can upload a custom thumbnail</p>
                                </div>
                            </div>
                        </div>
                        <div class="pro_stream_input_outer">
                            <div class="pro_stream_input_each">
                                <input placeholder="Add Your Video/Stream URL" type="text" class="pro_stream_input" name="pro_stream_url" />
                            </div>
                            <div class="pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select id="pro_stream_product" name="pro_stream_product">
                                        <option value="">Choose Product (optional)</option>
                                        <option value="all">All products</option>
                                        @foreach($user->products as $product)
                                        <option value="{{$product->id}}">{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select id="pro_stream_music" name="pro_stream_music">
                                        <option value="">Choose Music (optional)</option>
                                        <option value="all">All musics</option>
                                        @foreach($user->musics as $music)
                                        <option value="{{$music->id}}">{{$music->song_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select id="pro_stream_more_viewers" name="pro_stream_more_viewers">
                                        <option value="">Choose who have access (optional)</option>
                                        <option value="all_subs">My subscribers</option>
                                        <option value="all_fans">My fans</option>
                                        <option value="all_follow">My followers</option>
                                        <option value="all_subs_fans_follow">All of above</option>
                                    </select>
                                </div>
                            </div>
                            <div class="save_live_stream_outer edit_profile_btn_1 clearfix">
                                <a href="javascript:void(0)">Submit</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div data-value="premium_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">
                    @if(count($user->liveStreams))
                    @foreach($user->liveStreams as $stream)
                    @if($stream->thumbnail && $stream->thumbnail != '')
                        @php $editProdThumb = asset('user-stream-thumbnails/'.$stream->thumbnail) @endphp
                    @else
                        @php $editProdThumb = asset('img/url-thumb-profile.jpg') @endphp
                    @endif
                    <div data-form="my-stream-form_{{ $stream->id }}" class="music_btm_list no_sorting clearfix">

                        <div class="edit_elem_top">
                            <div class="m_btm_list_left">
                                <img src="{{$editProdThumb}}" alt="#">
                                <ul class="music_btm_img_det">
                                    <li><a href="javascript:void(0)">{{$stream->url}}</a></li>
                                    <li>
                                        <p></p>
                                    </li>
                                </ul>
                            </div>

                            <div class="m_btm_right_icons">
                                <ul>
                                    <li>
                                        <a title="Edit" data-id="{{$stream->id}}" class="m_btn_right_icon_each m_btm_edit active">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{$stream->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="edit_elem_bottom">
                            @include('parts.user-stream-edit-template', ['stream' => $stream])
                        </div>
                    </div>
                    @endforeach
                    @else
                        <br><br><br>
                        <div class="no_results">You have not added any premium videos yet</div>
                    @endif
                </div>
            @endif
        </div>
        <div id="subscribers_section" class="sub_cat_data pro_my_profil_sec {{$subTab == 'subscribers' ? '' : 'instant_hide'}}">
            @if($user->internalSubscription)
            <div class="pro_main_tray">
                <div class="pro_tray_title">Get Subscribers & Donators</div>
            </div>
            @if(Session::has('seller_stripe_prompt'))
                @include('parts.pro-stripeless-content', ['page' => 'add subscription box'])
            @endif
            <form id="save_subscribers_form" action="{{ route('save.user.subscribers') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="">
                    <div class="proj_acco_sub subscribers_accodion">
                        <div class="proj_subscriber_sec clearfix">
                            <div class="pro_note">
                                <ul>
                                    <li>Encourage fans to subscribe a monthly contribution towards your projects</li>
                                    <li>Before you change your subscription price please note that all current subscriptions will continue on the previous price. Only new subscribers will pay the new price</li>
                                </ul>
                            </div>
                            <div class="prog_sub_inps_sec cant_edit_fields">
                                @php $encourageBullets = Auth::user()->encourage_bullets; @endphp
                                <ul>
                                    <li><div class="mb-1">Bullet Text One</div><label class="proj_insp_wid"><input value="{{ is_array($encourageBullets) && $encourageBullets[0] != '' ? $encourageBullets[0] : '' }}" name="encourage_bullets[]" type="text" placeholder="" /></label></li>
                                    <li><div class="mb-1">Bullet Text Two</div><label class="proj_insp_wid"><input value="{{ is_array($encourageBullets) && $encourageBullets[1] != '' ? $encourageBullets[1] : '' }}" name="encourage_bullets[]" type="text" placeholder="" /></label></li>
                                    <li><div class="mb-1">Bullet Text Three</div><label class="proj_insp_wid"><input value="{{ is_array($encourageBullets) && $encourageBullets[2] != '' ? $encourageBullets[2] : '' }}" name="encourage_bullets[]" type="text" placeholder="" /></label></li>
                                    <li>
                                        <label class="proj_insp_wid input_with_currency_drop">
                                            <div class="mb-1">Subscription Amount</div>
                                            <div class="flex items-center border border-[#808081] gap-2 pl-2">
                                                <div class="text-[#666]">&pound;</div>
                                                <input value="{{ Auth::user()->subscription_amount }}" class="tot_usd_val drop_substi_val !border-0" type="text" placeholder="0.00" name="subscription_amount" />
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">Contributions Box. This feature appears on your website, ideal for fans who want to contribute towards your career projects</div>
                    <div class="border border-[#666] p-2 w-fit mb-2">
                        <div class="panel donator_profile_version donation_goalless colio_outer colio_dark">
                            <div class="donator_outer">
                                <div class="donator_box clearfix">
                                    <div class="colio_header">Make A Contribution</div>
                                    <p>Contributions are not associated with perks</p>
                                    <div class="donator_inner">
                                        <div class="donation_left">
                                            <span id="donation_currency">
                                                {{$commonMethods->getCurrencySymbol(strtoupper(Auth::user()->profile->default_currency))}}
                                            </span>
                                            <input readonly type="text" id="donation_amount" name="donation_amount" />
                                        </div>
                                        <div class="donation_right">
                                            <div class="donation_right_in">Add To Cart</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label class="add_donator_notice">
                        <input {{ (Auth::user()->accept_donations == 1) ? 'checked' : '' }} type="checkbox" name="accept_donations" value="1" id="accept_donations">
                        I want to add the above contribution box to my home page<p>(Patron Hub is not associated with a crowdfund project.)</p>
                    </label>
                    <br><br>
                    <div class="pay_btm_btn_outer clearfix">
                        <ul>
                            <li><a id="save_subscribers" href="javascript:void(0)">Save</a></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </form>
            @endif
        </div>
        <div id="song_links_section" class="sub_cat_data {{$subTab == 'song-links' ? '' : 'instant_hide'}}">
            @if($user->internalSubscription)
            <div class="pro_music_search pro_music_info">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Links to your Music from all major platforms</div>
                </div>
                <div class="pro_note">
                    <ul>
                        <li>On demand smart links for your home page music tab</li>
                        <li>Targets all major platforms so you can share better</li>
                        <li>Works automatically for any song uploaded to the major platforms</li>
                    </ul>
                </div>
                <div id="search_social_music_directory">
                    <input onpaste="searchHere(this)" type="text" placeholder="Type or paste here">
                    <i id="search_busy" class="fa fa-spinner fa-spin instant_hide"></i>
                    <div id="cancel_search_social_music">Cancel</div>
                </div>
                <div class="pro_music_search_results instant_hide"></div>

                <h2>Your music links preview</h2>
                <div class="smart_links_frame_contain">
                    @if($user->music_smart_links_url && $user->music_smart_links_url != '')
                    <iframe style="margin-top: 20px;" id="smart_links_frame" width="100%" height="52" src="{{$user->music_smart_links_url}}&theme=light" frameborder="0" allowfullscreen sandbox="allow-same-origin allow-scripts allow-presentation allow-popups allow-popups-to-escape-sandbox"></iframe>
                    @endif
                </div>
                <div class="{{$user->music_smart_links_url && $user->music_smart_links_url != '' ? '' : 'instant_hide'}}" id="remove_smart_links">Remove Links</div>
            </div>
            @if($user->music_smart_links_url == null || $user->music_smart_links_url == '')
            <div class="no_results">Nothing to preview</div>
            @endif
            @endif
        </div>
        <div id="edit_music_section" class="sub_cat_data {{$subTab == 'edit-music' ? '' : 'instant_hide'}}">
        	<div class="music_btm_listing_outer_edit">
        	    <div class="pro_main_tray">
                    <div class="pro_tray_title">Edit Music & Licenses</div>
                </div>
                <div class="pro_note">
                    <ul>
                        <li>Promote your music by clicking the star icon next to it</li>
                        <li>You can change the order of your musics for your website</li>
                        <li>Make your music private by clicking the lock icon next to it and assign an unlock PIN to it</li>
                        <li>Private music cannot be played or purchased without its PIN</li>
                    </ul>
                </div>
                @if(count($user->musics))
                    @foreach($user->musics as $userMusic)
                        @if($userMusic->thumbnail_left != '')
                            @php $music_thumb = asset('user-music-thumbnails/' . $userMusic->thumbnail_left) @endphp
                        @else
                            @php $music_thumb = asset('img/url-thumb-profile.jpg') @endphp
                        @endif
                        <div data-sort="music_{{ $userMusic->id }}" class="music_btm_list elem_sortable">
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
                                    <img src="{{ $music_thumb }}" alt="#" />
                                    <ul class="music_btm_img_det">
                                        <li><a href="javascript:void(0)">{{ $userMusic->song_name }}</a></li>
                                        <li>
                                            <p>{{ $userMusic->album_name }}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="m_btm_right_icons">
                                    <ul>
                                        <li>
                                            <a title="Edit" data-id="{{ $userMusic->id }}" class="m_btn_right_icon_each m_btm_edit active">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{ $userMusic->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Feature" class="m_btn_right_icon_each m_btm_star {{ ( $userMusic->featured == '1' ) ? 'active' : '' }}" data-music-id="{{ $userMusic->id }}" >
                                                <i class="fa fa-star"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Manage Privacy" class="m_btn_right_icon_each m_btm_private {{count($userMusic->privacy) && isset($userMusic->privacy['status']) && $userMusic->privacy['status'] == '1' ? 'active' : '' }}" data-music-id="{{ $userMusic->id }}" data-music-pin="{{count($userMusic->privacy) && isset($userMusic->privacy['pin'])? $userMusic->privacy['pin'] : '' }}">
                                                <i class="fa fa-key"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="edit_elem_bottom">
                                @include('parts.user-music-edit-template', ["userMusic" => $userMusic])
                            </div>
                        </div>
                    @endforeach
                @else
                    <br><br><br>
                    <div class="no_results">You have not added any music tracks yet</div>
                @endif
        	</div>
        </div>
        <div id="my_albums_section" class="sub_cat_data {{$subTab == 'albums' ? '' : 'instant_hide'}}">
            @if($user->internalSubscription)
            <div class="pro_music_info">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Manage Your Albums</div>
                    <div class="pro_tray_tabs">
                        <div class="pro_tray_sep"></div>
                        <div title="Add album" data-key="album_add" class="pro_tray_tab_each active">
                            <div class="pro_tray_tab_title"></div>
                            <div class="pro_tray_tab_icon">
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                        <div class="pro_tray_sep"></div>
                        <div data-key="album_list" title="Edit albums" class="pro_tray_tab_each">
                            <div class="pro_tray_tab_title"></div>
                            <div class="pro_tray_tab_icon">
                                <i class="fa fa-edit"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has('seller_stripe_prompt'))
                    @include('parts.pro-stripeless-content', ['page' => 'add albums'])
                @endif
                <div class="pro_note">
                    <ul>
                        <li>Promote your album by clicking the star icon next to it</li>
                        <li>Add your album as a product which means the album will also showup in your store tab</li>
                        <li>You can optionally choose to show an album in your store tab to increase its visibility</li>
                    </ul>
                </div>
            </div>
            <div data-value="album_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
           		<form id="add_album_form" action="{{route('user.album.save')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="pro_music_info">
                        <div class="pro_upload_video music_thum_sec clearfix">
                            <div class="pro_left_video_img">
                                <span class="upload_vieo_img">
                                    <img src="/images/p_music_thum_img.png?v=1.2" alt="#" id="display-album-thumb" class="display-album-thumb" />
                                </span>
                                <a class="display-album-thumb">Add Thumbnail*</a>
                                <input accept="image/*" type="file" style="display: none;" name="album_thumb" class="album_thumb" />
                            </div>
                            <div class="pro_right_video_det">
                                <p>Upload album thumbnail. It is mandatory</p>
                            </div>
                        </div>
                    </div>
                    <div class="pro_stream_input_outer">
                        <div class="pro_stream_input_each">
                            <input placeholder="Name*" type="text" class="pro_stream_input" name="pro_album_name" />
                        </div>
                        <div class="pro_stream_input_each">
                            <input placeholder="Price*" type="number" class="pro_stream_input" name="pro_album_price" />
                        </div>
                        <div class="pro_stream_input_each">
                            <div class="stream_sec_opt_outer">
                                <select name="pro_album_product">
                                    <option value="">Do you want to show this album in your store tab?</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        @if(count($user->musics))
                        <div class="pro_stream_input_each">
                            <div class="stream_sec_opt_outer">
                                <div class="stream_sec_opt_checks">
                                    <div class="stream_sec_opt_label">
                                        Select multiple songs to add to this album
                                    </div>
                                    @foreach($user->musics as $music)
                                    <div class="stream_sec_opt_check_each">
                                        <input id="album_m_{{$music->id}}" class="pro_check_multiple" value="{{$music->id}}" type="checkbox" name="pro_album_musics[]" />
                                        <label for="album_m_{{$music->id}}"> {{$music->song_name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="pro_stream_input_each">
                            <textarea placeholder="Description" type="text" class="pro_news_textarea" name="pro_album_description"></textarea>
                        </div>
                        <div class="save_album_outer edit_profile_btn_1 clearfix">
                            <a href="javascript:void(0)">Submit</a>
                        </div>
                    </div>
                </form>
            </div>
            <div data-value="album_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">
                @if(count($user->albums) > 0)
                    @foreach($user->albums as $album)
                        <div data-form="my-album-form_{{ $album->id }}" class="music_btm_list no_sorting clearfix">
                            <div class="edit_elem_top">
                                <div class="m_btm_list_left">
                                    @php
                                        $albumThumb = asset('images/p_music_thum_img.png?v=1.2');
                                        if($album->thumbnail != null && $album->thumbnail != ''){
                                            $albumThumb = asset('user-album-thumbnails/'.$album->thumbnail);
                                        }
                                    @endphp
                                    <img src="{{$albumThumb}}" alt="#">
                                    <ul class="music_btm_img_det">
                                        <li>
                                            <label>{{$album->name}}</label>
                                            <div class="clearfix">
                                                <p>
                                                    {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{$album->price}}
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="m_btm_right_icons">
                                    <ul>
                                        <li>
                                            <a title="Edit" data-id="{{$album->id}}" class="m_btn_right_icon_each m_btm_edit active">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{$album->id}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Feature" class="m_btn_right_icon_each m_btm_star {{($album->featured == '1') ? 'active' : '' }}" data-album-id="{{ $album->id }}" >
                                                <i class="fa fa-star"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="edit_elem_bottom">
                                @include('parts.user-album-edit-template', ['album' => $album])
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @endif
        </div>
        <div id="news_section" class="sub_cat_data {{$subTab == 'news' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage News</div>
                <div class="pro_tray_tabs">
                    <div class="pro_tray_sep"></div>
                    <div title="Add news" data-key="news_add" class="pro_tray_tab_each active">
                        <div class="pro_tray_tab_title"></div>
                        <div class="pro_tray_tab_icon">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                    <div class="pro_tray_sep"></div>
                    <div data-key="news_list" title="Edit news" class="pro_tray_tab_each">
                        <div class="pro_tray_tab_title"></div>
                        <div class="pro_tray_tab_icon">
                            <i class="fa fa-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pro_note">
                <ul>
                    <li>Manage your news feed</li>
                    <li>Let your fans know what you are upto</li>
                    <li>Write what you are planning ahead</li>
                </ul>
            </div>
            @if($user->internalSubscription)
            <div data-value="news_add" class="music_btm_listing_outer_edit pro_tray_tab_content">
                <form id="news_form" action="{{isset($setupWizard) ? '': route('save.user.profile_news')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="pro_music_info">
                        <div class="pro_stream_input_outer">
                            <div class="pro_stream_input_each">
                                <textarea placeholder="Write here" type="text" class="pro_news_textarea" name="value"></textarea>
                            </div>
                            <div class="pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select name="pro_stream_tab">
                                        <option value="">Choose tab</option>
                                        <option value="1">Bio</option>
                                        <option value="2">Music</option>
                                        <option value="3">Fans</option>
                                        <option value="4">Social</option>
                                        <option value="6">Product</option>
                                        <option value="5">Video</option>
                                        <option value="7">Gigs & Tickets</option>
                                    </select>
                                </div>
                            </div>
                            <div class="save_news_outer edit_profile_btn_1 clearfix">
                                <a href="javascript:void(0)">Submit</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div data-value="news_list" class="music_btm_listing_outer_edit pro_tray_tab_content instant_hide">
                <div class="music_btm_listing_outer_edit">
                    @if(count($user->news))
                    @foreach($user->news as $userNews)
                        <div class="music_btm_list">
                            <div class="edit_elem_top">
                                <div class="m_btm_list_left">
                                    <ul class="music_btm_img_det">
                                        <li>
                                            <a href="javascript:void(0)">
                                                {{ date('d/m/Y h:i A', strtotime($userNews->created_at)).' - '.$userNews->value }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="m_btm_right_icons">
                                    <ul>
                                        <li>
                                            <a title="Edit" data-id="{{ $userNews->id }}" class="m_btn_right_icon_each m_btm_edit active">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{ $userNews->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Feature" class="m_btn_right_icon_each m_btm_star {{ ( $userNews->featured == '1' ) ? 'active' : '' }}" data-news-id="{{ $userNews->id }}" >
                                                <i class="fa fa-star"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="edit_elem_bottom">
                                @include('parts.user-news-edit-template', ["userNews" => $userNews])
                            </div>
                        </div>
                    @endforeach
                    @else
                    <br><br><br>
                    <div class="no_results">You have not added anything in your news area yet</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('js/jquery.overflowing.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/jquery.draggableTouch.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/bpm_finder.js?v=1.1')}}"></script>
<script type="text/javascript" src="{{asset('js/profile.media.js?v=1.7')}}"></script>
<link rel="stylesheet" href="{{asset('css/profile.media.css?v=1.7')}}">
