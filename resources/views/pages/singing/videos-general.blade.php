@extends('templates.singing-experience')

@section('pagetitle') Record Professional Video - Half Day - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Wanting a music video shoot for a good price, we have you covered. Rappers, bands, singers and musicians. All are welcome for this music video shoot - from quick music videos to a full production ready to rock and roll. Following the latest trends in camera and editing to keep your video fresh and up to date." />

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
		            <img alt="Record a fully professional video (Half Day)" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Record a Fully Professional Video (Half Day)</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		4 hr session
		                	</li>
		                	<li class="li_bullet">
		                		1 professionally recorded Video - 1 song
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
		                Wanting a music video shoot for a good price, we have you covered. Rappers, bands, singers and musicians. All are welcome for this music video shoot - from quick music videos to a full production ready to rock and roll. Following the latest trends in camera and editing to keep your video fresh and up to date.
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