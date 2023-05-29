@extends('templates.singing-experience')

@section('pagetitle') Record Songs With Your Own Lyrics and Vocals - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Singing Experience - your local recording studio near you - is now taking bookings for studio time. For artists, musicians and singers that just want to record their own song. It may be vocals, recording a instrument or mixing and mastering a track. Book studio time in a professional music studio near you" />

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
		            <img alt="Record a song in our studios with your own lyrics and vocals" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Record a Song in our Studios With Your Own Lyrics and Vocals</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		2 hr Studio session
		                	</li>
		                	<li class="li_bullet">
		                		1 original song
		                	</li>
		                	<li class="li_bullet">
		                		E-voucher on purchase
		                	</li>
		                	<li class="li_bullet">
		                		Digital copies provided
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
		                Singing Experience - your local recording studio near you - is now taking bookings for studio time. For artists, musicians and singers that just want to record their own song. It may be vocals, recording a instrument or mixing and mastering a track. Book studio time in a professional music studio near you. 
		            </p><br>
		            <p class="item_desc_body">
		            	For longer sessions please contact our team for help.
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