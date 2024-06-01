@extends('templates.basic-template')

@section('pagetitle') Frequently Asked Questions | 1 Platform TV @endsection

<!-- Page Level CSS !-->
@section('page-level-css')
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <style>

        .faq_main_outer h3 { font-size: 14px; color: #fff; }
        .faq_main_outer p { font-size: 13px; line-height: 20px; color: #fff; }
        .faq_main_outer { position: relative; width: 100%; padding: 40px 85px; font-family: 'Montserrat', sans-serif; }

        .faq_main_outer ul.normal { color: #fff; font-size: 12px; margin: 10px 40px 0 40px; }
        .faq_main_outer ul.normal li { list-style: disc; }
        .pg_back {
            background-image: url(https://www.1 Platformtvdev.singingexperience.co.uk/images/expert_back_03.jpg);
            content: "";
            position: fixed;
            top: 59px;
            left: 0px;
            width: 100%;
            background-size: cover;
            height: calc(100% - 59px);
            background-position: top center;
            background-repeat: no-repeat;
        }

        .heading { text-align: center; margin-bottom: 40px; font-size: 23px; background-color: #000; width: 100%; padding: 5px 10px; color: #fff; }
        .heading a { color: #ffc107; text-decoration: none; }
        .heading span { float: left; font-size: 14px; display: flex; align-items: center; justify-content: center; height: 28px; }
        .que_outer { display: flex; flex-direction: row; flex-wrap: wrap; padding-top: 100px; justify-content: space-between; }
        .each_que_outer { width: 100%; margin-bottom: 60px; }
        .que_top,.que_bottom { padding: 10px; }
        .que_bottom { display: none; line-height: 26px; }
        .que_top { cursor: pointer; }

        .back_one .que_top { background-color: #000; }
        .back_one .que_bottom { background-color: #333; }
        .back_two .que_top { background-color: #000; }
        .back_two .que_bottom { background-color: #333; }
        .back_three .que_top { background-color: #000; }
        .back_three .que_bottom { background-color: #333; }
        .back_four .que_top { background-color: #000; }
        .back_four .que_bottom { background-color: #333; }
        .back_five .que_top { background-color: #000; }
        .back_five .que_bottom { background-color: #333; }
        .back_six .que_top { background-color: #000; }
        .back_six .que_bottom { background-color: #333; }
        .back_seven .que_top { background-color: #000; }
        .back_seven .que_bottom { background-color: #333; }

        .que_top_head { color: #fff; font-size: 12px; line-height: 20px; }
        .que_head_text { background: #000; padding: 10px; }
        .que_head_section { background: #333; padding: 10px; }
        .que_top_head button { padding: 5px; }


        @media (min-width:320px) and (max-width: 767px) {
            .each_que_outer { width: 100%; }
            .faq_main_outer { padding: 40px 20px !important; }
            .faq_main_outer p { font-size: 12px; }
            .faq_main_outer h3 { font-size: 12px; line-height: 23px; }
            .heading { font-size: 15px; }
            .heading span { font-size: 13px; height: 18px; }
        }
    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <!--  initialize horizontal scroller  !-->
    <script src="/js/horizontal-slider.js" type="application/javascript"></script>
    <script>
        $('document').ready(function(){

            $('.que_top:not(.disabled)').click(function(){
                $(this).closest('.each_que_outer').find('.que_bottom').slideToggle('slow');
            });

            $('.que_top_head button').click(function(){

                window.currentUserId = 1;
                $('#chat_message_popup,#body-overlay').show();
            });
        });
    </script>
@stop

<!-- Page Header !-->
@section('header')

    @include('parts.header')
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')


@stop


@section('page-content')
<div class="pg_back active"></div>
<div class="faq_main_outer">
	<h2 class="heading">
        <a href="{{route('site.home')}}">
            <span>
                <i class="fa fa-home"></i>&nbsp;&nbsp;Home
            </span>
        </a>
        Frequently Asked Questions
    </h2>

    <div class="que_top_head hide_on_desktop">
        <div class="que_head_text">App support</div>
        <div class="que_head_section">
            Thank you for installing the 1 Platform App!<br>
            Should you need any support, feedback or suggestions you can contact us here.<br>
            Available from Monday to Friday GMT : 9 - 5 pm<br>
            Email : oneplatformtv@gmail.com<br><br>
            <button id="user_direct_chat">Direct chat</button>
        </div>
    </div>

    <div class="que_outer">

        <div class="each_que_outer back_one">
            <div class="que_top disabled">
                <h3 style="color: #ffc107;">Tell us, how we can help?</h3>
            </div>
            <div style="display: block;" class="que_bottom">
                <span style="color: white; font-size: 13px">1Platform
                    The world's unique platform that empowers artists with promotion tools, sales capabilities, and industry guidance for a successful career launch
                    <br> <br>
                    Account deletion can be initiated from a button provided in the side menu of mobile app. This deletes the user record and any data associated with the user from our database that is not linked to purchases made by other users of platform. It includes but not limited to user record, user personal data, user products, music, albums, sales, purchases and social media information saved in our database.</span>
                <br><br>
                <p style="font-weight: bold;">Contact us by phone or email</p>
                <div style="color: white;">
                    <i class="fa fa-envelope"></i> oneplatformtv@gmail.com
                </div>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>What Can I Do On 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>Promote yourself as a creator! Connect with other like-minded individuals, start projects you never dreamed of and get a little help from our agents and experts to become better than before!</p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>What Is 1 Platform Used For?</h3>
            </div>
            <div class="que_bottom">
                <p>1 Platform is designed to suit your needs<br></p>
                <ul class="normal">
                    <li>Connect with other creatives</li>
                    <li>Sell merchandise, music, licences, videos and services</li>
                    <li>Promote your work</li>
                    <li>Build an online portfolio to show your best work</li>
                    <li>Set up a crowdfunding</li>
                    <li>Hire one of our agents to boost your career</li>
                    <li>Show all of your work on one page</li>
                    <li>Pick and choose what you want to do on 1 Platform</li>
                </ul>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>Do I Have To Create An Account To Use 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>You don't have to have an account to use 1 Platform, however, you can only purchase products and donate to other people. To set up your page you'll need to sign up and join in the fun</p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>Is There A mobile App For 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>Yes, you can get our app on both apple and android platforms</p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>Do I need A 1 Platform Account To Support A Project Or Buy A Product. </h3>
            </div>
            <div class="que_bottom">
                <p>
                    You do not need to log into the site to buy a bonus/product/song. You can enter all necessary information at checkout.
                </p>
                <p>
                    However, It is recommended that when making a purchase you should either, log in if you have an account or create one. That way you can see your purchases in your profile.
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>What Sort Of Products Can I Sell On 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    1 Platform is fantastic for setting up your own store, whether you are new to it or have been selling for years.
                </p>
                    <p>
                        Physical and digital products can be sold. We also have some unique options such as the ability to sell licences for your music to be used in radio, TV, film and more. You can even include the option for customers to buy stems for your track.
                    </p>
                    <p>
                        To add products go to my media in your profile and get started.
                    </p>
                    <p>
                        This will allow you to sell your music, videos, gig tickets, merchandise or more.
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>What Is The “My Profile” Tab?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    The My Profile tab is where you can view and edit all of your personal information. You can also upload your music and set up a crowdfunder ad so much more from this menu.
                </p>
                <p>
                    You can check our T & C’s at {{route('tc')}}
                </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>How much Information Should I ADD To My Profile?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    As much as possible, the more filled out your profile is the better it looks and we’ve found the better-looking profiles tend to get more attention from both publishers and other buyers. If you get your profile looking amazing you’ll have your media flying off the shelves.
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Am I Allowed To Use My Stage Name/Band Name Instead Of My Real Name?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You are welcome to use your stage name, as we understand as an artist you may have a separate stage name from your personal name. You can change your name in "My Profile" settings located in the "Personal Info" section.
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>Can I Select The Genre Of My Act, And Instrument(s) Used?</h3>
            </div>
            <div class="que_bottom">
                    <p>Of course you can select the genre or your act, and any instrument(s) used. A guide is below;
                    <br>
                    1) Sign in to 1 Platform: www.1 Platform.tv.<br>
                    2) From your "My Profile" tab, click the 'My Media Info" tab.<br>
                    3) From there, click the drop down list under main skill and add where you think your main skill set lies.<br>
                    4) Then add any instruments you can play using the instruments option<br>
                    5) Click the drop down list next to 'Genre' here you can select from Blues to Traditional.<br>
                    6) Once you're done don't forget to save your profile information.
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>Can I Connect Other Social Media Accounts?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Connecting your professional social media accounts is optional. You can connect them from your profile. We do recommend adding these profiles so you can increase your following easily
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>Will I Be Able To View My Subscribers Details?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        Subscriber details are viewable in the profile updates section of my profile. In this section you will be able to view the money earned and your subscriber’s details. Here you can also thank anyone that has supported any crowdfunder you may have started
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>How Do I Change My Password?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Go to "My Profile" and select "Change Password" next to "Password". A pop up will appear allowing you to enter in your old password and create a new one
                </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>I Think That Someone Has Created A Fraudulent Account Or Is Pretending To Be Me.</h3>
            </div>
            <div class="que_bottom">
                <p>
                    If you are having issues with an account then please email contact@1 Platform.tv
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Can I Delete My Account?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    No you can't, but you can switch it to be a free account if you email us on our contact email contact@1 Platform.tv
                </p>
                <p>
                    This is so that people who bought from your page or agreed on anything with you can still access all of the relevant files/information they need
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>How To Get In Touch With An Issue With The Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Having an issue with the website? An unnoticed bug? Page crash or site error. Email our team at contact@1 Platform.co.uk. Please give a description of what happened when the issue started and if you can provide a screenshot to help us replicate the issue ourselves
                </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>Can I Upload Any Content That Isn't Music Related?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Currently you can upload music, you can add photos to your bio and link to videos from other websites (i.e YouTube). We are working to implement the ability to upload different types of media but at the moment we are focusing on getting music perfect first
                </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>How Do I Edit The Information Of A Song Or Product Once It Is Uploaded?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        To edit the information of a product or song go to "My Media" and click the pencil icon of the item you want to change to edit the information of that item
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>How Big Should Thumbnail Be?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        When you upload a song or product then you can add a thumbnail. This might be a picture of your product or cover art for your song/album.
                        <br>
                        We recommend 500x280.
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>I Have Added A Song But No Buying Options Are Available?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        For buying options to appear on the music you need to select licence prices when you upload your music in the profile. To edit licence prices go to "My Media" and then “Edit Music" and click the Pencil icon to edit the information of the song you want to edit
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>Is a Safe Payment System Used?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        1 Platform uses stripe for all payment processing.
                    </p>
                    <p>
                        Stripe is secure by design using PCI-DSS compliance for your payments, which means each payment made and received will be stored safely and securely.
                    </p>
                    <p>
                        A User Bought An Item From Me, How Do I Find Their Shipping Address?
                    </p>
                    <p>
                        To find out shipping information go to "My Profile" and click the tab “My Sales And Purchases” then click “My Sales” to see the correct information
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>A User Bought An Item From Me, How Do I Find Their Shipping Address?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    To find out shipping information go to "My Profile" and click the tab “My Sales And Purchases” then click “My Sales” to see the correct information
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>What Are Music Licenses?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        When you sell your music on 1 Platform you can add prices for each music license that includes things like personal use, or use for an advert.
                    </p>
                    <p>
                        If someone buys a licence for your song they will buy it for that particular use. So if someone buys a licence to use in a film then they can use it for their film but not for an app. Each use of the music needs a licence.
                    </p>
                    <p>
                        Master and copyright buyouts can also be sold
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>What Is A Copyright/Master Buyout?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    A Copyright/Master buyout means that the person who purchased the music has brought you out of your rights to your music.
                </p>
                <p>
                    Be very careful when having this option available if you don't want people to have ownership of your music
                </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>What Do I Need To Start A Project?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    An Idea! After that you can add a video explaining your idea. After that you just need to think about what you want to offer to your project supporters as bonuses
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>How Do I Buy A Licence through 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    It's easy, all you have to do is go to the user whose music you’d like to licence. From there click on their music and any song with a buy icon can be purchased. You can either buy a personal licence to use in a personal project or a licence for your commercial project. Please be aware that musicians will set their own price for licences
                </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                 <h3>If I Purchase A Licence For A Song, What Can I Use It For?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        Licences are use specific, such as "App". This will allow you to use the song for your app and nothing else.
                    </p>
                    <p>
                        If you wanted to use the same song in a film then you would have to purchase a film licence as well
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>How Do I Buy A Song Just For Personal Listening?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    When choosing a licence you can just choose a "personal licence" which will allow you to just listen to a song. Or you can listen to it using the player on our site
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Can I Buy Multiple Licences For A Song?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You can! You can add each licence that you need to the shopping cart
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>I Bought A Song/Licence, How Do I Get It?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    When you buy a song you will receive an email from 1 Platform containing the details of your purchase. Your songs will be attached to this email
                </p>
                <p>
                    You can also find all your purchases and downloads in “my profile” the “my sales and purchases”
                </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>Are The Licences On 1 Platform Exclusive?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    A Licence purchased on 1 Platform Is Non-Exclusive
                </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>How Long Will A Licence Last?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Licences purchased on 1 Platform are for perpetual use and do not need renewing. This excludes bespoke licences where the customer and creator will agree there own terms
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>Can I Sell My Music On 1 Platform If It's Already On Other Platforms?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Yes, you can sell music on 1 Platform, even if it is already available on I-tunes,Amazon, spotify ETC
                </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>What Prices Should I Give My Licences?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        When you upload your song we will give you a recommended price list. You can choose to change this if you want by editing the prices on the edit music tab. Remember if you don't want to sell a certain licence don't add a price
                    </p>
                    <p>
                        We do encourage musicians to be reasonable with their prices - especially for the cost of a personal licence as this is how users listen to your song
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>I Co-Own A Song With Other Musicians/people. What Do I do?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    If you are not the sole owner of your product/song then you must inform your co-owners that you intend to sell the song on 1 Platform. As the seller of the song, you are responsible for splitting the earnings between all parties. You cannot sell a song without written permission from all owners, otherwise, you will be breaking our terms and conditions and the law
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Can I Sell A Cover Song On 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        While you can cover a song as you wish and post it on 1 Platform. You cannot sell a cover of a song unless you have permission/agreement from the copyright owners. (i.e payment of royalties from sales etc). Otherwise, you will be breaking our terms and conditions and the law
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>Can I Sell A Remix Of A Song I Do Not Own?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You cannot sell a song you do not own, even a remix, unless you have written permission from the song owner. Otherwise, you will be breaking our terms and conditions and the law
                </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>Can I Sell Songs That I Do Not Own Copyright For?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    If you have no rights/ownership of a song then you cannot sell it on 1 Platform. Otherwise, you will be breaking our terms and conditions and the law
                </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>What If I Don't Want To Sell Any Licences For My Song?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    If you just want to sell your song so that people can listen to it, all you have to do is upload your song and only add a personal licence cost
                </p>
                <p>
                    A Personal Licence will allow someone to listen to your song as well as use it for non-commercial projects (non-profit). This is identical to people buying the song off iTunes etc
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>Do I Receive Royalties If I Licence A Song Through 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You will, but 1 Platform will not collect royalties or. You must be registered with a P.R.O. (ASCAP, BMI, SEASAC...) and it is their responsibility to collect the royalties. If you are not registered you will not receive the royalties
                </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>Do I Receive Royalties If I Licence A Song Through 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You will, but 1 Platform will not collect royalties or. You must be registered with a P.R.O. (ASCAP, BMI, SEASAC...) and it is their responsibility to collect the royalties. If you are not registered you will not receive the royalties
                </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>Do I need to create a project?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    No, creating a project is optional on 1 Platform
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Can Money Really Be Raised To Help My Musical Interest Or Career?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        Yes of course! If you have a passion for your career 1 Platform can be used to raise funds to help propel your work.
                    </p>
                    <p>
                        Some of the things people have raised funds for is equipment, tours, even recording an album or making a book.
                    </p>
                    <p>
                        You can do anything and everything that will help you flourish with your media!
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>What Are The Different Types Of Projects?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        When creating a project you can choose from three types of projects.
                    </p>
                    <p>
                        Charity - choose this option if you want to raise funds for a good cause. Charity Projects don't have to reach their goal to receive the funds for their project.
                    </p>
                    <p>
                        Flexible- With a flexible project you can raise your funds as you would normally, but you can keep the funds if you do not reach the goal. Do not choose this option if your project needs a fixed amount of money to succeed as you may find you do not have the funds to complete the project if you don't meet your goal.
                    </p>
                    <p>
                        Personal - With a personal project you can raise funds for your next album, music video and so on. If you do not reach your goal then you will not receive your funds. Choose this option if you can only complete your project if you reach your goal. i.e reward supporters or produce a final product
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>Can I Change My Crowdfunding Project Information?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Up until someone supports your project, you can edit the project information. Once someone has supported your project you will only be able to change certain information such as title, video and story. You will not be able to start a new project until your current one has finished
                </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>Who Can Donate To My Project?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Anyone can donate to your project, this could be family, friends, loved ones, and even people from across the world!
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>How Do I Create A Successful Project?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        The secret to a great project is both a great idea and to connect your social media accounts, this will allow yourself to share with family, friends and supporters.
                    </p>
                    <p>
                        We also recommend using the best quality pitch video you can make as this is what will sell your project to your audience. You will be certain to gain donations from people who feel passionate about why you're raising money
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>What If I Wanted To Raise Money For A Friend?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        You may set up the money raised to go directly into your friend’s stripe account
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>What Is The Maximum Amount Of Days I Can Run A Fundraising Project For?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You can run a 1 Platform Project for up to 60 days. Do not forget you can have subscribers who will provide a monthly contribution towards your projects, be sure to offer good incentives with up to 3 exciting bonuses (bonuses are incentives offered to backers in exchange for their support.)
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Which Countries Can Donate?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Many countries and currencies are supported these include the United States of America ($USD), the United Kingdom (£GBP), and any European Union country that uses the Euro as their official currency (€EUR)
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>Is it safe to use phones to donate?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    Of course, we also have an easy to use mobile compatible website to allow people to donate from any device they wish
                </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
                <h3>Does It Cost Anything To Receive Donations?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        It is free to join 1 Platform, and start raising funds whilst doing what you love!
                    </p>
                    <p>
                        However, a deduction of 5% will be taken from each donation that is received. This fee will be automatically deducted, this helps support the website and keep it as a free service.
                        Also, a small processing fee of about 3% will also be deducted from each donation, due to the secure payment system used
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
                <h3>Is the 5% charge compulsory across all donations?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        The 5% charge is compulsory with all donations, as we give the opportunity for many users to join 1 Platform for free. The 5% helps us keep this part of our website free for everyone to use
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>Do contributors get charged for supporting my project?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        Anyone that contributes to your project will not get charged, which means that people will only pay the amount they choose to contribute. The fee comes from the project creator
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                 <h3>Is There A Limit To How Much I Can Raise On 1 Platform?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        There is no limit to your project amount. However, we encourage users to only raise the amount needed to make the goal achievable and to make the project seem credible. you can add credibility by adding videos explaining your project to people. Otherwise, users may find it difficult to trust your project.
                    </p>
                    <p>
                        Do remember that you can exceed your project goal
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>Will My Funding Stop Once I Have Reached My Goal?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        When you set a project goal it will show the cost of your project. However if your project is successful and passes your goal then you will continue to raise funds
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>How Do I Accept Payment For A Project?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        When you set up a project you will be asked to connect a stripe account. You cannot receive payments without a Stripe account so be sure to do it
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>How Do I Receive Money Raised?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        If you are running a charity or flexible project then you will receive your money regardless of whether or not you reach your campaign goal.
                    </p>
                    <p>
                        If you are running a personal project then you will only receive funds if you reach your project goal.
                    </p>
                    <p>
                        When your campaign ends the funds will be sent to your stripe account. Please allow some time for the funds to process
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
              <h3>How Long Will It Take To Transfer Any Money Raised?</h3>
            </div>
            <div class="que_bottom">
               <p>
                   Transfers from your stripe account can take 7 to 10 business days, you will be able to set up an automatic transfer system through your stripe account, meaning one less thing to worry about
               </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
               <h3>Money Was Raised Offline Can This Be Added To Our Project?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    It is not possible to add money raised offline to your online account, this gives all projects a fair chance in reaching the goal set
                </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>Do I Need To Pay Taxes On Any Money Raised?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    We can not provide specific tax advice, as everyone has different circumstances. Donations on 1 Platform are considered to be a personal gift. If you would like advice on whether you will need to pay taxes for earning money online please enlist the help of a tax professional in your area
                </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>What Are Bonus Donators?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    A bonus donator is someone that has supported your project by purchasing a bonus you have set
                </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>l Haven't Reached My Goal, What Happens Next?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        If you are running a charity project or a flexible funding project then you will still receive your funds
                    </p>
                    <p>
                        If you are running a personal project then your funds will be returned to your supporters. Don't worry though, you can start a brand new project in your profile page
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>Do I Get Notified When Someone Donates?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    When someone donates you will receive a notification on the site and in email. To thank anyone who contributes you can go to your “My Sales And Purchases” on your profile editor. You can send a thank you email from here to your project supporters
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                 <h3>Is It Possible To Keep A Project Private?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    We recommend sharing your project with family, friends, and people across the world. This will allow your project more success in reaching your goals! This also means your project is more likely to be seen by strangers from across the globe
                </p>
            </div>
        </div>

        <div class="each_que_outer back_four">
            <div class="que_top">
              <h3>Is It Possible For Contributors To Remain Private?</h3>
            </div>
            <div class="que_bottom">
               <p>
                   Contributors have a choice whether they would like the world to know their identities, however, as a project owner, you will always know who has supported your project. This allows rewards or updates to be given to the contributor
               </p>
            </div>
        </div>

        <div class="each_que_outer back_five">
            <div class="que_top">
               <h3>How will I receive updates?</h3>
            </div>
            <div class="que_bottom">
                    <p>
                        To view the updates of your project you can go to your profile page. In the tab labelled “My Sales And Purchases” you can see your project updates. Including your bonuses, subscribers, product orders for your store and project supporters
                    </p>
                    <p>
                        You will also get various email updates on your projects for things such as project supporters
                    </p>
            </div>
        </div>

        <div class="each_que_outer back_six">
            <div class="que_top">
                <h3>How Do I Get A Refund On A Project I Have Supported?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    If you have supported a project or store item and would like to get a refund please contact the project creator that you purchased the item from. If this is a Charity or Flexible project you may not be able to get a refund as they may have already used the funds for the project. Refunds cannot be given if there is less than 24 hours before the project ends
                </p>
            </div>
        </div>

        <div class="each_que_outer back_seven">
            <div class="que_top">
                <h3>How Many Songs Can I Have In The Chart?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    You can add 1 song per account, so make sure to pick your best work to get further up the charts. You can add 1 new song each week
                </p>
            </div>
        </div>

        <div class="each_que_outer back_one">
            <div class="que_top">
                <h3>How Long Does The Chart Go On For? </h3>
            </div>
            <div class="que_bottom">
                <p>
                    A new winner is announced each week and then the chart is refreshed so we can start again. The chart will begin every Sunday at 12 pm
                </p>
            </div>
        </div>

        <div class="each_que_outer back_two">
            <div class="que_top">
                <h3>What Type Of Songs Are Allowed Into The Chart?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    1 Platform chart is a place for our website users to enter a weekly cover of a song of their choosing. Cover songs of any genre are allowed. You can even cover 1 song in a totally different genre to the original. Be as creative as you want
                </p>
            </div>
        </div>

        <div class="each_que_outer back_three">
            <div class="que_top">
                <h3>How Long Can My Song Be In The Chart?</h3>
            </div>
            <div class="que_bottom">
                <p>
                    As long as you want! The chart runs each week and your position will update each week so one week you could be No. 1000 and the next No. 4
                </p>
            </div>
        </div>

    </div>

</div>
@stop

@section('miscellaneous-html')
    @include('parts.chart-popups')
</div>
@stop
