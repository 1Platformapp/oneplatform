
    <div class="clearfix hrd_usr_men_outer">
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
                                <a href="{{route('agency.dashboard')}}" class="usr_men_quick_each usr_men_setup_wizard">
                                    <img src="{{asset('images/hire_recommend.gif')}}">
                                    <div class="usr_men_quick_txt">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-cog"></i>
                                        </div>My Dashboard
                                    </div>
                                </a>
                                <a href="{{route('profile.setup', ['page' => 'welcome'])}}" class="usr_men_quick_each usr_men_setup_wizard">
                                    <img src="{{asset('images/setup_recommend.gif')}}">
                                    <div class="usr_men_quick_txt">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-cog"></i>
                                        </div>Profile Setup Wizard
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="usr_men_cat_each {{isset($page)&&$page=='edit'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Personal
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('profile.setup.standalone', ['page' => 'personal'])}}" class="text-black usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        Add Personal Info
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'media'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-user-cog"></i>
                                        </div>
                                        Add Media Info
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='edit'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Website
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('profile.setup.standalone', ['page' => 'design'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-paint-brush"></i>
                                        </div>
                                        Design & Layout
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'bio'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-user-edit"></i>
                                        </div>
                                        Add Bio
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'portfolio'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        My Portfolio
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'service'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        My Services
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'domain'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        Connect Domain
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'news'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        News
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'social'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-connectdevelop"></i>
                                        </div>
                                        Social Media
                                    </div>
                                </a>
                                <!--<div class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-donate"></i>
                                    </div>
                                    <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                        My Subscribers
                                    </a>
                                </div>!-->
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Music
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('profile.setup.standalone', ['page' => 'music'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-headphones"></i>
                                        </div>
                                        Upload Music
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'music'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        Edit Music
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'album'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-compact-disc"></i>
                                        </div>
                                        My Albums
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'song-links'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fab fa-staylinked"></i>
                                        </div>
                                        Song Links
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Videos
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('profile.setup.standalone', ['page' => 'video'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-youtube"></i>
                                        </div>
                                        YouTube Videos
                                    </div>
                                </a>

                                <a href="{{route('profile.setup.standalone', ['page' => 'video'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-video"></i>
                                        </div>
                                        Premium Videos
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Products
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('profile.setup.standalone', ['page' => 'product'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-store-alt"></i>
                                        </div>
                                        Standard Products
                                    </div>
                                </a>
                                <a href="{{route('profile.setup.standalone', ['page' => 'product', 'content' => 'pod'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-paint-roller"></i>
                                        </div>
                                        Print on Demand
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='orders'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Finances
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('profile.setup.standalone', ['page' => 'stripe'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                        Stripe Dashboard
                                    </div>
                                </a>
                                <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                        Purchases
                                    </div>
                                </a>
                                <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-pound-sign"></i>
                                        </div>
                                        Sales
                                    </div>
                                </a>
                                <a href="{{route('agency.dashboard.tab', ['tab' => 'my-transactions'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        Summary
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each {{isset($page)&&$page=='tools'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Artist Tools
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a href="{{route('agency.dashboard.tab', ['tab' => 'industry-contacts'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        Industry Contacts
                                    </div>
                                </a>
                                <div class="px-5 usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-outdent"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Distribution
                                    </div>
                                </div>
                                <div class="px-5 usr_men_quick_each">
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
                                <a href="{{route('profile.setup', ['page' => 'crowdfunding'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-donate"></i>
                                        </div>
                                        Setup Crowdfunder
                                    </div>
                                </a>
                                <a href="{{route('profile.setup', ['page' => 'setup-patron'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-donate"></i>
                                        </div>
                                        Patron Hub
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
                                <a href="{{route('agency.dashboard.tab', ['tab' => 'contact-management'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-comment-dots"></i>
                                        </div>
                                        Chat
                                    </div>
                                </a>
                                <a href="{{route('agency.dashboard.tab', ['tab' => 'my-questionnaires'])}}" class="usr_men_quick_txt">
                                    <div class="px-5 usr_men_quick_each">
                                        <div class="usr_men_quick_ic">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        Agent Questionnaires
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="usr_men_cat_each usr_men_seller_help mobile-only">
                    	Get help to build your profile
                    </div>
                    <div class="usr_men_cat_each usr_men_logout">
                        <a href="{{route('agency.delete.account')}}" class="usr_men_cat_head">
                            <i class="fa fa-trash"></i>&nbsp;Delete my account
                        </a>
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
