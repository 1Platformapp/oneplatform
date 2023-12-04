
    <div class="hrd_usr_men_outer clearfix">
        <div class="usr_men_main_btn_outer">
            <div class="us_men_close">
                <svg data-bbox="25.9 25.9 148.2 148.2" xmlns="http://www.w3.org/2000/svg" viewBox="25.9 25.9 148.2 148.2" role="img">
                    <g>
                        <path d="M171.3 158.4L113 100l58.4-58.4c3.6-3.6 3.6-9.4 0-13s-9.4-3.6-13 0L100 87 41.6 28.7c-3.6-3.6-9.4-3.6-13 0s-3.6 9.4 0 13L87 100l-58.4 58.4c-3.6 3.6-3.6 9.4 0 13s9.4 3.6 13 0L100 113l58.4 58.4c3.6 3.6 9.4 3.6 13 0s3.5-9.5-.1-13z"></path>
                    </g>
                </svg>
            </div>
        </div>
        <div class="usr_men_items_outer">
            <div class="usr_men_items_inner">
                <div class="usr_men_cat_in">
                    @if(Auth::check())
                    @if(!Auth::user()->is_buyer_only)
                    <div class="usr_men_cat_each usr_men_recommend">
                        <div class="usr_men_cat_head">
                            Our recommendations
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each usr_men_setup_wizard">
                                    <img src="{{asset('images/setup_recommend.gif')}}">
                                    <div class="usr_men_quick_txt">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-cog"></i>
                                        </div>Profile Setup Wizard
                                    </div>
                                </div>
                                @if(!Auth::user()->expert && Auth::user()->apply_expert != 2 && !Auth::user()->agent)
                                <div class="usr_men_quick_each usr_men_setup_wizard">
                                    <img src="{{asset('images/hire_recommend.gif')}}">
                                    <div class="usr_men_quick_txt">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-handshake"></i>
                                        </div>Hire Professional Agent
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="usr_men_cat_each {{isset($page)&&$page=='edit'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Website
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'personal'])}}" class="usr_men_quick_txt">
                                        Add Personal Info
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'media'])}}" class="usr_men_quick_txt">
                                        Add Media Info
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-paint-brush"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'design'])}}" class="usr_men_quick_txt">
                                        Design & Layout
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-user-edit"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'bio'])}}" class="usr_men_quick_txt">
                                        Add Bio
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'portfolio'])}}" class="usr_men_quick_txt">
                                        My Portfolio
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'service'])}}" class="usr_men_quick_txt">
                                        My Services
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'domain'])}}" class="usr_men_quick_txt">
                                        Connect Domain
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'news'])}}" class="usr_men_quick_txt">
                                        News
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-connectdevelop"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'social'])}}" class="usr_men_quick_txt">
                                        Social Media
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-donate"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        My Subscribers
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Music
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-headphones"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'music'])}}" class="usr_men_quick_txt">
                                        Upload Music
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-edit"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'music'])}}" class="usr_men_quick_txt">
                                        Edit Music
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-compact-disc"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        My Albums
                                    </div>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fab fa-staylinked"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Song Links
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Videos
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-youtube"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'video'])}}" class="usr_men_quick_txt">
                                        YouTube Videos
                                    </a>
                                </div>

                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-video"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'video'])}}" class="usr_men_quick_txt">
                                        Premium Videos
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Products
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-store-alt"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'product'])}}" class="usr_men_quick_txt">
                                        Standard Products
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-paint-roller"></i>
                                    </div>
                                    <a href="{{route('profile.setup.standalone', ['page' => 'product'])}}" class="usr_men_quick_txt">
                                        Print on Demand
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='orders'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Finances
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                        Purchases
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-pound-sign"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                        Sales
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                        Summary
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='tools'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Artist Tools
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'industry-contacts'])}}" class="usr_men_quick_txt">
                                        Industry Contacts
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-outdent"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Distribution
                                    </div>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-search-location"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Marketing
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='crowdfunds'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Crowdfunding
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-donate"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        View
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='chat'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Networking
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'contact-management'])}}" class="usr_men_quick_txt">
                                        Chat
                                    </a>
                                </div>
                                <div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'my-questionnaires'])}}" class="usr_men_quick_txt">
                                        Agent Questionnaires
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each usr_men_seller_help mobile-only">
                    	Get help to build your profile
                    </div>
                    <div class="usr_men_cat_each usr_men_logout">
                        <a href="{{route('logout')}}" class="usr_men_cat_head">
                            <i class="fa fa-sign-out"></i>&nbsp;Logout
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.us_men_close svg').click(function(){

            $('body').removeClass('lock_page');
            $('.hrd_cart_outer,.tv_slide_out_outer,.hrd_usr_men_outer,.hrd_notif_outer').removeClass('active');
            $('#body-overlay').hide();
        });
    </script>
