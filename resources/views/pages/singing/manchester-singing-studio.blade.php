@extends('templates.singing-experience')

@section('pagetitle') Produce Song - Mix and Master - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Aiming to release your next single? Get a song onto spotify, itunes, amazon and more. Our music studios can help. Create a song, shoot a music video and create some album artwork. Everything you need to release a song online" />

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
		            <img alt="We can help you produce a track for your song and finish with a mix and master" src="{{$commonMethods::getUserProductThumbnail($product->id)}}">
		        </div>
		    </div>
		    <div class="item_bottom  tot_awe_pro_right ">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Produce Song & Finish With Mix and Master at Our Professional Recording and Singing Studios</h1>
		            </div>
		        </div>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">This product includes</h2>
		            <div class="item_desc_body">
		                <ul class="main_prod_list">
		                	<li class="li_bullet">
		                		Studio recording session
		                	</li>
		                	<li class="li_bullet">
		                		Professional Music Video
		                	</li>
		                	<li class="li_bullet">
		                		Release artwork
		                	</li>
		                	<li class="li_bullet">
		                		Track Mix and Mastering
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
		                Aiming to release your next single? Get a song onto spotify, itunes, amazon and more. Our music studios can help. Create a song, shoot a music video and create some album artwork. Everything you need to release a song online.
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