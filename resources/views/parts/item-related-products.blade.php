
    <section class="related_products">
    	<h2>You May Also Like</h2>
	    <div class="related_product_contain">
	    	@foreach($products as $product)
	    	<div class="related_product_each">
	    		<aside class="related_product_top">
	    			@if($product->thumbnail !='')
	    			<img alt="{{$product->title}}" class="defer_loading" src="" data-src="{{$commonMethods::getUserProductThumbnail($product->id)}}" />
	    			@endif
	    		</aside>
	    		<section class="related_product_bot">
	    			<h3 class="related_product_title">{{str_limit($product->title, 35)}}</h3>
	    			<p class="related_product_description">
	    				{!! nl2br($product->description) !!}
	    			</p>
	    			@if($product->includes != '')
	    			    @php $includes = explode(",", $product->includes) @endphp
	    			    <ul class="related_product_points">
	    			        @foreach($includes as $include)
                            @if($include != '')
	    			        <li class="li_bullet">{{ trim($include) }}</li>
                            @endif
	    			        @endforeach
	    			    </ul>
	    			@endif
	    			<a title="{{$product->title}}" class="related_product_view" href="{{route('item.share.product', ['itemSlug' => $product->slug])}}">More Info</a>
	    		</section>
	    	</div>
	    	@endforeach
	    </div>
    </section>