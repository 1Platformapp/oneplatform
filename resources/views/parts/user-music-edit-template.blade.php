@php $comm = new \App\Http\Controllers\CommonMethods() @endphp
<form data-add="0" class="music_edit_form" data-id="my-music-form_{{ $userMusic->id }}" action="{{ route('save.user.profile_musics') }}" method="post" enctype="multipart/form-data" style="display: none;">

    <input type="hidden" name="music_id" value="{{ $userMusic->id }}">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <input type="hidden" name="duration" class="music_file_duration" value="{{$userMusic->duration}}" />

    <div class="pro_music_info">
        <label>
            Edit Music Information
            <i class="fa fa-times edit_elem_close"></i>
        </label>

        @php 
            $downloads = [];
            if($userMusic->downloads && is_array($userMusic->downloads) && count($userMusic->downloads)) {
                $downloads = [array_filter(unserialize($userMusic->downloads))];
            } else {
                $downloads = [];
            }
        @endphp
        
        @if($downloads)
            @foreach($downloads as $key => $item)
                @if($item['itemtype'] == 'loop_one') @php $loopOne = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'loop_two') @php $loopTwo = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'loop_three') @php $loopThree = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_one') @php $stemOne = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_two') @php $stemTwo = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_three') @php $stemThree = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_four') @php $stemFour = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_five') @php $stemFive = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_six') @php $stemSix = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_seven') @php $stemSeven = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'stem_eight') @php $stemEight = $userMusic->getDownloadName($item) @endphp @endif
                @if($item['itemtype'] == 'main') @php $mainFile = $userMusic->getDownloadName($item) @endphp @endif
            @endforeach
        @else
            @php $mainFile = $userMusic->music_file @endphp 
        @endif

        @php $edit_music_thumb = asset('img/url-thumb-profile.jpg') @endphp
        @if($userMusic->thumbnail_left != '')
            @php $edit_music_thumb = asset('user-music-thumbnails/'.$userMusic->thumbnail_left) @endphp
        @endif

        <div class="clearfix pro_upload_video music_thum_sec">
            <div class="pro_left_video_img">
                <span class="upload_vieo_img" onclick="$('#music_thumb_{{ $userMusic->id }}').trigger('click'); return false;">
                    <img src="{{$edit_music_thumb}}" style="cursor: pointer;" alt="#" id="display-music-thumb_{{ $userMusic->id }}" />
                </span>
                <a href="#" onclick="$('#music_thumb_{{ $userMusic->id }}').trigger('click'); return false;">
                    Add Artwork
                </a>
                <input type="file" style="display: none;" name="music_thumb" id="music_thumb_{{ $userMusic->id }}" class="music_thumb" data-musicid="{{ $userMusic->id }}">
            </div>
            <div class="pro_left_video_img pro_file_uploader">
                <span class="upload_vieo_img">
                    @if($userMusic->music_file && $userMusic->music_file != '' && $comm->fileExists(public_path('user-music-files/'.$music->music_file)))
                    <img class="music_file_label" style="cursor: pointer;" src="/images/p_music_filled.png" />
                    @else
                    <img class="music_file_button" style="cursor: pointer;" src="/images/p_music_thum_img.png?v=1.2" />
                    @endif
                </span>
                <a class="p_music_filename" href="javascript:void(0)">{{ $mainFile }}</a>
            </div>
            <div class="pro_right_video_det"></div>

        </div>

    </div>

    <div class="music_sec_acourdiun_outer">

        <div class="music_sec_imput_outer">
            <input accept=".mp3,.wav" type="file" name="music-file" class="music-file" style="display: none;" />
            <ul>
                <li>
                    <div class="lab_title">Name</div>
                    <label><input type="text" placeholder="Name of the song" id="song_name_{{ $userMusic->id }}" name="song_name" value="{{ $userMusic->song_name }}" /></label></li>
                <li style="display: none"><label><input type="text" placeholder="Name of the album" id="album_name_{{ $userMusic->id }}" name="album_name" value="{{ $userMusic->album_name }}" /></label></li>
                <li>
                    <div class="lab_title">BPM</div>
                    <label><input value="{{$userMusic->bpm}}" type="text" placeholder="BPM" name="bpm" /></label>
                </li>
                <li class="pro_music_instruments_outer">
                    <label class="pro_input_icon">
                        <input autocomplete="off" type="text" placeholder="Search here to add instruments" name="instruments" />
                        <i class="fa fa-search"></i>
                    </label>
                    <div class="clearfix music_instruments_results pro_custom_drop_res instant_hide">
                        <div class="pro_instruments_list_drop">
                            <ul></ul>
                        </div>
                    </div>
                    <div class="clearfix music_instruments_saved">
                        @if(is_array($userMusic->instruments) && count(array_filter($userMusic->instruments)))
                            @foreach($userMusic->instruments as $musicInstrument)
                                <div class="profile_custom_drop_each">
                                    <div class="profile_custom_drop_title">{{$musicInstrument}}</div>
                                    <div class="profile_custom_drop_icon">
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </li>
                <li>
                    <div class="lab_title">Genre</div>
                    <div class="music_sec_opt_outer">

                        <?php $genreSelected = 0;?>
                        @foreach($genres as $genre)
                        @if($userMusic->dropdown_one == $genre->id)
                            <?php $genreSelected = 1;?>
                            <span>{{ $genre->name }}</span>
                        @endif
                        @endforeach

                        @if($genreSelected == 0)
                                <span>Genre</span>
                        @endif

                        <select id="dropdown_one_{{ $userMusic->id }}" name="dropdown_one">

                            <option value="">Genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" <?php if($userMusic->dropdown_one == $genre->id ){?>selected<?php }?>>{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                @php $moods = \App\Models\Mood::orderBy('id', 'asc')->get() @endphp
                <li>
                    <div class="lab_title">Mood</div>
                    <div class="music_sec_opt_outer">
                        <span>{{ $userMusic->dropdown_two != "" ? $userMusic->dropdown_two : "Mood" }}</span>
                        <select id="dropdown_two_{{ $userMusic->id }}" name="dropdown_two">
                            <option value="" <?php if($userMusic->dropdown_two == "" ){?>selected<?php }?>>Mood</option>
                            
                            @foreach($moods as $mood)
                                <option value="{{$mood->name}}" <?php if($userMusic->dropdown_two == $mood->name ){?>selected<?php }?>>{{$mood->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li class="pro_music_moods_outer">
                    <label class="pro_input_icon">
                        <input autocomplete="off" type="text" placeholder="Search here to add more moods" name="more_moods" />
                        <i class="fa fa-search"></i>
                    </label>
                    <div class="clearfix music_moods_results pro_custom_drop_res instant_hide">
                        <div class="pro_moods_list_drop">
                            <ul></ul>
                        </div>
                    </div>
                    <div class="clearfix music_moods_saved">
                        @php $userMusicMoods = explode(',', $userMusic->more_moods) @endphp
                        @if(is_array($userMusicMoods) && count(array_filter($userMusicMoods)))
                            @foreach(array_filter($userMusicMoods) as $musicMood)
                                <div class="profile_custom_drop_each">
                                    <div class="profile_custom_drop_title">{{$musicMood}}</div>
                                    <div class="profile_custom_drop_icon">
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </li>
            </ul>

        </div>

        <div class="music_sec_imput_outer lyrics_outer">
            <ul>
                <li>
                    <textarea name="lyrics" placeholder="Add Information / Lyrics / About / Etc">{{$userMusic->lyrics}}</textarea>
                </li>
            </ul>
        </div>

    </div>

    <div class="pro_m_license_pric_sec not_last_child">
        <div class="music_license_button">
            <div class="music_license_head">Non License Fee</div>
        </div>
        <span class="pb-0">This feature allows users to purchase for personal use only.</span>
        <div class="pro_note">
            <ul>
                <li>
                    If you enter 0, the item will be available for free.
                </li>
            </ul>
            <ul>
                <li>
                    If you leave the field empty, personal use option will not be displayed.
                </li>
            </ul>
        </div>
        <div class="music_ice_listing">
            <ul>
                <li class="clearfix each_license optional">
                    <div class="each_license_body">
                        <p class="p_lic_left">Personal use only</p>
                        <input type="number" class="p_lic_right" placeholder="(0.99)" name="personal_use_only" value="{{ $userMusic->personal_use_only }}" min="0" />
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
                                <div data-type="loop_one" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($loopOne)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($loopOne)?'instant_hide':''}}">Add Loop</div>
                                        <div class="mu_down_file_name {{isset($loopOne)?'':'instant_hide'}}">
                                            {{isset($loopOne)?$loopOne:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div data-type="loop_two" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($loopTwo)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($loopTwo)?'instant_hide':''}}">Add Loop</div>
                                        <div class="mu_down_file_name {{isset($loopTwo)?'':'instant_hide'}}">
                                            {{isset($loopTwo)?$loopTwo:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <div data-type="loop_three" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($loopThree)?'mu_filled':''}}">
                                <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                <div class="mu_down_file_button">
                                    <div class="mu_down_btn_text {{isset($loopThree)?'instant_hide':''}}">Add Loop</div>
                                    <div class="mu_down_file_name {{isset($loopThree)?'':'instant_hide'}}">
                                        {{isset($loopThree)?$loopThree:''}}
                                    </div>
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mu_down_main_sec">
                            <div class="mu_down_head">Add Stems</div>
                            <div class="each_row">
                                <div data-type="stem_one" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemOne)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemOne)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemOne)?'':'instant_hide'}}">
                                            {{isset($stemOne)?$stemOne:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div data-type="stem_two" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemTwo)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemTwo)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemTwo)?'':'instant_hide'}}">
                                            {{isset($stemTwo)?$stemTwo:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="each_row">
                                <div data-type="stem_three" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemThree)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemThree)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemThree)?'':'instant_hide'}}">
                                            {{isset($stemThree)?$stemThree:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div data-type="stem_four" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemFour)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemFour)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemFour)?'':'instant_hide'}}">
                                            {{isset($stemFour)?$stemFour:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="each_row">
                                <div data-type="stem_five" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemFive)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemFive)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemFive)?'':'instant_hide'}}">
                                            {{isset($stemFive)?$stemFive:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div data-type="stem_six" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemSix)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemSix)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemSix)?'':'instant_hide'}}">
                                            {{isset($stemSix)?$stemSix:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="each_row">
                                <div data-type="stem_seven" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemSeven)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemSeven)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemSeven)?'':'instant_hide'}}">
                                            {{isset($stemSeven)?$stemSeven:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div data-type="stem_eight" data-id="{{$userMusic->id}}" class="mu_down_each {{isset($stemEight)?'mu_filled':''}}">
                                    <input accept=".mp3,.wav" type="file" class="mu_down_file instant_hide" />
                                    <div class="mu_down_file_button">
                                        <div class="mu_down_btn_text {{isset($stemEight)?'instant_hide':''}}">Add Stem</div>
                                        <div class="mu_down_file_name {{isset($stemEight)?'':'instant_hide'}}">
                                            {{isset($stemEight)?$stemEight:''}}
                                        </div>
                                        <i class="fa fa-plus"></i>
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
                                            <input type="text" class="p_lic_right" placeholder="({{$license['price']}})" name="{{$license['input_name']}}" value="{{ $userMusic->{$license['input_name']} }}" />
                                        </div>
                                        <div class="each_license_terms">
                                            <div class="each_license_terms_handle">
                                                <i class="fa fa-angle-down"></i> 
                                            </div>
                                            <div class="each_license_terms_each"></div>
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
            <input type="hidden" name="is_full_ownership" value="1">
            <input type="hidden" name="use_of_licenses_perpetual" value="1">
            <input type="hidden" class="allow_bespoke_license_offer" name="allow_bespoke_license_offer" value="{{$userMusic->allow_bespoke_license_offer ? $userMusic->allow_bespoke_license_offer : 0}}">
            <li><span class="m_chech_active" id="full_ownership" data-musicid="{{ $userMusic->id }}">I agree that I have full ownership of my music</span></li>
            <li><span class="bespoke_license_offer {{$userMusic->allow_bespoke_license_offer ? 'm_chech_active' : ''}}">Allow bespoke license offers for this music</span></li>
            <li><span class="m_chech_active" id="licenses_perpetual"  data-musicid="{{ $userMusic->id }}">I agree to these <a href="#">Terms And Conditions.</a></span></li>
        </ul>
    </div>

    <div class="clearfix save_music_outer edit_profile_btn_1">
        <a href="javascript:void(0)">Upload</a>
    </div>
</form>