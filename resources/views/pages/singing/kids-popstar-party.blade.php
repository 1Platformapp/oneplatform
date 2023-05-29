@extends('templates.singing-experience')

@section('pagetitle') Kids Popstar Party - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Recording parties for singers, all ages welcome. For those looking for a recording studio experience near you. This makes a perfect and unique gift. Not only do you get to sing in a professional music studio, you can do it with friends and family" />

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

		<div class="item_container  tot_awe_pro_outer  ">
		    <div class="item_top  tot_awe_pro_left ">
		        <div class="item_thumb  user_product_img_thumb ">
		            <img alt="Bring your kids for an exciting pop start party at any of the singing experience nationwide venues" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Kids Popstar Party Experience</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		2 Hour studio experience
		                	</li>
		                	<li class="li_bullet">
		                		Mixed and Mastered CD & Professional CD Cover Photo Shoot
		                	</li>
		                	<li class="li_bullet">
		                		Purchase party food (extra when you book)
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
		                Recording parties for singers, all ages welcome. For those looking for a recording studio experience near you. This makes a perfect and unique gift. Not only do you get to sing in a professional music studio, you can do it with friends and family. 
		            </p><br>
		            <p class="item_desc_body">
		                Bring along those close to you can have fun rocking, rolling and singing to your hearts content! Favourite songs from the past and pop tracks from the present.
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