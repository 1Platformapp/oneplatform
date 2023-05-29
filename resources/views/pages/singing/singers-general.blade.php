@extends('templates.singing-experience')

@section('pagetitle') Recording Packages For Singers - Singing Experience @endsection

@section('pagedescription')
	
	<meta name="description" content="Get ready for the greatest singing experience ever! A full day out in professional recording studios in Manchester recording your very own pop star CD!" />

@endsection

@section('page-level-css')
@endsection

@section('page-level-js')

	<script type="text/javascript">
	    

	</script>

@endsection

@section('page-content')
	
	<aside>
	    <div data-url="{{$user->custom_background ? '/user-media/background/'.$user->custom_background : $userProfileImage}}" class="page_background"></div>

	    <div class="back_link">
	    	<a href="https://www.singingexperience.co.uk">Back to {{$user->firstName()}}'s home</a>
	    </div>
	</aside>

	<main class="item_container" role="main">

		<div class="item_container tot_awe_pro_outer">
		    <div class="item_top  tot_awe_pro_left ">
		        <div class="item_thumb user_product_img_thumb ">
		            <img alt="Singing experience offers for singers in manchester and across the UK" src="{{asset('images/singing/singers.jpg')}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>What Singing Experience Offers to Singers</h1>
		            </div>
		        </div>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Introduction</h2>
		            <p class="item_desc_body">
		                Scroll down to check out our best packages for singing experience
					</p><br>
		            <p class="item_desc_body">
		                Get ready for the greatest singing experience ever! A full day out in professional recording studios in Manchester recording your very own pop star CD! 
					</p><br>
					<p class="item_desc_body">
                        Whether you want a recording studio gift experience or are searching for an unusual birthday gift idea, our experienced and professional recording engineers will help you choose the perfect gift package. With locations like our Manchester recording studio avaliable, no matter how old or young – no singing ability required!
					</p><br>
					<p class="item_desc_body">
                        Spend time choosing your backing track before entering our studios, then get the chance to record a number of takes with our Sound Engineers. Once you've recorded the perfect track and you're happy with it, our team will lead you to the professional photography suite to capture that ideal cover shot. You get to take away a copy of your CD there and then! Choose the cover shot you prefer and you'll be sent a digitally enhanced master copy of your CD to treasure. (cd cover photo is optional extra)
					</p><br>
					<p class="item_desc_body">
                        If you are a struggling band or singer, our expertise can help set you on the right track and give you a professionally mixed demo CD to keep. Get a taste of what it's like to perform in a real studio. Soak up the atmosphere for some creative inspiration. As a gift experience it beats all others hands down!
		            </p>
		        </section>
		        @include('parts.item-singing-intro')
		    </div>
		</div>
	</main>
	@php $products = \App\Models\UserProduct::whereIn('id', [179,281,300,299])->get() @endphp
	@include('parts.item-related-products', ['products' => $products])
@endsection

@section('footer')

	@include('parts.singing-footer')

@endsection