
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
                                <div data-link="profile-setup/welcome" data-cat="" data-sub-cat="" class="usr_men_quick_each usr_men_setup_wizard">
                                    <img src="{{asset('images/setup_recommend.gif')}}">
                                    <div class="usr_men_quick_txt">
                                        <div class="usr_men_quick_ic">
                                            <i class="fa fa-cog"></i>
                                        </div>Profile Setup Wizard
                                    </div>
                                </div>
                                @if(!Auth::user()->expert && Auth::user()->apply_expert != 2 && !Auth::user()->agent)
                                <div data-link="profile/chat/get-agent" data-cat="chat" data-sub-cat="get_agent" class="usr_men_quick_each usr_men_setup_wizard">
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
                    <div data-cat="profile" class="usr_men_cat_each {{isset($page)&&$page=='edit'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Website
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/edit/info" data-cat="profile" data-sub-cat="edit" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Add Personal Info
                                    </div>
                                </div>
                                <div data-link="profile/edit/media" data-cat="profile" data-sub-cat="media" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Add Media Info
                                    </div>
                                </div>
                                <div data-link="profile/edit/design" data-cat="profile" data-sub-cat="design" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-paint-brush"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Design & Layout
                                    </div>
                                </div>
                                <div data-link="profile/edit/bio" data-cat="profile" data-sub-cat="bio" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-user-edit"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Add Bio
                                    </div>
                                </div>
                                <div data-link="profile/edit/portfolio" data-cat="profile" data-sub-cat="portfolio" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        My Portfolio
                                    </div>
                                </div>
                                <div data-link="profile/edit/services" data-cat="profile" data-sub-cat="services" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        My Services
                                    </div>
                                </div>
                                <div data-link="profile/edit/domain" data-cat="profile" data-sub-cat="domain" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Connect Domain
                                    </div>
                                </div>
                                <div data-link="profile/media/news" data-cat="media" data-sub-cat="news" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        News
                                    </div>
                                </div>
                                <div data-link="profile/media/social-media" data-cat="media" data-sub-cat="social" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-connectdevelop"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Social Media
                                    </div>
                                </div>
                                <div data-link="profile/media/subscribers" data-cat="media" data-sub-cat="subscribers" class="usr_men_quick_each">
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
                    <div data-cat="media" class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Music
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/media/add-music" data-cat="media" data-sub-cat="add_musics" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-headphones"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Upload Music
                                    </div>
                                </div>
                                <div data-link="profile/media/edit-music" data-cat="media" data-sub-cat="edit_musics" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-edit"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Edit Music
                                    </div>
                                </div>
                                <div data-link="profile/media/albums" data-cat="media" data-sub-cat="my_albums" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-compact-disc"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        My Albums
                                    </div>
                                </div>
                                <div data-link="profile/media/song-links" data-cat="media" data-sub-cat="song_links" class="usr_men_quick_each">
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
                    <div data-cat="media" class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Videos
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/media/videos" data-cat="media" data-sub-cat="videos" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-youtube"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        YouTube Videos
                                    </div>
                                </div>
                                
                                <div data-link="profile/media/premium-videos" data-cat="media" data-sub-cat="live_streams" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-video"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Premium Videos
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div data-cat="media" class="usr_men_cat_each {{isset($page)&&$page=='media'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Products
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/media/products" data-cat="media" data-sub-cat="standard_products" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-store-alt"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Standard Products
                                    </div>
                                </div>
                                <div data-link="profile/media/products" data-cat="media" data-sub-cat="print_products" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-paint-roller"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Print on Demand
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-cat="orders" class="usr_men_cat_each {{isset($page)&&$page=='orders'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            My Finances
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/orders/purchases" data-cat="orders" data-sub-cat="my_purchases" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Purchases
                                    </div>
                                </div>
                                <div data-link="profile/orders/sales" data-cat="orders" data-sub-cat="my_sales" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-pound-sign"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Sales
                                    </div>
                                </div>
                                <div data-link="profile/orders/summary" data-cat="orders" data-sub-cat="summary" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Summary
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-cat="tools" class="usr_men_cat_each {{isset($page)&&$page=='tools'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Artist Tools
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/tools/industry-contacts" data-cat="tools" data-sub-cat="industry" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Industry Contacts
                                    </div>
                                </div>
                                <div data-link="profile/tools/streaming-distribution" data-cat="tools" data-sub-cat="streaming" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-outdent"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Distribution
                                    </div>
                                </div>
                                <div data-link="profile/tools/marketing" data-cat="tools" data-sub-cat="marketing" class="usr_men_quick_each">
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
                    <div data-cat="crowdfunds" class="usr_men_cat_each {{isset($page)&&$page=='crowdfunds'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Crowdfunding
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <a data-link="profile/crowdfunds" data-cat="crowdfunds" data-sub-cat="crowdfunds" class="usr_men_quick_each">
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
                    <div data-cat="chat" class="usr_men_cat_each {{isset($page)&&$page=='chat'?'pro_tb_active':''}}">
                        <div class="usr_men_cat_head">
                            Networking
                        </div>
                        <div class="usr_men_cat_body">
                            <div class="usr_men_quicks">
                                <div data-link="profile/chat/box" data-cat="chat" data-sub-cat="chat_box" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Chat
                                    </div>
                                </div>
                                @if(Auth::user()->expert && Auth::user()->apply_expert == 2)
                                <div data-link="profile/chat/contacts" data-cat="chat" data-sub-cat="contacts" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Agent Contacts
                                    </div>
                                </div>
                                <div data-link="profile/chat/questionnaires" data-cat="chat" data-sub-cat="questionnaires" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Agent Questionnaires
                                    </div>
                                </div>
                                @endif
                                @if(!Auth::user()->expert && Auth::user()->apply_expert != 2)
                                <div data-link="profile/chat/get-agent" data-cat="chat" data-sub-cat="get_agent" class="usr_men_quick_each">
                                    <div class="usr_men_quick_ic">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <div class="usr_men_quick_txt">
                                        Get an Agent
                                    </div>
                                </div>
                                @endif
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