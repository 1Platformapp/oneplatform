 
@php $display = 'display: block;' @endphp

@if($page != 'tools')
    @php $display = 'display: none;' @endphp
@endif

<div id="profile_tab_04" class="pro_my_music_sec pro_pg_tb_det" style="{{ $display }}">

    <div id="industry_section" class="sub_cat_data {{$subTab == 'industry-contacts' ? '' : 'instant_hide'}}">
        <div class="pro_connect_outer">
        	@if($user->hasActivePaidSubscription()) 
            <div class="pro_main_tray">
                <div class="pro_tray_title">{{count(\App\Models\IndustryContact::all())}} Industry Contacts Found</div>
            </div>
            @elseif($user->hasActiveFreeSubscription())
            <div class="pro_main_tray">
                <div class="pro_tray_title">Upgrade to get access</div>
            </div>
            @else
            <div class="pro_main_tray">
                <div class="pro_tray_title">Subscribe to get access</div>
            </div>
            @endif

            <div class="pro_note">
                <ul>
                    <li>Contact festivals, venues, record labels , promoters, managers and more…</li>
                    <li>UK's biggest Industry list</li>
                    <li>Solutions to your network headaches, get contacts in your area for music studios, producers, pluggers, gig guides, record labels & more</li>
                    <li>Search by category or city/region</li>
                </ul>
            </div>

            @if($user->hasActivePaidSubscription()) 
        	<div class="ind_con_search_outer">
        		<div class="ind_con_search_by">
        			<select data-type="ind_cont_drop" id="ind_con_search_by_category">
                        <option value="">I'm Looking For:</option>
                        @foreach($icCategoryGroups as $icCategoryGroup)
        				<optgroup label="{{$icCategoryGroup->name}}">
                            @if(count($icCategoryGroup->categories))
                                @foreach($icCategoryGroup->categories as $icCategory)
                                <option value="{{$icCategory->lookup_id}}">{{$icCategory->name}}</option>           
                                @endforeach
                            @endif
                        </optgroup>
                        @endforeach
        			</select>
        		</div>
                <div class="ind_con_search_by">
                    <select data-type="ind_cont_drop" id="ind_con_search_by_city">
                        <option value="">In City / Region / Country:</option>
                        <optgroup label="ANYWHERE FROM">
                            <option value="alluk">UK</option>
                            <option value="allusa">USA</option>
                            <option value="allcanada">Canada</option>       
                        </optgroup>
                        @foreach($icRegions as $icRegion)
                        <optgroup label="{{$icRegion->name.' ('.$icRegion->country->abbreviation.')'}}">
                        @if(count($icRegion->cities))
                            @foreach($icRegion->cities as $icCity)
                            <option value="{{$icCity->city_id}}">{{$icCity->name}}</option>           
                            @endforeach
                        @endif        
                        </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="ind_con_search_submit">Search</div>
        	</div>
            <div class="ind_con_result_outer">
                {!! $industryContacts !!}
            </div>
        	@elseif($user->hasActiveFreeSubscription())
        		@include('parts.pro-stripeless-content', ['page' => 'industry_contacts', 'upgrade' => '1'])
        	@else
        		@include('parts.pro-stripeless-content', ['page' => 'industry_contacts'])
        	@endif
        </div>
    </div>

    <div class="pro_pg_tb_det_inner">
        
        <div id="streaming_section" class="sub_cat_data {{$subTab == '' || $subTab == 'streaming-distribution' ? '' : 'instant_hide'}}">
            <div class="pro_connect_outer">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Coming Soon to 1Platform</div>
                </div>
                <div class="pro_note">
                    <ul>
                        <li>Distribute your music to Spotify, Tidal, Itunes, Amazon, Google Play and more!</li>
                        <li>Enter your mainstream charts</li>
                        <li>You don't need a label or a record deal to distribute your music, Do it all on 1Platform!</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="marketing_section" class="sub_cat_data {{$subTab == 'marketing' ? '' : 'instant_hide'}}">
            <div class="pro_connect_outer">
                <div class="pro_main_tray">
                    <div class="pro_tray_title">Coming Soon to 1Platform</div>
                </div>
                <div class="pro_note">
                    <ul>
                        <li>Marketing support is a technology service that connects brands / Artists with content creators.</li>
                        <li>A Brand/ Artist looking to work with influencers will receive better support with your social platforms and connections with enhanced campaigns.Her you can use influencer marketing team to find the most appropriate influencers and work with them at scale with budgets to suit your needs</li>
                        <li>The result is driving broader awareness of you and a targeted growth of your fanbase</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{asset('css/profile.tools.css?v=1.4')}}">
<link rel="stylesheet" href="{{asset('select2/select2.min.css')}}"></link>
<script src="{{ asset('select2/select2.min.js') }}"></script>
<script type="text/javascript">
    
    $(document).ready(function(){

        $('select[data-type="ind_cont_drop"]').select2();
    });
</script>