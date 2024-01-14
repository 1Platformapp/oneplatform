@extends('templates.advanced-template')


@section('pagetitle')
    @if($user->profile->seo_title != '')
        {{$user->profile->seo_title}}
    @else
        {{$user->name}} - Crowdfunder
    @endif
@endsection

@section('pagekeywords')
    @if($user->profile->seo_keywords != '')
        <meta name="keywords" content="{{$user->profile->seo_keywords}}" />
    @endif
@endsection

@section('pagedescription')
    @if($user->profile->seo_description != '')
        <meta name="description" content="{{$user->profile->seo_description}}"/>
    @else
        <meta name="description" content="{{strip_tags(preg_replace('/\s+/', ' ', $userPersonalDetails['storyText']))}}"/>
    @endif
@endsection


@section('page-level-css')

    <link rel="stylesheet" href="{{asset('css/project.css?v=2.2')}}"></link>
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}"></link>

    @if($user->home_layout == 'background')
        <link rel="stylesheet" href="{{asset('css/user_home_background.min.css')}}"></link>
    @endif

@stop


@section('page-level-js')

    <script src="https://js.stripe.com/v3/"></script>
    <script defer src="/js/video-player.js" type="application/javascript"></script>
    <script defer src="/js/feat_items_scroller.js"></script>
    <script defer src="{{asset('js/jquery-ui.min.js')}}" type="application/javascript"></script>


    <!-- Youtube subscribe -->

    <script defer src="https://apis.google.com/js/platform.js"></script>

    <!-- Youtube subscribe -->

    <script type="text/javascript">

        window.ajaxResponse = null;

        window.stripeToken = null;

        window.currentUserId = {{$user->id}};

        window.autoShare = '{{$autoShare}}';

    </script>


    @if($user->home_layout == 'background')
        <script src="{{ asset('js/user_home_background.min.js') }}"></script>
    @endif

    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <script type="application/javascript">

        var actualSubTotal = 0;
        var actualBonusTotal = 0;

        $('.hdr_shop_cart_otr').addClass('instant_hide');
        $('#read_more_less_btns').hide();
        $('.read_less_actual').hide();

        $(document).ready(function() {

            $('select[name="country"]').select2();

            var stripe = Stripe($('#stripe_publishable_key').val(), { stripeAccount: $('#connect_account_id').val()});
            var elements = stripe.elements();

            var baseStyles = {'fontFamily': 'Open sans, sans-serif','fontSize': '14px','color': '#fff','lineHeight': '31px'};
            var invalidStyles = {'color': '#fc064c'};

            var eCardNumber = elements.create('cardNumber', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
            var eCardCvc = elements.create('cardCvc', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
            var eCardExpiry = elements.create('cardExpiry', {'style': {'base': baseStyles, 'invalid': invalidStyles}});

            if($('#m_e_card_number').length){
                eCardNumber.mount('#m_e_card_number');
            }
            if($('#m_e_card_cvc').length){
                eCardCvc.mount('#m_e_card_cvc');
            }
            if($('#m_e_card_expiry').length){
                eCardExpiry.mount('#m_e_card_expiry');
            }

            if($('#monies_submit').length){
                var formButton = document.getElementById('monies_submit');
                formButton.addEventListener('click', function(event){
                    event.preventDefault();
                    validatePaymentForm(stripe, eCardNumber);
                });

            }

            var browserWidth = $( window ).width();

            if(window.autoShare && window.autoShare == 'facebook_url'){

                $('#facebook_share_url').trigger('click');
            }
            if(window.autoShare && window.autoShare == 'twitter_url'){

                $('#twitter_share_url').trigger('click');
            }

            if( browserWidth <= 767 ){
                $('.ch_left_sec_outer').replaceWith('<section class="ch_left_sec_outer">' + $('.ch_left_sec_outer').html() +'</section>');
                $('.tab_btns_outer').appendTo('.ch_left_sec_outer');
                $('.tab_det_left_sec').closest('main').appendTo('.ch_left_sec_outer');
                $('.ch_left_sec_outer').appendTo('#ch_left_sec_outer_filler');
                $('.user_bonuses_outer').appendTo('#user_bonuses_filler');
                $('.donator_outer').parent().appendTo('#donator_outer_filler');
                $('#monies_form').appendTo('#project_checkout_filler');
            }

            $('.to_bonuses').click(function(){

                $('html,body').animate({
                    scrollTop: $(".user_bonus_header").offset().top - 50
                }, 1500);
            });

            $('.crowdfund_cart_outer #crowdfund_cart_checkout').on("click", function(e){
                $('.hrd_cart_outer').toggleClass('active');
                $('body').toggleClass('lock_page');
                $('#body-overlay').toggle();

                $('html,body').animate({
                    scrollTop: $("#monies_form").offset().top
                }, 1000);
            });

            $('#email,#email_confirmation').focusout(function(){

                var email = $(this).val();
                var emaill = $('#email').val();
                $('#email_error').addClass('instant_hide');
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                if(email != '' && email == emaill && regex.test(email)){
                    $.ajax({

                        url: "/informationFinder",
                        dataType: "json",
                        type: 'post',
                        data: {'find_type': 'email_duplication_truth', 'find': email, 'identity_type': 'guest_register', 'identity': ''},
                        success: function(response) {
                            if(response.success == 1){
                                if(response.data.duplicated == 1){
                                    $('#email_error').text('This email is already registered').removeClass('instant_hide');
                                }
                            }else{

                            }
                        }
                    });
                }else{
                    $('#email_error').text('Email or email confirmation is invalid').removeClass('instant_hide');
                }
            });

            $('#password').focusout(function(){

                var password = $(this).val();
                $('#password_error').addClass('instant_hide');

                if(password != '' && password.length < 6){
                    $('#password_error').text('Password must be atleast of 6 characters').removeClass('instant_hide');
                }else if(password == ''){
                    $('#password_error').text('Password is required').removeClass('instant_hide');
                }
            });


            $('.tot_usd_sec').change(function() {

                var from = $('#temp_selected_currency').val();
                var to = $(this).val();
                $('#temp_selected_currency').val($(this).val());

                updateCrowdfundBasket('switch', 'currency', to);
            });


            $('.add_bonus_btn').click(function (e) {

                e.preventDefault();
                var thiss = $(this);
                var perkId =  thiss.attr('data-perkid');

                if(thiss.hasClass('proj_add_sec')){

                    updateCrowdfundBasket('add', 'bonus', perkId);
                    if(window.ajaxResponse){

                        if(window.ajaxResponse.success == 1){
                            thiss.removeClass('proj_add_sec');
                            thiss.addClass('proj_add_sec_added');
                            thiss.find('.buy_remove_txt').text('Remove Bonus');
                            thiss.parent().removeClass('project_rit_btm_list').addClass('proj_rit_btm_list_gray');

                            crowdFundToast('Bonus', window.ajaxResponse.data.amount);
                        }else{
                            alert(window.ajaxResponse.error);
                        }
                    }

                }else if(!thiss.hasClass('perk_sold_out')){
                    // bonus is being removed
                    updateCrowdfundBasket('remove', 'bonus', perkId);
                    if(window.ajaxResponse){

                        if(window.ajaxResponse.success == 1){
                            thiss.addClass('proj_add_sec');
                            thiss.removeClass('proj_add_sec_added');
                            thiss.find('.buy_remove_txt').text('Add Bonus');
                            thiss.parent().addClass('project_rit_btm_list').removeClass('proj_rit_btm_list_gray');
                        }else{
                            alert(window.ajaxResponse.error);
                        }
                    }
                }
            });

            $('#crowd_funder_toast #crowd_checkout').click(function(){
                $('html,body').animate({
                    scrollTop: $("#monies_form").offset().top
                }, 1000);
                $('#crowd_funder_toast').slideUp('slow');
            });

            $('#crowd_funder_toast #undo').click(function(){

                if(window.ajaxResponse && window.ajaxResponse.success == 1){

                    if(window.ajaxResponse.data.type == 'bonus' && window.ajaxResponse.data.action == 'add'){

                        $('.proj_rit_btm_list_gray#perk_list_'+window.ajaxResponse.data.value+' .add_bonus_btn').trigger('click');
                    }else if(window.ajaxResponse.data.type == 'donation' && window.ajaxResponse.data.action == 'add'){

                        $('.donator_outer.donation_goal.donation_agree .donation_right_in').trigger('click');
                    }
                    $('#crowd_funder_toast').slideUp('slow');
                }
            });

            $('body').delegate('#project-payment-popup #project_final_submit:not(.disabled)', 'click', function(e){

                $(this).addClass('disabled');
                initiatePayment(stripe, eCardNumber);
            });

            $('body').on( "click", ".each_user_video", function(e) {
                $('#soundcloudPlayer, .mejs__container').removeClass('instant_hide');
                $('.content_outer').addClass('playing');
            });
            $('body').on( "click", ".tab_btn_play_project,.tp_sec_play_project,.top_info_outer", function(e) {
                $('.mejs__container').removeClass('instant_hide');
                $('.content_outer').addClass('playing');
            });

            var mobileBonusPaginate = 2;

            if($('.mobile-only .project_rit_btm_list').length > mobileBonusPaginate){

                $('.mobile-only .show_more_bonuses_btn').show();
            }else{

                $('.mobile-only .show_more_bonuses_btn').hide();
            }

            $('.mobile-only .project_rit_btm_list').hide().slice(0, mobileBonusPaginate).show();

            $('.show_more_bonuses_btn input').on('click', function (e) {

                e.preventDefault();
                $('.mobile-only .project_rit_btm_list:hidden').slice(0, 1).slideDown( "slow", function() {

                    $('html,body').animate({
                        scrollTop: $(".mobile-only .project_rit_btm_list").last().offset().top - 100
                    }, 200);
                });
                if ($('.mobile-only .project_rit_btm_list:hidden').length == 0) {
                    $('.show_more_bonuses_btn input').fadeOut('slow');
                }
            });

        });

        function validatePaymentForm(stripe, eCardNumber){

            var success = true;
            var number = $("#number").val();
            $('#added_bonuses').val('');
            $('#added_donation').val(0);

            $('.field_err').removeClass('field_err');
            $('.proj_cont_err_fie').addClass('instant_hide');

            var email = $('#email').val();
            var confirmEmail = $('#email_confirmation').val();
            var password = $('#password').val();
            var name = $('#name').val();
            var surname = $('#surname').val();
            var address = $('#address').val();
            var city = $('#city').val();
            var country = $('#country').val();
            var zip = $('#zip').val();
            var cityError = $("#city_error");

            if(name == ''){

                $("#name").addClass('field_err');
                success = false;
            }
            if(surname == ''){

                $("#surname").addClass('field_err');
                success = false;
            }
            if(address == ''){

                $("#address").addClass('field_err');
                success = false;
            }
            if(city == '' || !cityError.hasClass('instant_hide')){

                $("#city").addClass('field_err');
                success = false;
            }
            if(zip == ''){

                $("#zip").addClass('field_err');
                success = false;
            }
            if(country == ''){

                $("#country").parent().addClass('field_err');
                success = false;
            }
            if($("#is_create_new_user").val() == "1"){

                if(email == ''){
                    $("#email").addClass('field_err');
                    success = false;
                }
                if(confirmEmail == ''){
                    $("#email_confirmation").addClass('field_err');
                    success = false;
                }
                if(password == ''){
                    $("#password").addClass('field_err');
                    success = false;
                }
                if(email != '' && confirmEmail != '' && email != confirmEmail){
                    $("#email").addClass('field_err');
                    $("#email_confirmation").addClass('field_err');
                    success = false;
                }
                if(email != '' && confirmEmail != '' && email == confirmEmail && !$('#email_error').hasClass('instant_hide')){
                    $("#email").addClass('field_err');
                    success = false;
                }
                if(password != '' && !$('#password_error').hasClass('instant_hide')){
                    $("#password").addClass('field_err');
                    success = false;
                }
            }

            if($('.proj_add_sec_added:not(.perk_sold_out):not(.proj_add_sec)').length == 0 && !$('.donation_goal').hasClass('donation_agree')){

                success = false;
            }

            if(!$('#checkout_terms_agree').is(':checked')) {

                $("#checkout_terms_agree").closest('li').addClass('error');
                success = false;
            }else{

                $("#checkout_terms_agree").closest('li').removeClass('error');
            }

            $('#project-payment-popup .project_go_ahead,.project_fill_form').addClass('instant_hide');
            loadMyDeferredImages($("#project-payment-popup img.prevent_pre_loading"));
            if(success == true){

                validateCardDetails(stripe, eCardNumber);
                return false;

            }else{
                $('#project-payment-popup .project_go_ahead').addClass('instant_hide');
                $('#project-payment-popup .project_fill_form').removeClass('instant_hide');
                $('#body-overlay,#project-payment-popup').show();
                return false;
            }

        }

        function validateCardDetails(stripe, eCardNumber){

            var cardName = $('#card_holder_name');
            if(cardName.val() != ''){

               stripe.createToken(eCardNumber).then(function(result){

                   $('#m_e_error').addClass('instant_hide');
                   if(result.error){
                       $('#m_e_error').removeClass('instant_hide').text(' ('+result.error.message+')');
                       $('#project-payment-popup .project_fill_form').removeClass('instant_hide');
                       $('#project-payment-popup .project_go_ahead').addClass('instant_hide');
                       $('#body-overlay,#project-payment-popup').show();
                   }else{
                       var token = result.token.id;
                       $.ajax({

                           url: "/informationFinder",
                           dataType: "json",
                           type: 'post',
                           data: {'find_type': 'stripe_card_expiration', 'find': token, 'identity_type': 'crowd_funder', 'identity': window.currentUserId},
                           success: function(response) {
                               if(response.success == 1){
                                    preparePaymentPopup();
                               }else{

                                   $('#m_e_error').removeClass('instant_hide').text(' (Your card should not expire before this project ends. Project end date: '+response.data.endDate+')');
                                   $('#project-payment-popup .project_fill_form').removeClass('instant_hide');
                                   $('#project-payment-popup .project_go_ahead').addClass('instant_hide');
                                   $('#body-overlay,#project-payment-popup').show();
                               }
                           }
                       });
                   }
               });
            }else{

                $('#m_e_error').removeClass('instant_hide').text(' (Card name is required)');
                $('#project-payment-popup .project_fill_form').removeClass('instant_hide');
                $('#project-payment-popup .project_go_ahead').addClass('instant_hide');
                $('#body-overlay,#project-payment-popup').show();
            }
        }

        function preparePaymentPopup(){

            if(!window.ajaxResponse){

                $.ajax({

                    url: "/postCrowdfundBasket",
                    dataType: "json",
                    type: 'post',
                    async: false,
                    data: {'type': 'refresh','action': '','value': '','currency': '', 'user': window.currentUserId},
                    success: function(response) {
                        window.ajaxResponse = response;
                    }
                });
            }

            var purchase = window.ajaxResponse;
            var selectedCountry = $("#country").val();
            var selectedCurrency = purchase.data.currency;
            var bonusString = (purchase.data.bonusCount>1) ? 'Bonuses' : 'Bonus';

            var currencySymbol = "$";
            if(selectedCurrency == "GBP"){ currencySymbol = "£"; }
            else if(selectedCurrency == "EUR"){ currencySymbol = "€"; }

            $('#project-payment-popup .project_fill_form').addClass('instant_hide');
            $('#project-payment-popup .project_go_ahead .instant_hide').removeClass('instant_hide');
            $('#project-payment-popup .purchase_total .summary_item_right').text(currencySymbol+purchase.data.grandTotal);
            $('#project-payment-popup .item_bonus .summary_item_right').text(currencySymbol+purchase.data.bonusTotal);
            $('#project-payment-popup .item_bonus .summary_item_left').text(bonusString+'('+purchase.data.bonusCount+')');
            $('#project-payment-popup .item_donation .summary_item_right').text(currencySymbol+purchase.data.donationTotal);

            if(parseFloat(purchase.data.bonusTotal) > 0){

                $.ajax({

                    url: "/informationFinder",
                    dataType: "json",
                    type: 'post',
                    data: {'find_type': 'crowdfund_shipping', 'find': 'total', 'identity_type': 'crowd_funder', 'identity': '', 'selected_country': selectedCountry, 'user' : window.currentUserId},
                    success: function(response) {
                        if(response.success == 1){
                            var shippingCost = parseFloat(response.data.shippingTotal);
                            if(shippingCost > 0){
                                var subTotal = parseFloat(purchase.data.grandTotal);
                                var grandTotal = subTotal + shippingCost;
                                $('#project-payment-popup .item_shipping .summary_item_right').text(currencySymbol+shippingCost);
                                $('#project-payment-popup .purchase_total .summary_item_right').text(currencySymbol+grandTotal);
                                $('#project-payment-popup .item_shipping').removeClass('instant_hide');
                            }else{
                                $('#project-payment-popup .item_shipping .summary_item_right').text('Free');
                            }
                        }
                    }
                });
            }else{

                $('#project-payment-popup .item_bonus,#project-payment-popup .item_shipping').addClass('instant_hide');
            }

            if(parseFloat(purchase.data.donationTotal) <= 0){

                $('#project-payment-popup .item_donation').addClass('instant_hide');
            }

            $('#project-payment-popup .project_go_ahead').removeClass('instant_hide');
            $('#body-overlay,#project-payment-popup').show();
        }

        function validateCardNumber(number) {

            var regex = new RegExp("^[0-9]{16}$");
            if (!regex.test(number))
            return false;
            return luhnCheck(number);
        }


        function crowdFundToast(type, amount){

            var message = type+' Added - '+'Amount: '+amount+' '+$('#selectedCurrency').val();

            $('#crowd_funder_toast').hide();
            $('#crowd_funder_toast').find('.message').html(message);
            $('#crowd_funder_toast').slideDown('slow');
        }

        function addCrowdFundDonation(){

            var donationAmount = $('.donator_outer.donation_goal #donation_amount').val();
            updateCrowdfundBasket('add', 'donation', donationAmount);
            if(window.ajaxResponse){

                if(window.ajaxResponse.success == 1){
                    $('.donator_outer.donation_goal').addClass('donation_agree');
                    $('.donation_right_in').text('Remove Donation');

                    crowdFundToast('Donation', window.ajaxResponse.data.amount);
                }else{
                    alert(window.ajaxResponse.error);
                }
            }
        }

        function removeCrowdFundDonation(){

            updateCrowdfundBasket('remove', 'donation', '');
            if(window.ajaxResponse){

                if(window.ajaxResponse.success == 1){
                    $('.donator_outer.donation_goal').removeClass('donation_agree');
                    $('.donation_right_in').text('Add Donation');
                    $('.donator_outer #donation_amount').val('');
                }else{
                    alert(window.ajaxResponse.error);
                }
            }
        }

        function luhnCheck(val) {

            var sum = 0;
            for (var i = 0; i < val.length; i++) {
                var intVal = parseInt(val.substr(i, 1));
                if (i % 2 == 0) {
                    intVal *= 2;
                    if (intVal > 9) {
                        intVal = 1 + (intVal % 10);
                    }
                }
                sum += intVal;
            }

            return (sum % 10) == 0;
        }

        function updateCrowdfundBasket(action, type, value){

            var selectedCurrency = $('#selectedCurrency').val();

            $.ajax({

                url: "/postCrowdfundBasket",
                dataType: "json",
                type: 'post',
                async: false,
                data: {'action': action, 'type': type, 'value': value, 'currency': selectedCurrency, 'user': window.currentUserId},
                success: function(response) {
                    window.ajaxResponse = response;
                    $('#total_cost').val((parseFloat(response.data.grandTotal)).toFixed(2));
                }
            });
        }


                function initiatePayment(stripe, eCardNumber){

                    var paymentData = {
                        userdata: $('#monies_form').serialize(),
                        type: 'crowdfund'
                    };

                    fetch('/prepare-payment',{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(paymentData)
                    })
                    .then(function(result){
                        return result.json();
                    })
                    .then(function(data){
                        var isCharity = window.ajaxResponse.data.isCharity;
                        if(isCharity){
                            payWithCard(stripe, eCardNumber, data.clientSecret);
                        }else{
                            setupFuturePayment(stripe, eCardNumber, data.clientSecret);
                        }
                    });
                }

                function setupFuturePayment(stripe, card, clientSecret){
                    stripe.confirmCardSetup(
                        clientSecret,
                        {
                          payment_method: {
                            card: card,
                            billing_details: {
                                name: $('#card_holder_name').val(),
                            },
                          },
                        }
                    ).then(function(result) {
                        if (result.error) {
                            $('#project_final_submit').removeClass('disabled');
                            $('#project-payment-popup,#body-overlay').hide();
                            alert(result.error.message);
                        }else{
                            var formData = new FormData();
                            formData.append('intent', result.setupIntent.id);
                            formData.append('userdata', $('#monies_form').serialize());
                            formData.append('type', 'crowdfund');
                            postPayment(formData);
                        }
                    });
                }

                function payWithCard(stripe, card, clientSecret){
                    stripe
                    .confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: card
                        }
                    })
                    .then(function(result){
                        if(result.error){
                            $('#project_final_submit').removeClass('disabled');
                            $('#m_e_error').text(result.error.message);
                            $('#fill_form_popup,#body-overlay').show();
                        }else{
                            var formData = new FormData();
                            formData.append('intent', result.paymentIntent.id);
                            formData.append('userdata', $('#monies_form').serialize());
                            formData.append('type', 'crowdfund');
                            postPayment(formData);
                        }
                    });
                }

                function postPayment(formData){

                    $.ajax({
                        url: '/post-payment',
                        type: 'POST',
                        data: formData,
                        contentType:false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            if(response.success){
                                window.location = response.url;
                            }else{
                                alert(response.error);
                                $('#project_final_submit').removeClass('disabled');
                            }
                        }
                    });
                }

    </script>

