@extends('templates.singing-experience')

@section('pagetitle') Professional Cover Shoot - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Now it is your time, to have a photo shoot in a professional photography studio. One of our experienced professional photographers will get you to relax whilst they set about using their creative skills to produce the ideal portrait for you" />

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
		        <div class="item_thumb  user_product_img_thumb ">
		            <img alt="Get yourself ready for a professional cover shoot with multiple photos" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Cover Shoot - Professionally Executed</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		Multiple photos
		                	</li>
		                	<li class="li_bullet">
		                		Use on any package
		                	</li>
		                	<li class="li_bullet">
		                		Receive a digital copy
		                	</li>
		                </ul>
		            </div>
		        </section>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">Purchase</h2>
		            <div class="item_desc_body">
		                <div class="item_add_to_cart">
		                    <a class="item_cart_btn clearfix" href="{{route('item.share.product', ['itemSlug' => $product->slug])}}">
		                        Buy this product
		                    </a>
		                </div>
		            </div>
		        </section>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Product Description</h2>
		            <p class="item_desc_body">
		                Now it is your time, to have a photo shoot in a professional photography studio. One of our experienced professional photographers will get you to relax whilst they set about using their creative skills to produce the ideal portrait for you. Here you can benefit from some excellent artistic direction, use any props available and even voice your own ideas about how you want the final shot to be. You'll get a real taste of celebrity stardom!
		            </p>
		            <p class="item_desc_body">
		                As a gift experience it beats all others hands down! Don't just get them any old high street voucher when you can get them a recording studio gift voucher that makes superstar memories for an experience that is out of this world!
		            </p>
		        </section>
		        @include('parts.item-singing-intro')
		    </div>
		</div>
	</main>
@endsection

@section('footer')

	@include('parts.singing-footer')

@endsection