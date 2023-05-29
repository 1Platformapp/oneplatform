@extends('templates.singing-experience')

@section('pagetitle') Stag Party - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Stag parties are always a laugh - but with our stag parties you can have a laugh and be a rockstar for the day in a professional music studio near you. Record a rock song, 80's hit, or any song really - doesn't matter once you've had a drink and started lauging more than singing " />

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
		            <img alt="Bring yourself for an exciting stag party at any of the singing experience nationwide venues" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Stag Party Manchester Experience</h1>
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
		                		1 Song
		                	</li>
		                	<li class="li_bullet">
		                		E-voucher on purchase
		                	</li>
		                	<li class="li_bullet">
		                		Digital copies provided
		                	</li>
		                	<li class="li_bullet">
		                		Professional Recording Studios
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
		                Stag parties are always a laugh - but with our stag parties you can have a laugh and be a rockstar for the day in a professional music studio near you. Record a rock song, 80's hit, or any song really - doesn't matter once you've had a drink and started lauging more than singing 
		            </p><br>
		            <p class="item_desc_body">
		                During the day you will recieve; professional photographer to saver the moment, a group recording of any cover song out there, which will then be mixed and master for the party holder to take home that DAY!! We provide the very best hen parties with the biggest laughs and the most fun in the UK.
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