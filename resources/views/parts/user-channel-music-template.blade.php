@php $playerThumb = $music->thumbnail_player == '' ? 'url-thumb-profile.jpg' : $music->thumbnail_player @endphp
@php $domain = parse_url(request()->root())['host'] @endphp
@php $comm = new \App\Http\Controllers\CommonMethods() @endphp
<div class="tab_chanel_list clearfix each-music" data-thumbnail-player="{{ $playerThumb }}" data-musicid="{{ $music->id }}" data-userid="{{base64_encode($music->user->id)}}" data-musicfile="{{ $music->music_file && $music->music_file != '' && $comm->fileExists(public_path('user-music-files/'.$music->music_file)) && filesize(public_path('user-music-files/'.$music->music_file)) > 0 ? $music->music_file : '' }}">
    @php $musicThumb = $music->thumbnail_left == '' ? asset('img/url-thumb-profile.jpg') : asset('user-music-thumbnails/'.$music->thumbnail_left) @endphp
    @php $style = $music->genre ? $music->genre->name : 'None' @endphp
    @php $mood = $music->dropdown_two != '' ? $music->dropdown_two : 'None' @endphp
    @php $defaultCurrSym = $comm->getCurrencySymbol(strtoupper($music->user->profile->default_currency)); @endphp

        <div class="summary">
            <a class="main_an" href="javascript:void(0)">
                <img class="play_now vertical_center instant_hide " src="{{ asset('images/play_icon.png') }}">
                <i class="fa fa-spin fa-spinner vertical_center instant_hide loading_smg"></i>
                <img class="main_img" src="{{ $musicThumb }}" alt="#" />
            </a>
            <div class="tab_chanel_img_det">
                <div class="upper_music_det">
                    <a class="thismusic_user_name" href="{{$music->user && $music->user->username ? route('user.home.tab',['params'=>$music->user->username, 'tab' => '2']) : 'javascript:void(0)'}}">{{ $music->user->name }}</a>
                    <p class="thismusic_song_name" >{{ $music->song_name }}</p>
                    <div class="vertical_center fav_np @if (Auth::check()) {{ is_array(Auth::user()->favourite_musics) && in_array($music->id, Auth::user()->favourite_musics) ? 'active' : '' }} @endif fa fa-heart"></div>
                    <div data-title="{{$music->song_name}}" data-opd="item" data-item="{{base64_encode($music->id)}}" data-type="track" data-slug="{{str_slug($music->song_name)}}" class="vertical_center item_share fa fa-share-alt"></div>
                </div>
                <div class="thismusic_wave_img">
                    @if($music->waveform_image && $music->waveform_image != '' && $comm->fileExists(public_path('user-music-waveform/'.$music->waveform_image)))
                    <img src="{{asset('user-music-waveform/'.$music->waveform_image)}}">
                    @endif
                </div>
                <div class="lower_music_det">
                    <div class="each_lower_det">{{$style}}</div>
                    <div class="each_lower_det">{{$mood}}</div>
                    <div class="each_lower_det">{{$music->bpm}}</div>
                    <div class="each_lower_det">{{$music->formatDuration()}}</div>
                    <div class="each_lower_det">
                        <div class="personal_lic">
                        	@if($music->personal_use_only != '')
	                            @if($music->personal_use_only > 0)
	                            	{{$defaultCurrSym.$music->personal_use_only}}
	                            @else
	                            	Free 
	                            @endif
	                            <i class="fa fa-shopping-cart"></i>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="res_right hide_on_desktop">
                    <div class="res_right_each_text">{{$style}}</div>
                    <div class="res_right_each_text">{{$mood}}</div>
                    <div class="res_right_each_text">{{$music->bpm}}</div>
                    <div class="res_right_each_text">{{$music->formatDuration()}}</div>
                </div>
                <div class="res_left hide_on_desktop">
                	<div class="res_left_each res_left_artist">
                		By <a href="{{$music->user && $music->user->username ? route('user.home', ['params' => $music->user->username]) : 'javascript:void(0)'}}">{{strtoupper($music->user->name)}}</a>
                	</div>
                	@if($music->personal_use_only != '')
                    <div class="res_left_each res_left_shop">
                    	<div class="res_left_icon"><i class="fa fa-shopping-cart"></i></div>
                    	<div class="res_left_text">
                    	    @if($music->personal_use_only > 0)
                    	    {{$comm->getCurrencySymbol(strtoupper($music->user->profile->default_currency)).$music->personal_use_only}}
                    	    @else
                    	    Free 
                    	    @endif
                    	</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="ch_video_detail_outer add_to_cart_item clearfix" style="display: none;">
            <div class="clearfix">
                <div class="music_det clearfix">
                    <div class="headline">Instruments</div>
                    <div class="detail">
                        <div class="instruments_detail">
                            {{implode(' - ', $music->instruments)}}
                        </div>
                    </div>
                </div>
                @if($music->lyrics)
                <div class="music_det clearfix">
                    <div class="headline">Lyrics</div>
                    <div class="detail">
                        <div class="lyrics_detail">
                            {!! nl2br($music->lyrics) !!}
                        </div>
                        <div class="lyrics_more instant_hide">Read More</div>
                    </div>
                </div>
                @endif
                @php $musicStems = $musicLoops = [] @endphp
                @if(count($music->downloads))
                    @foreach($music->downloads as $key => $item)
                        @if($item['itemtype'] == 'loop_one') @php $hasloop = 1; $loopOne = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'loop_two') @php $hasloop = 1; $loopTwo = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'loop_three') @php $hasloop = 1; $loopThree = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_one') @php $hasstem = 1; $stemOne = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_two') @php $hasstem = 1; $stemTwo = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_three') @php $hasstem = 1; $stemThree = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_four') @php $hasstem = 1; $stemFour = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_five') @php $hasstem = 1; $stemFive = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_six') @php $hasstem = 1; $stemSix = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_seven') @php $hasstem = 1; $stemSeven = $item['dec_fname'] @endphp @endif
                        @if($item['itemtype'] == 'stem_eight') @php $hasstem = 1; $stemEight = $item['dec_fname'] @endphp @endif
                    @endforeach
                @endif
                <div class="music_det clearfix">
                    @if(isset($hasloop) && $hasloop == 1)
                    <div class="loop_outer">
                        <div class="loop_inner">
                            <div class="loop_head headline">Loops</div>
                            @if(isset($loopOne))
                            <div data-musicfile="{{ $loopOne }}" class="each_loop circle">1</div>
                            @endif
                            @if(isset($loopTwo))
                            <div data-musicfile="{{ $loopTwo }}" class="each_loop circle">2</div>
                            @endif
                            @if(isset($loopThree))
                            <div data-musicfile="{{ $loopThree }}" class="each_loop circle">3</div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if(isset($hasstem) && $hasstem == 1)
                    <div class="stem_outer">
                        <div class="stem_inner">
                            <div class="stem_head headline">Stems</div>
                            @if(isset($stemOne))
                            <div data-musicfile="{{ $stemOne }}" class="each_stem circle">1</div>
                            @endif
                            @if(isset($stemTwo))
                            <div data-musicfile="{{ $stemTwo }}" class="each_stem circle">2</div>
                            @endif
                            @if(isset($stemThree))
                            <div data-musicfile="{{ $stemThree }}" class="each_stem circle">3</div>
                            @endif
                            @if(isset($stemFour))
                            <div data-musicfile="{{ $stemFour }}" class="each_stem circle">4</div>
                            @endif
                            @if(isset($stemFive))
                            <div data-musicfile="{{ $stemFive }}" class="each_stem circle">5</div>
                            @endif
                            @if(isset($stemSix))
                            <div data-musicfile="{{ $stemSix }}" class="each_stem circle">6</div>
                            @endif
                            @if(isset($stemSeven))
                            <div data-musicfile="{{ $stemSeven }}" class="each_stem circle">7</div>
                            @endif
                            @if(isset($stemEight))
                            <div data-musicfile="{{ $stemEight }}" class="each_stem circle">8</div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if(!isset($hasloop) && !isset($hasstem))
                        <div class="no_stem_loop">No stems / loops are available for this track</div>
                    @endif
                </div>
                <div class="ch_video_detail_right_sec">
                    <div class="ch_select_options {{$music->allow_bespoke_license_offer && $music->user->chat_switch == 1 ? 'allow_offer' : ''}}">
                        @foreach(config('constants.licenses') as $key => $license)
                            @if($music->{$license['input_name']}) 
                                @php $hasLicensePrice = 1 @endphp 
                            @endif
                        @endforeach

                        <div class="ch_select_perch_options">
                            <text class="license_name">
                            	<div class="license_text">Select Purchase Option</div>
                            	<div class="license_icons"><i class="fa fa-shopping-cart"></i></div>
                            </text>
                            <div class="license_container instant_hide">
                                @php $personalLicK = 'Personal Use Only'.'::'.$defaultCurrSym.$music->personal_use_only @endphp
                                @php $personalLicV = 'Personal Use Only'.' ('.$defaultCurrSym.$music->personal_use_only.')' @endphp
                                @if($music->personal_use_only !== NULL)
                                <div class="choose_music_license_contain" data-price="{{$personalLicK}}" value="{{$personalLicV}}">
                                    <div class="choose_music_license_each">
                                        <div class="choose_music_license_input">
                                            <input type="radio" name="choose_music_license" />
                                        </div>
                                        <label class="choose_music_license_name">
                                            Personal Use Only
                                        </label>
                                        <label class="choose_music_license_price">
                                            {{$defaultCurrSym.$music->personal_use_only}}
                                        </label>
                                    </div>
                                    <div class="choose_music_license_terms_contain">
                                        <div class="choose_music_license_terms_handle">
                                            <i class="fa fa-angle-down"></i> 
                                            <span>show terms</span>
                                        </div>
                                        <div class="choose_music_license_terms_each">
                                            <div class="choose_music_license_topen">
                                                <div class="choose_music_license_topen_text">
                                                    For your personal use only
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($music->user->has_music_license)
                                @foreach(config('constants.licenses') as $key => $license)
                                    @if($music->{$license['input_name']})
                                    @php 
                                        $licKey = $music->{$license['input_name']} != 'POA' ? $license['filename'].'::'.$defaultCurrSym.$music->{$license['input_name']} : 'POA';
                                        $licValue = $license['filename'];
                                        $licValue .= $music->{$license['input_name']} != 'POA' ? ' ('.$defaultCurrSym.$music->{$license['input_name']}.')' : ' (POA)';
                                    @endphp 
                                    <div class="choose_music_license_contain" data-price="{{$licKey}}" value="{{$licValue}}">
                                        <div class="choose_music_license_each">
                                            <div class="choose_music_license_input">
                                                <input type="radio" name="choose_music_license" value="{{$licValue}}" />
                                            </div>
                                            <label class="choose_music_license_name">
                                                {{$license['name']}}
                                            </label>
                                            <label class="choose_music_license_price">
                                                {{$music->{$license['input_name']} != 'POA' ? $defaultCurrSym.$music->{$license['input_name']} : ' POA'}}
                                            </label>
                                        </div>
                                        @if($music->{$license['input_name']} != 'POA')
                                        <div class="choose_music_license_terms_contain">
                                            <div class="choose_music_license_terms_handle">
                                                <i class="fa fa-angle-down"></i> 
                                                <span>show terms</span>
                                            </div>
                                            <div class="choose_music_license_terms_each">
                                                @php $licenseTermRec = \App\Models\LicenseTerms::find($license['terms_id']) @endphp
                                                @if($licenseTermRec && count($licenseTermRec->terms))
                                                    @foreach($licenseTermRec->terms as $value)
                                                        <div class="choose_music_license_topen">
                                                            <div class="choose_music_license_topen_text">
                                                                {{$value}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @if($music->allow_bespoke_license_offer && $music->user->chat_switch == 1)
                        <div class="make_offer_outer">Negotiate</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</div>