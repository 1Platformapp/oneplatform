
@if(!$user->internalSubscription)
    @php $accessAction = 'Subscribe' @endphp
@else
    @php $accessAction = isset($upgrade) ? 'Upgrade' : 'Connect stripe' @endphp
@endif

<div class="pro_stripeless_outer">

    @if($user->internalSubscription)

        @if($page != 'domain' && $page != 'industry_contacts' && $page != 'crowdfund' && $page != 'add agent contacts')
        <div class="pro_stripeless_inner clearfix">
            <div class="pro_stripeless_head">
                <i class="fa fa-exclamation-triangle"></i> 
                @if($page == 'website_design')
                    You can design your website page but no one can purchase from it unless you complete your profile
                @elseif($page == 'services')
                    You can add services to your account but no one can avail them unless you complete your profile
                @elseif($page == 'portfolio')
                    Your profile is not complete yet
                @else
                	You can {{$page}} to your account but no one can purchase unless you setup your bank account to receive monies
                @endif
            </div>
            <div class="pro_stripeless_foot">
                <a href="{{isset($upgrade) ? route('user.startup.wizard', ['action' => 'upgrade-subscription']) : $stripeUrl}}" class="{{isset($upgrade) ? 'int_sub_unsub' : ''}} get_access_btn">{{$accessAction}}</a>
                @if($user->username)
                <a href="{{route('user.home', ['params' => $user->username])}}" class="get_access_btn">View My Website</a>
                @endif
            </div>
        </div>
        @endif

    @else

        @if($page == 'add music')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Upload music in mp3 or wav with loops and stems</li>
                        <li>Sell standard or bespoke licenses</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add products')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Add products to sell</li>
                        <li>Add tickets for a gig or event</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add videos')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Add YouTube or Soundcloud URLs for your fans to promote your website or showcase your artworks online</li>
                        <li>The YouTube or Soudcloud will stream from its respective source on your website</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'connect social media')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Connect your social media accounts. They will display on your website's social tab</li>
                        <li>Promote your profile using your social accounts</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add premium videos')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Add your premium videos from YouTube</li>
                        <li>The premium videos can only viewed by particular users like your fans, supporters, subscribers or followers</li>
                        <li>You will have full control over who can view these videos</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add subscription box')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Add an option so your fans or supporters can subscribe to you</li>
                        <li>You can control the subscription amount and whether to switch it ON or OFF</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add song links')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>On demand smart links for your home page music tab</li>
                        <li>Targets all major platforms so you can share better</li>
                        <li>Works automatically for any song uploaded to the major platforms</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add albums')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Create albums and add music into them</li>
                        <li>You can sell albums with personal use license only</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
        @if($page == 'add news')
            <div class="pro_connect_outer">
                <div class="pro_connect_head">{{$accessAction}} to get access</div>
                <div class="pro_note">
                    <ul>
                        <li>Create news and keep your fans updated with new events</li>
                    </ul>
                </div>
            </div>
            <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
        @endif
    @endif

    @if($page == 'domain')
        <div class="pro_connect_outer">
            <h2>{{$accessAction}} to get access</h2><br><br>
            <div class="pro_note">
                <ul>
                    <li>If you own a domain e.g example.com, connect it with 1Platform so the viewers of example.com can see and purchase all your artwork added from your 1Platform account</li>
                    <li>Upgrade your plan to avail this opportunity and increase your online visibility</li>
                </ul>
            </div>
        </div>
        <a href="{{isset($upgrade) ? route('user.startup.wizard', ['action' => 'upgrade-subscription']) : $stripeUrl}}" class="{{isset($upgrade) ? 'int_sub_unsub' : ''}} get_access_btn">{{$accessAction}}</a>
    @endif
    @if($page == 'crowdfund')
        <div class="pro_connect_outer">
            <div class="pro_connect_head">{{$accessAction}} to get access</div>
            <div class="pro_note">
                <ul>
                    <li>Generate capital for your next musical venture</li>
                    <li>Create a charity campaign for good causes or a personal campaign to help your music</li>
                    <li>Let your fans support you like never before</li>
                    <li>Add unique bonuses to incentivise your supporters</li>
                </ul>
            </div>
        </div>
        <a href="{{$stripeUrl}}" class="get_access_btn">{{$accessAction}}</a>
    @endif
    @if($page == 'industry_contacts')
        <a href="{{isset($upgrade) ? route('user.startup.wizard', ['action' => 'upgrade-subscription']) : $stripeUrl}}" class="{{isset($upgrade) ? 'int_sub_unsub' : ''}} get_access_btn">{{$accessAction}}</a>
    @endif
    @if($page == 'add agent contacts')
        <a href="{{isset($upgrade) ? route('user.startup.wizard', ['action' => 'upgrade-subscription']) : $stripeUrl}}" class="{{isset($upgrade) ? 'int_sub_unsub' : ''}} get_access_btn">{{$accessAction}}</a>
    @endif
</div>