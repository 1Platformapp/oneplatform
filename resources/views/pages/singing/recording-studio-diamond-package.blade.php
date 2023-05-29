@extends('templates.singing-experience')

@section('pagetitle') Recording Studios - Diamond Plus Package - Singing Experience @endsection

@section('pagedescription')
	
	<meta name="description" content="The Diamond Plus lets you choose 3 songs to perform from any of the 1000s of backing tracks available from The Beatles to Beyonce! You will also enjoy a professional photoshoot in our studios - get the whole family involved!" />

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
		    <div class="item_top tot_awe_pro_left ">
		        <div class="item_thumb user_product_img_thumb">
		            <img alt="Singing Experience brings diamond plus singing package to record 3 songs in 2 hr studio session" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Singing Experience's Recording Package - Diamond Plus Singing Package </h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		2 hr studio session
		                	</li>
		                	<li class="li_bullet">
		                		3 songs
		                	</li>
		                	<li class="li_bullet">
		                		Professional Studios
		                	</li>
		                	<li class="li_bullet">
		                		Receive a digital copy
		                	</li>
		                	<li class="li_bullet">
		                		E-voucher on purchase
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
		                The Diamond Plus lets you choose 3 songs to perform from any of the 1000s of backing tracks available from The Beatles to Beyonce! You will also enjoy a professional photoshoot in our studios - get the whole family involved!
		            </p><br>
		            <p class="item_desc_body">
		                Our engineers will use specialist technology to create the perfect vocal arrangement, giving you that star "diamond experience".
		            </p><br>
		            <p class="item_desc_body">
		            	Record your 3 songs in a music studio near you! For birthdays - gifts and more.
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