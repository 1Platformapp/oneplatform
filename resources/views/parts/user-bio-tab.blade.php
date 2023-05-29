
@php 
    $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();
    $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);
@endphp


<div class="btm_text_stor_outer">
    <div class="bio_sec_story_text">
        @if($user->isCotyso())
            <h2 class="user_bio_sec_head">Our recording studios operate all over the UK for singers, bands and musicians</h2>
            <p>
                Since its founding in 2010, Singing Experience with its various locations across the UK is proud of achieving the leading reviews on Google and Facebook. Our recommended experience days welcomes the absolute beginner to the seasoned professionals. 
            </p><br>
            <p>
                Our Professional studios specialize in audio, video, photoshoots, artist management, and live events.  For musicians, bands and singers looking to record - check out our latest store sale. If you have purchased a voucher and looking to book an experience, drop us a message using our live chat below. 
            </p><br>
            <p>
                To find a Music Studio Near you drop us a message.
            </p>
            <p>
                Singing Experience
            </p>
        @endif
        <p>{!! $userPersonalDetails['storyText'] !!}</p>
        @if($userPersonalDetails['storyImages'] != '')
        <div class="bio_story_images">
            @foreach(explode(',', $userPersonalDetails['storyImages']) as $key => $storyImage)
            @if($storyImage != '')
            <div class="user_story_image">
                <img alt="{{$user->name.'\'s story'}}" class="defer_loading" src="#" data-src="{{asset('user-story-images/'.$storyImage)}}">
            </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</div>
