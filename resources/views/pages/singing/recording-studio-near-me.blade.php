@extends('templates.singing-experience')

@section('pagetitle') Recording Studios - Platinum Package - Singing Experience @endsection

@section('pagedescription')
	
	<meta name="description" content="The Platinum Plus is for someone who is keen to cover as much of their singing catalog as possible. With high quality recording, making this the perfect package. We tailor the day accordingly, whether a serious artist or for Fun, recorded in the Uk's leading studio" />

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
		            <img alt="Singing Experience brings platinum singing package to record 5 songs in 5 hr studio session" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Singing Experience Recording package - Platinum Singing Package</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		5 hr studio session
		                	</li>
		                	<li class="li_bullet">
		                		5 songs
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
		                The Platinum Plus is for someone who is keen to cover as much of their singing catalog as possible. With high quality recording, making this the perfect package. We tailor the day accordingly, whether a serious artist or for Fun, recorded in the Uk's leading studio.
		            </p><br>
		            <p class="item_desc_body">
		                This Experience covers 5 songs recorded to backing tracks, using the best vocal parts of each song to make that perfect fun or demo! 
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