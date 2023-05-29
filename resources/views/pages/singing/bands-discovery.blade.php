@extends('templates.singing-experience')

@section('pagetitle') Recording Package For Bands - Recording Studio Manchester  @endsection

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
		            <img alt="We welcome all bands to record their songs or reherse for 10 hr (Band Discovery Package)" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Bands Recording at Professional Studios with All Instruments (Band Discovery Package)</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		10 hr studio session
		                	</li>
		                	<li class="li_bullet">
		                		Various instruments
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
		                Discovery package makes a great gift experience or cool taster session for bands who want to record their own music and covers. Discover how the professionals mix and master your sound to perfection and get a digital copy on the day to take home and share with friends and family. No other company offers you the chance to perform in professional working studios alongside specialist engineers and producers!
		            </p>
		            <p class="item_desc_body">
		            	Music studios nationwide are ready to work with your band 
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