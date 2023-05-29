@extends('templates.singing-experience')

@section('pagetitle') Recording Studio Manchester - Singing Experience @endsection

@section('pagedescription')
	
	<meta name="description" content="With studios based nationwide you can be guaranteed to be able to send a day at a recording studio near you. Perfect gifts for singers of all ages and ablities. Studio time is available for musicians and bands of all shapes and sizes. Record a cover song, original song " />

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
		            <img alt="Singing experience has nation wide studios for recording songs and production" src="{{asset('images/singing/recording-studios.jpg')}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Singing Experience Recording Studios</h1>
		            </div>
		        </div>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Introduction</h2>
		            <p class="item_desc_body">
		                With studios based nationwide you can be guaranteed to be able to send a day at a recording studio near you. Perfect gifts for singers of all ages and ablities. Studio time is available for musicians and bands of all shapes and sizes. Record a cover song, original song 
		            </p>
		        </section>
		        @include('parts.item-singing-intro')
		    </div>
		</div>
	</main>

	@php $products = \App\Models\UserProduct::whereIn('id', [179,180,181,280])->get() @endphp
	@include('parts.item-related-products', ['products' => $products])
@endsection

@section('footer')

	@include('parts.singing-footer')

@endsection