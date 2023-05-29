@extends('templates.singing-experience')

@section('pagetitle') Recording Packages For Bands - Recording Studio Manchester @endsection

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
		        <div class="item_thumb  user_product_img_thumb ">
		            <img alt="You can now record your band or reherse in our professional and well equipped studios" src="{{asset('images/singing/bands.jpg')}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Record Your Band or Reherse In Our Professional Studios</h1>
		            </div>
		        </div>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Introduction</h2>
		            <p class="item_desc_body">
		                Scroll down to check out our best packages we offer to bands
					</p><br>
		            <p class="item_desc_body">
		                Your band will receive a professional photo shoot, and will benefit from hands-on experience both in the recording studio and in the mixing booth. The finished track will be fully mastered and produced to the incredibly high standards that hit bands insist upon.
		            </p><br>
		            <p class="item_desc_body">
		                Our unbeatable Platinum deal allows bands an incredible 3 day recording experience to record and 2 days to perfect your songs which will then be digitally re-mixed by top world class engineers who've worked with some of the most famous bands in the world. With recording studios in Manchester, Liverpool, London and more.
		            </p>
		        </section>
		        @include('parts.item-singing-intro')
		    </div>
		</div>
	</main>
	@php $products = \App\Models\UserProduct::whereIn('id', [188,189,190,198])->get() @endphp
	@include('parts.item-related-products', ['products' => $products])
@endsection

@section('footer')

	@include('parts.singing-footer')

@endsection