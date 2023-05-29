@extends('templates.singing-experience')

@section('pagetitle') Record a Simple Video - Fully Edited - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="With our skilled videographers, using our high end camera equipment and the much sort after studio space, the our music video shoots are very popular with our new upcoming artist who want to be seen without having to spend the big budgets." />

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
		            <img alt="Record a simple video with 1 song and fully edited" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Record a Simple Video - 1 Song Fully Edited</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		2 hr session
		                	</li>
		                	<li class="li_bullet">
		                		1 Simple Video - 1 song
		                	</li>
		                	<li class="li_bullet">
		                		Receive a digital copy
		                	</li>
		                	<li class="li_bullet">
		                		Fully edited video
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
		                With our skilled videographers, using our high end camera equipment and the much sort after studio space, the our music video shoots are very popular with our new upcoming artist who want to be seen without having to spend the big budgets.
		            </p><br>
		            <p class="item_desc_body">
		                These are ideal for the YouTube world and give you that special edge whether for fun or for your promo. The studio space has hosted many big acts, including BBC, and this really is the best deal for sure.
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