@stop



@section('preheader')

    @if($user->home_layout == 'banner' && $user->custom_banner != '')
        <div style="background: none; width: 100%;" class="pre_header_banner">
            <img style="width: 100%;" src="{{asset('user-media/banner/'.$user->custom_banner)}}">
        </div>
    @endif

@stop


@section('page-background')

    @if($user->home_layout == 'background')
        <div data-url="/user-media/background/{{$user->custom_background}}" class="pg_back back_inactive"></div>
    @endif

@stop


@section('header')

    @include('parts.header')

@stop


@section('flash-message-container')

    @if(Session::has('error') || Session::has('success'))
    <div class="p_msg_contain">

        @if(Session::has('error'))

            <div class="error_span">{!! Session::get('error')[0]  !!}</div>

        @endif

        @if(Session::has('success'))

            <div class="success_span">{{ Session::get('success')[0] }}</div>

        @endif

    </div>
    @endif
@stop

@section('social-media-html')

    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="project">

    @php
        $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
        $url = 'project_'.$user->id;
        $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
        $shareVideoURL = route('vid.share', ['videoId' => $defaultVideoId, 'userName' => $user->name, 'url' => $url]);
        $shareURL = route('url.share', ['userName' => $user->name, 'imageName' => base64_encode($userImageName), 'url' => $url]);
    @endphp

    <input type="hidden" id="video_share_id" value="{{$defaultVideoId}}">

    <input type="hidden" id="video_share_link" value="{{$shareVideoURL}}">

    <input type="hidden" id="video_share_title" value="{{$shareVideoTitle}}">


    <input type="hidden" id="url_share_user_name" value="{{$user->name}}">

    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

@stop



@section('audio-player')

    @include('parts.audio-player')

@stop


@section('top-center')

    <div class="ch_center_outer user_hm_center">
        <aside class="top_info_box hide_on_mobile">
            <div class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div>
        </aside>
        <div class="tp_center_video_outer">
            <div class="jp-gui">

                <video width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader {{$user->home_layout == 'background' && $defaultVideoId == '' ? 'instant_hide' : ''}}" preload="none">
                    <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />
                </video>
                <aside class="tab_btns_outer tab_dsk hide_on_mobile clearfix {{$user->home_layout == 'background' ? 'back_curvs' : ''}}">
                    <div class="each_tab_btn tab_btn_user_bio fly_user_home" data-show="" data-initials="{{$user->username}}">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_music {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd2">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_fans {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd3">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_social {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd4">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_crowd_fund true_active" data-show="#tabd1">
                        <div class="border_alter">
                            Target<br>
                            {{$userCampaignDetails['campaignGoal'] }}
                        </div>
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_video {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd5">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_tv" data-show="">
                        <div class="border"></div>
                    </div>
                </aside>
                <aside class="tab_btns_outer tab_shared mobile-only ch_tab_sec_outer project_tabs_mobile clearfix">

                    <div class="each_tab_btn tab_btn_user_bio fly_user_home" data-show="" data-initials="{{$user->username}}">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_music {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd2">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_fans {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd3">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_social {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd4">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_crowd_fund true_active" data-show="#tabd1">
                        <div class="border_alter">
                            Target<br>
                            {{$userCampaignDetails['campaignGoal'] }}
                        </div>
                    </div>
                    <div class="each_tab_btn tab_btn_video {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''}}" data-show="#tabd5">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_tv" data-show="">
                        <div class="border"></div>
                    </div>
                </aside>
                <main>
                    <section class="tab_det_left_sec tab_det_dsk tab_det_inner right_height_res @if($user->isCotyso()) expanded @endif">
                        <h1 class="page_title">
                            @if($user->profile->seo_h1)
                                {{$user->profile->seo_h1}}
                            @else
                                {{$user->name.' is a '.$userPersonalDetails['skills'].' from '.$userPersonalDetails['city']}}
                            @endif
                        </h1>
                        <aside style="display: none;" class="lazy_tab_img">
                            <img alt="loading" class="defer_loading" style="margin: 0 auto;" src="#" data-src="{{asset('img/lazy_loading.gif')}}">
                        </aside>
                        <article id="tabd1" class="ch_tab_det_sec bio_sec" style="display: block;">
                            <div id="new_story_text_section" style="color:#696772;font-size:18px;line-height:23px;font-family: Open Sans, sans-serif;">
                                <iframe onload="setIframeHeight(this.id)" scrolling="no" id="full-screen-me" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" frameborder="0" wmode="transparent" src="{{ route('user.story.text', ['id' => $userCampaign->id]) }}"></iframe>
                                <script type="text/javascript">
                                    function getDocHeight(doc) {
                                        doc = doc || document;
                                        var body = doc.body, html = doc.documentElement;
                                        var height = Math.max( body.scrollHeight, body.offsetHeight,
                                            html.clientHeight, html.scrollHeight, html.offsetHeight );
                                        return height;
                                    }
                                    function setIframeHeight(id) {
                                        var ifrm = document.getElementById(id);
                                        var doc = ifrm.contentDocument? ifrm.contentDocument: ifrm.contentWindow.document;
                                        ifrm.style.visibility = 'hidden';
                                        ifrm.style.height = "10px"; // reset to minimal height ...
                                        // IE opt. for bing/msn needs a bit added or scrollbar appears
                                        ifrm.style.height = getDocHeight( doc ) + 4 + "px";
                                        ifrm.style.visibility = 'visible';
                                    }
                                </script>
                                <div id="read_more_less_btns" style="display: none;">
                                    <div class="story_read_more_btn read_more_actual clearfix">
                                        <input type="button" value="Read More" />
                                    </div>
                                    <div class="story_read_more_btn read_less_actual clearfix">
                                        <input type="button" value="Read Less" />
                                    </div>
                                </div>
                            </div>
                            @if(!$loadCampaign)
                            <form id="monies_form" action="" method="post" style="padding-top: 20px;">
                                <div class="proj_cntr_contribut_sec_otr">
                                    <div class="proj_top_head_outer">
                                        <div class="proj_top_head_each">
                                            <h3 class="proj_top_head_text">
                                                You're contributing to {{ $user->name }}
                                            </h3>
                                        </div>
                                        <div id="proj_fb_share_url" class="proj_top_head_each" onclick="return facebookShare('url');">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                        <div id="proj_twit_share_url" class="proj_top_head_each" onclick="return twitterShare('url');">
                                            <i class="fab fa-twitter"></i>
                                        </div>
                                    </div>
                                    <ul>
                                        @if(!Auth::user())
                                            <input type="hidden" name="is_create_new_user" id="is_create_new_user" value="1">
                                            <li class="proj_create_new_account_outer">
                                                <div class="proj_create_new_account_inner clearfix">
                                                    <div class="proj_cont_left_inp_outer">
                                                        <b>To purchase create an account</b>
                                                    </div>
                                                    <!--<div class="proj_cont_right_inp_outer">

                                                        <b>
                                                            <a href="{{ asset('login/checkout_facebook?userId=' . $user->id) }}"><i class="fab fa-facebook-f"></i> Create an account with facebook</a>
                                                        </b>
                                                        <div class="hide_on_desktop" id="account_or_facebook">OR</div>

                                                    </div>!-->
                                                </div>
                                                <input class="dummy_field" type="text" name="email_9">
                                                <input class="dummy_field" type="password" name="password_0">
                                                <div class="proj_cont_flt_outer clearfix">
                                                    <div class="proj_email_outer clearfix" id="email_password_section">
                                                        <div class="proj_cont_left_inp_outer">
                                                            <b>Your Email *</b>
                                                            <input type="text" placeholder="Your Email" name="email" id="email" class="evade_auto_fill" />
                                                            <span id="email_error" class="instant_hide"></span>
                                                        </div>
                                                        <div class="proj_cont_right_inp_outer">
                                                            <b>
                                                                Confirm Your Email *
                                                            </b>
                                                            <input type="text" placeholder="Confirm Email" name="emailConfirmation" id="email_confirmation" class="evade_auto_fill" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="proj_cont_flt_outer proj_email_outer clearfix">
                                                    <div class="proj_cont_left_inp_outer">
                                                        <b>Password *</b>
                                                        <input type="Password" placeholder="Password" name="password" id="password" class="evade_auto_fill" />
                                                        <span id="password_error" class="instant_hide"></span>
                                                    </div>
                                                </div>
                                            </li>
                                        @else
                                            <input type="hidden" name="is_create_new_user" id="is_create_new_user" value="0">
                                        @endif
                                        <li class="proj_first_surname_outer add_margin">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div class="proj_cont_left_inp_outer">
                                                    <b>First Name *</b>
                                                    <input type="text" placeholder="First Name" name="name" id="name" value="{{$loggedUserDet?$loggedUserDet['first_name']:''}}" />
                                                </div>
                                                <div class="proj_cont_right_inp_outer">
                                                    <b>Surname *</b>
                                                    <input type="text" placeholder="Surname" name="surname" value="{{$loggedUserDet?$loggedUserDet['surname']:''}}" id="surname" />
                                                </div>
                                            </div>
                                            <label id="hide_show_details_check" class="proj_checkbox proj_checkbox_unchecked"> <input value="1" type="checkbox" name="make_me_private" id="make_me_private" /> Hide name/comment from everyone except organiser</label>
                                        </li>
                                        <li class="proj_address_outer add_margin">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div class="proj_cont_left_inp_outer">
                                                    <b>Please Enter Your Shipping Address *</b>
                                                    <input type="text" placeholder="Street Address" name="street" id="address" value="{{$loggedUserDet?$loggedUserDet['address']:''}}" />
                                                </div>
                                                <div id="country_drop_case" class="proj_cont_right_inp_outer">
                                                    <b>Choose your country *</b>
                                                    <input type="hidden" name="user_country" id="user_country" value="{{ $userPersonalDetails['countryId'] }}">
                                                    <select id="country" name="country">
                                                        <option value="">Choose your country</option>
                                                        @foreach($countries as $country)
                                                            <option {{$loggedUserDet&&$loggedUserDet['countryId']==$country->id?'selected':''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="proj_address_two_outer add_margin">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div class="proj_cont_left_inp_outer">
                                                    <input value="{{$loggedUserDet?$loggedUserDet['city']:''}}" type="text" placeholder="City *" name="city" id="city" />
                                                    <p id="city_error" class="instant_hide"></p>
                                                </div>
                                                <div class="proj_cont_right_inp_outer">
                                                    <input value="{{$loggedUserDet?$loggedUserDet['postcode']:''}}" type="text" placeholder="Postcode *" name="zip" id="zip" />
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <b>Credit Card Details * <span id="m_e_error" class="instant_hide"></span></b>
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div class="proj_cont_left_inp_outer">
                                                    <input type="text" placeholder="Name On Card" name="card_holder_name" id="card_holder_name"  />
                                                </div>
                                                <div id="m_e_card_number" class="proj_cont_right_inp_outer m_e_card_elem"></div>
                                            </div>
                                        </li>
                                        <li class="proj_credit_card_outer">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div id="m_e_card_cvc" class="proj_cont_left_inp_outer m_e_card_elem"></div>
                                                <div id="m_e_card_expiry" class="proj_cont_right_inp_outer m_e_card_elem"></div>
                                            </div>
                                        </li>
                                        <li class="proj_photo_textarea_outer">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div class="proj_cont_left_img_textarea">
                                                    <textarea placeholder="Leave A Comment" id="comment" name="comment"></textarea>
                                                </div>
                                            </div>
                                            <b class="faq_check_stat">If you have any questions about the projects you can check out our <a href="{{ asset("faq") }}">FAQ</a>.</b>
                                        </li>
                                        <li class="proj_total_amount_outer">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <div class="proj_cont_left_inp_outer tot_ship_left ">
                                                    <h4>TOTAL</h4>
                                                </div>
                                                <div class="proj_cont_right_inp_outer tot_usd_shiping">
                                                    <div class="proj_cont_right_inner clearfix">
                                                        <select class="tot_usd_sec" id="selectedCurrency" name="selectedCurrency">
                                                            @if($crowdfundCart['currency'] == 'USD')
                                                            <option value="USD">USD</option>
                                                            @elseif($crowdfundCart['currency'] == 'EUR')
                                                            <option value="EUR">EUR</option>
                                                            @elseif($crowdfundCart['currency'] == 'GBP')
                                                            <option value="GBP">GBP</option>
                                                            @endif
                                                        </select>
                                                        <input value="{{$crowdfundCart['subtotal']}}" class="tot_usd_val" type="text" placeholder="0.00" style="background: none !important;" name="totalCost" id="total_cost" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="proj_cont_flt_outer proj_bottom_description  clearfix">
                                            <p>
                                                If you are not paying in your native currency there may be fees for conversion. The actual amount charged by your card issuer may differ from our estimate shown here. This depends on their exchange rate and any applicable fees.
                                            </p>
                                        </li>
                                        <li class="proj_cont_flt_outer proj_bottom_description  clearfix">
                                            <p>
                                                I agree to 1Platform's <a target="_blank" href="{{route('tc')}}">terms and conditions</a>
                                                <span class="terms_agree_outer">
                                                    <input type="checkbox" class="terms_agree" name="terms_agree" id="checkout_terms_agree">
                                                </span>
                                            </p>
                                        </li>
                                        <li class="proj_confirm_payment_btn_outer">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <input id="monies_submit" type="button" value="Confirm Payment">
                                            </div>
                                        </li>
                                        <li class="proj_bottom_description">
                                            <div class="proj_cont_flt_outer clearfix">
                                                <p>
                                                    1Platform does not investigate projects. Project owners are responsible for their projects and ensuring that the project is complete and that all promises are kept. Please contact project owners if you have an issue. Your name, email will be visible to the seller. Shipping address will also be visible where applicable
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <input type="hidden" name="addedBonuses" id="added_bonuses" value="">
                                <input type="hidden" name="addedDonation" id="added_donation" value="0">
                                <input type="hidden" value="{{strtoupper($user->profile->default_currency)}}" id="temp_selected_currency">
                                <input type="hidden" value="{{strtoupper($user->profile->default_currency)}}" id="original_currency">
                                <input type="hidden" name="payment_method" id="payment_method" value="stripe">
                            </form>
                            @endif
                        </article>
                        <article id="tabd2" class="ch_tab_det_sec music_sec ">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd3" class="ch_tab_det_sec fans_sec ">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd4" class="ch_tab_det_sec social_sec ">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd5" class="ch_tab_det_sec">
                            <div class="lazy_tab_content"></div>
                        </article>
                    </section>
                </main>
            </div>
        </div>
        <div class="filler" id="ch_left_sec_outer_filler"></div>
        <div class="filler" id="donator_outer_filler"></div>
        <div class="filler" id="user_bonuses_filler"></div>
        <div class="filler" id="project_checkout_filler"></div>
    </div>

@stop

@section('top-right')
@stop

@section('top-left')

    <div class="ch_tab_sec_outer proj_sum_bonuses">

        <div class="panel main_panel colio_outer colio_dark">

            @if($user->home_layout != 'background')
            <div class="desktop-only panel_head">

                <h2 class="project_name">{{$userCampaignDetails['projectTitle']}}</h2>

            </div>
            @endif

            <div class="ch_bag_pric_sec bio_sec">

                <div class="fund_raise_left">

                    <img class="bio_sec_percent_image a_percent" src="{{$userCampaignDetails['campaignPercentImage']}}" alt="#" />
                    <div class="colio_header">My Crowdfunder</div>
                    <div class="fund_raise_status"></div>
                </div>

                <div class="fund_raise_right">

                    <div class="pricing_setail">

                        <ul>

                            <li class="fleft">

                                <h3 class="tier_one_text_one">
                                    {{$userCampaignDetails['campaignDonators']}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_four_text_one project_txt">
                                    {{ucfirst($userCampaignDetails['campaignStatus'])}}
                                </h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_one_text_two">Fans supported this</p>

                            </li>

                            <li class="fright">

                                <p class="tier_four_text_two">Project status</p>

                            </li>

                            <li class="fleft">

                                <h3 class="tier_two_text_one">
                                    {{$userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised']}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_three_text_one">
                                    {{$userCampaignDetails['campaignDaysLeft']}}
                                </h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_two_text_two">
                                    Raised of <text class="target_value">{{$userCampaignDetails['campaignGoal']}}</text> target
                                </p>

                            </li>

                            <li class="fright">

                                <p class="tier_three_text_two">Days left</p>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="social_btns desktop-only clearfix">

                <ul class="clearfix">

                    <li>
                        <a id="facebook_share_url" onclick="return facebookShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a id="twitter_share_url" onclick="return twitterShare('url')" class="ch_sup_tw" href="javascript:void(0)">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ch_sup_feature_tab full_support_me" href="{{route('user.home.tab', ['params' => $user->username, 'tab' => '2'])}}">
                            <i class="fas fa-music"></i>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

        @if($user->profile->stripe_secret_key != '' && $userCampaign->amount > 0 && ($userCampaignDetails['campaignUnsuccessful'] == false||$userCampaign->is_charity == 1))

        @if($crowdfundCart['donation'])
        @php $donationAdded = 1; @endphp
        @else
        @php $donationAdded = 0; @endphp
        @endif
        <div class="panel colio_outer colio_dark">
            <div class="donator_outer donation_goal {{$donationAdded?'donation_agree':''}}">
                <div class="donator_box clearfix">
                    <div class="colio_header">Donate to support {{$user->firstName()}}</div>
                    <p>Your donations help to meet my target goal</p>
                    <div class="donator_inner">
                        <div class="donation_left">
                            <span id="donation_currency">{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}</span>
                            <input @if($loadCampaign) readonly @endif type="text" id="donation_amount" name="donation_amount" class="{{$donationAdded?'':'evade_auto_fill'}}" value="{{$donationAdded?$crowdfundCart['donation']:''}}" />
                            <input class="dummy_field" type="text" name="fakeusernameremembered">
                        </div>
                        <div class="donation_right">
                            <div class="donation_right_in">
                                {{$donationAdded?'Remove Donation':'Add Donation'}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif

        <div class="user_bonuses_outer">
            @if($user->profile->stripe_secret_key != '')
                @foreach($userCampaign->perks as $perk)
                <div class="panel each_fro_bonus colio_outer colio_dark">
                    <div class="colio_header">Bonus</div>
                    <div class="project_rit_btm_bns_otr">
                        <?php $perkThumb = ""; ?>
                            @if($perk->thumbnail != "")
                                <?php $perkThumb = asset("user-bonus-thumbnails/" . $perk->thumbnail)?>
                            @endif
                            @if($loadCampaign)
                                <hr>
                                <div class="proj_rit_btm_list_gray">
                                    @if($perkThumb != "")
                                        <span class="project_rit_img">
                                            <img class="defer_loading" src="" data-src="{{ $perkThumb }}" alt="#" />
                                        </span>
                                    @endif
                                    <h4 style="background-image: none;">{{ $perk->title }}</h4>
                                    <p>{{ $perk->description }}</p>
                                    @if($perk->items_included != "")
                                        <ul>
                                            <li><p>Items Included</p></li>
                                            <?php $includedArray = explode(",", $perk->items_included); ?>
                                            @foreach($includedArray as $included)
                                                <li><p>{{ trim($included) }}</p></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <strong>{{ $perk->items_claimed }} out of {{ $perk->items_available }} sold</strong>
                                    <label class="proj_add_sec_added perk_sold_out" style="background: #4d4d4d;">Sold Out</label>
                                </div>
                            @elseif(($perk->items_available > $perk->items_claimed && $perk->status == "available" && $userCampaignDetails['campaignUnsuccessful'] == false && $userCampaign->amount > 0) || ($userCampaign->is_charity == 1 && $perk->items_available > $perk->items_claimed && $userCampaign->amount > 0) || ($perk->items_available == null && $userCampaignDetails['campaignUnsuccessful'] == false ) )

                                @if(in_array($perk->id, $crowdfundCart['bonuses']))
                                @php $bonusAdded = 1; @endphp
                                @else
                                @php $bonusAdded = 0; @endphp
                                @endif
                                <div class="{{$bonusAdded?'proj_rit_btm_list_gray':'project_rit_btm_list'}}" id="perk_list_{{ $perk->id }}">
                                    @if($perkThumb != "")
                                        <span class="project_rit_img">
                                            <img class="defer_loading" src="" data-src="{{ $perkThumb }}" alt="#" />
                                        </span>
                                    @endif
                                    <h4>{{ $perk->title }}</h4>
                                    <p>{{ $perk->description }}</p>
                                    @if($perk->items_included != "")
                                        <ul>
                                            <li><p>Items Included</p></li>
                                            <?php $includedArray = explode(",", $perk->items_included); ?>
                                            @foreach($includedArray as $included)
                                                <li><p>{{ trim($included) }}</p></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if($perk->items_available != NULL)
                                    <strong>{{ $perk->items_claimed }} out of {{ $perk->items_available }} sold</strong>
                                    @endif
                                    <label class="add_bonus_btn {{$bonusAdded?'proj_add_sec_added':'proj_add_sec'}}" data-perkid="{{ $perk->id }}">
                                        <text class="buy_remove_txt">{{$bonusAdded?'Remove Bonus':'Buy Bonus'}}</text>
                                        <b>{{$commonMethods::getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $perk->amount }}</b>
                                    </label>
                                </div>
                            @elseif($userCampaign->amount > 0)
                                <hr>
                                <div class="proj_rit_btm_list_gray">
                                    @if($perkThumb != "")
                                        <span class="project_rit_img">
                                            <img class="defer_loading" src="" data-src="{{ $perkThumb }}" alt="#" />
                                        </span>
                                    @endif
                                    <h4 style="background-image: none;">{{ $perk->title }}</h4>
                                    <p>{{ $perk->description }}</p>
                                    @if($perk->items_included != "")
                                        <ul>
                                            <li><p>Items Included to This Subscription</p></li>
                                            <?php $includedArray = explode(",", $perk->items_included); ?>
                                            @foreach($includedArray as $included)
                                                <li><p>{{ trim($included) }}</p></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <strong>{{ $perk->items_claimed }} out of {{ $perk->items_available }} sold</strong>
                                    <label class="proj_add_sec_added perk_sold_out" style="background: #4d4d4d;">Sold Out</label>
                                </div>
                            @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        var browserWidth = $( window ).width();
        if( browserWidth <= 767 ){
            $('.desktop-only,.hide_on_mobile').remove();
        }else{
            $('.mobile-only,.hide_on_desktop').remove();
        }
        if($('.vid_preloader').length && !$('.vid_preloader').hasClass('instant_hide')){

            $('.content_outer').addClass('playing');
        }
    </script>

@stop


@section('bottom-row-full-width')

@stop



@section('slide')



@stop



@section('miscellaneous-html')

    <div id="body-overlay"></div>
    @include('parts.chart-popups')

    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
    <input type="hidden" id="connect_account_id" value="{{$user->profile->stripe_user_id}}">
@stop
