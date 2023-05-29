
@if($page == 'chart')

@php $partnerImage = 'partner_img'; @endphp

@elseif($page == 'tv')

@php $partnerImage = 'partner_img'; @endphp

@elseif($page == 'live')

@php $partnerImage = 'partner_img'; @endphp

@elseif($page == 'search')

@php $partnerImage = 'partner_img'; @endphp

@endif

<!--<div id="joe.prior" class="panel card_chart_winner">

    <div class="user_hm_rt_btm_otr">

        <label class="side_nav_head_top">Latest Chart Winner</label>

        <div class="trig_click clearfix">
            <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/chart_winner_pic.jpg') }}">
            <img class="defer_loading card_foreground" src="" data-src="{{ asset('/images/'.$partnerImage.'.png') }}">
            <div class="position_badge">1#</div>
        </div>
        <label class="side_nav_head_bottom">Joe Prior - Love Will Tear Us Apart</label>
    </div>
</div>!-->

<!--
@if($page !== 'chart')
<div id="double_card_chart" class="panel double_card">

    <div class="user_hm_rt_btm_otr">

        <label class="side_nav_head_top">Audition Chart</label>

        <div class="trig_click clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('/images/double_card_chart.png') }}">
        </div>
        <label class="side_nav_head_bottom">
            The Audition chart lets you compete you with musicians and singers across the whole platform.
        </label>
        <img class="defer_loading card_foreground" src="" data-src="{{ asset('/images/'.$partnerImage.'.png') }}">
    </div>
</div>
@endif
@if($page !== 'tv')
<div id="double_card_tv" class="panel double_card">

    <div class="user_hm_rt_btm_otr">
        <label class="side_nav_head_top">The Audition TV</label>

        <div class="trig_click clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('/images/double_card_tv.png') }}">
        </div>
        <label class="side_nav_head_bottom">
            Checkout the latest content from <br>The Audition TV. With interviews, with artists and live performances.
        </label>
        <img class="defer_loading card_foreground" src="" data-src="{{ asset('/images/'.$partnerImage.'.png') }}">
    </div>
</div>
@endif

@if($page !== 'search')
<div id="double_card_license" class="panel double_card">

    <div class="user_hm_rt_btm_otr">

        <label class="side_nav_head_top">Audition Licensing</label>

        <div class="trig_click clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('/images/double_card_license.png') }}">
        </div>
        <label class="side_nav_head_bottom">
            Sell licenses, stems and loops of your music so they can be used on TV, Web, radio, film and many other projects and productions.
        </label>
        <img class="defer_loading card_foreground" src="" data-src="{{ asset('/images/'.$partnerImage.'.png') }}">
    </div>
</div>
@endif

<div id="double_card_crowdfund" class="panel double_card">

    <div class="user_hm_rt_btm_otr">

        <label class="side_nav_head_top">Audition Crowdfunding</label>

        <div class="trig_click clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('/images/double_card_crowdfund.png') }}">
        </div>
        <label class="side_nav_head_bottom">
            <div class="bottom_info_head">&pound;210</div>
            <div class="bottom_info_body">Raise of &pound;300k Target</div>
            Start a fundraiser on the Audition.
        </label>
        <img class="defer_loading card_foreground" src="" data-src="{{ asset('/images/'.$partnerImage.'.png') }}">
    </div>
</div>
@if($page !== 'live')
<div id="double_card_studio" class="panel double_card">

    <div class="user_hm_rt_btm_otr">

        <label class="side_nav_head_top">Audition Experts</label>

        <div class="trig_click clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('/images/double_card_studio.png') }}">
        </div>
        <label class="side_nav_head_bottom">
            The Audition is a platform used by professional musicians, singers, experts and music producers worldwide.
        </label>
        <img class="defer_loading card_foreground" src="" data-src="{{ asset('/images/'.$partnerImage.'.png') }}">
    </div>
</div>
@endif

!-->