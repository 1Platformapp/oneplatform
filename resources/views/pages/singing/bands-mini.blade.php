@extends('templates.singing-experience')

@section('pagetitle') Mini Recording Package For Bands - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Bands! We welcome you come along to a recording studio near you to. Enjoy your first recording experience or your 100th! You can work in a profesional music studio, with and engineer ready to help you record your own song" />

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
		            <img alt="We welcome all bands to record their songs or reherse for 3 hr (Bands Mini Package)" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Bands Recording at Professional Studios with All Instruments (Bands Mini Package)</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		3 hr studio session
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
		                Bands! We welcome you come along to a recording studio near you to. Enjoy your first recording experience or your 100th! You can work in a profesional music studio, with and engineer ready to help you record your own song.
		            </p><br>
		            <p class="item_desc_body">
		                If you are looking to record a song this is perfect, for larger projects we recommend some of our longer studio sessions. If you are unsure get in touch with our team - we can help with recording studio inquiries and bespoke projects!
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