@if(count($user->portfolios))
<div class="portfolio_outer">
    <div class="spacer"></div>
    <div class="portfolio_main_title">Projects Portfolio</div>
    <div class="portfolio_det_outer"></div>
    <div class="portfolio_each_contain">
        @foreach($user->portfolios as $portfolio)
        <div data-id="{{$portfolio->id}}" class="portfolio_each">
            <div class="each_port_up">
                <div class="drop"></div>
                <img alt="{{$portfolio->title}}" class="defer_loading" src="#" data-src="{{asset('portfolio-images/'.$portfolio->displayImage())}}">
                <span>View Project</span>
                <div class="cloader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="each_port_down">
                <div class="each_port_name">
                    {{$portfolio->title}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@if($user->isCotyso())
    <div class="bio_sec_story_text">
        <div class="spacer"></div>
        <h2 class="user_bio_sec_head">Check out what singing experience offers </h2>
        <h3 class="user_bio_ter_head">Party Experience</h3>
        <p>
            At Singing Experience we want to give your kids the opportunity to create some new happy memories during this difficult time. We welcome back <a class="user_bio_link" target="_blank" href="https://www.facebook.com/watch/?v=113773873358977">pop star parties</a> of up to 5 to singing experience! The answer to gifts, birthday parties and days out for family and friends alike! Suitable for all ages! Get your experience, click our store tab above and check out variuos packages for parties
        </p>
        <h3 class="user_bio_ter_head">Singing Experience</h3>
        <p>
            One of the best cover songs sung by Georgia Povey at singing experience studios. <a class="user_bio_link" target="_blank" href="https://fb.watch/6qOuMDCBj7/">Here</a> is its link. Covering river by Bishop Briggs, we think Georgia did an amazing job, you should check out the full cover over on our YouTube  
        </p>
        <h3 class="user_bio_ter_head">Photo / Video Shoots</h3>
        <p>
            We have hosted photo shoots, video shoots, live streams, seminars and workshops. We have hosted Bridal and wedding companies, giving them the space they need to photograph beautiful dresses and accessories. Agnes Black hosted a <a class="user_bio_link" target="_blank" href="https://www.facebook.com/singingexperience/posts/2054846571284073">workshop</a> in wedding/couple photography, allowing photographers to learn and experiment outside the intense world of wedding photography! Check out the behind the scenes pictures!
        </p>
        <h3 class="user_bio_ter_head">Audio / Video</h3>
        <p>
            Watch <a target="_blank" class="user_bio_link" href="https://fb.watch/6qMrlI2-YH/">this</a> clip of the Brass Quintet from Undiscovered Brass - Recording in our live room, a great studio space for those wanting to get both great audio and stunning video. 
            Undiscovered brass are a very interesting project, designed to expand the arrangements available to brass ensembles. Taking songs that have never been performed by brass bands or had little attention from brass.
            Great to have the guys revisit the studios from last year!
        </p>
        
        <h2 class="user_bio_sec_head">Our nationwide studios network</h2>
        <p>
            We have various nationwide locations including Manchester, London, Liverpool, Birmingham, Nottingham, Edinburgh and many more. When booking we will provide you with a studio closest to your location, just click the button at bottom right and send us a message. We will provide all necessary details to you
            
        </p>
        <h2 class="user_bio_sec_head">Are you looking for a music studio near you?</h2>
        <p>
            At SE Studios we are connected in over 50 Locations so we are sure to have a Music Studio near you, Singing Experience Studios has an expanding network of clients, based throughout the UK, including BBC, Sky Arts, Liberty Bell, Marks & Spencer,Dot, Profoto, Hasselblad many more. We’ve also worked with big artists from the following list:One Direction, Bernard Sumner, New Order, BBC1 Bang Goes The Theory, National Geographic Eyewitness, Jason Manford, LLoyd hanley, Emmerdale, Silvan (Simply Red), Andrew Sheridan (England rugby player), Blur, H2o platinum, (One man and his dog BBC2) Fosters, Coca Cola , Bend it like Beckham (soundtrack score of Backyard dog).
        </p>
        <h2 class="user_bio_sec_head">See our reviews with singers and musicians</h2>
        <ul class="user_bio_list">
            <li>
                Hayley Turner     ★★★★★ 
                What a fabulous experience for a first-timer. My daughter loved her session and came out beaming. Callum and Tom were very friendly and put her at ease. Highly recommended. What a fabulous experience for a first-timer. My daughter loved her session and came out beaming. Callum and Tom were very friendly and put her at ease. Highly recommended
            </li>
            <li>
                Fraiser Holland     ★★★★★ 
                Many thanks again for the wonderful treatment of our daughter. You certainly provided her with an experience she'll never forget. She couldn't stop talking about it all the way home. She has a constant reminder now of something positive about herself that she can listen to when she needs to
            </li>
            <li>
                Caroline McDonnell     ★★★★★
                Well, what a fantastic two hours! I took my daughter (the birthday girl) for a singing experience with her friends. I did not really think it would be that good but I was really impressed with the calibre of the whole time there. All our family are taken aback and said our daughter actually looks like a pop star
            </li>
        </ul>
    </div>
@endif
@if(count($allPastProjects) > 0)
<div class="past_projects_outer hide_on_mobile">
    <div class="spacer"></div>
    <div class="past_projects_inner">
        <div class="past_projects_head">
            Past Projects
        </div>
        @foreach($allPastProjects as $campaign)
        @if($campaign->title == '')
        @php continue @endphp
        @endif
        @php
        $amountRaised = $campaign->amountRaised();
        $amountRaisedPercent = $amountRaised > 0 ? ($amountRaised/$campaign->amount) * 100 : 0;
        $amountRaisedPercent = $amountRaisedPercent > 100 ? 100 : ceil( $amountRaisedPercent );
        $targetAmount = $commonMethods->getNumberShortened($campaign->amount, 2);
        $currencySymbol = $commonMethods->getCurrencySymbol($campaign->currency);
        @endphp
        <div data-link="{{route('user.project', ['username'=>$campaign->user->username,'load_campaign'=>$campaign->id])}}" class="each_past_project">
            <div class="percent_thumb">
                <img alt="{{$campaign->title.' has raised '.$amountRaisedPercent.'%'}}" class="defer_loading" src="#" data-src="/percent-images/{{$amountRaisedPercent}}.png">
            </div>
            <div class="project_det">
                <div class="project_title">
                    {{$campaign->title}}
                </div>
                <div class="project_goal">
                    <span>
                    {{$currencySymbol.number_format($amountRaised, 0)}}
                    </span>
                    raised of 
                    <span>
                    {{$currencySymbol.$targetAmount}}
                    </span>    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif