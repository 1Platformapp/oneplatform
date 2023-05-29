@extends('templates.singing-experience')

@section('pagetitle') Professional Packages For Musicians - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="We welcome everyone of any age and with any talent to come along and be transformed into a superstar! From beginners to experts, our friendly manner and professional studios will make this a memorable birthday experience no matter who you are" />

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
		            <img alt="Singing experience offers for musicians and music composers" src="{{asset('images/singing/musicians.jpg')}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>What Singing Experience Offers to Musicians</h1>
		            </div>
		        </div>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Introduction</h2>
		            <p class="item_desc_body">
		                Scroll down to check out our best packages we offer to musicians
					</p><br>
		            <p class="item_desc_body">
		                Get ready for the greatest singing experience ever! A full day out in professional recording studios in Manchester recording your very own pop star CD!
					</p><br>
					<p class="item_desc_body">
                        Most young people dream of singing in a music studio! Imagine them getting the full star treatment and recording their very own hit single! And just imagine how popular you would be after delivering such an amazing gift.
                    </p><br>
                    <p class="item_desc_body">
                        So if you have a loved one, young or old, who fancies themselves as the next “big thing”, whether that's as a rapper, guitarist, pianist, bass player, drummer or singer, this would make the perfect gift! Take their musical talent out of the bedroom and into the studio for a day they will never forget!
					</p><br>
					<p class="item_desc_body">
                        Our skilled engineers will put them at their ease, provide refreshments for them and any friends or family who have decided to show their support and will help to make them sound great.
					</p><br>
					<p class="item_desc_body">
                        We welcome everyone of any age and with any talent to come along and be transformed into a superstar! From beginners to experts, our friendly manner and professional studios will make this a memorable birthday experience no matter who you are!
		            </p>
		        </section>
		        @include('parts.item-singing-intro')
		    </div>
		</div>
	</main>
	@php $products = \App\Models\UserProduct::whereIn('id', [280,186,187,304])->get() @endphp
	@include('parts.item-related-products', ['products' => $products])
@endsection

@section('footer')

	@include('parts.singing-footer')

@endsection