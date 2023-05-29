
<div class="user_products_outer" id="products_div2">


@php $userStoreAlbums = \App\Models\UserAlbum::where(['user_id' => $user->id, 'is_product' => '1'])->get() @endphp

@if(count($userStoreAlbums))
	<h2 class="tabd2_head">My Albums</h3>
	@foreach($userStoreAlbums as $userStoreAlbum)
	    @include('parts.user-channel-album-store-template', ['album' => $userStoreAlbum])
	@endforeach
@endif

<h2 class="tabd2_head">My Products</h3>
@foreach($user->products as $userProduct)
    @include('parts.user-channel-product-template', ['product' => $userProduct])
@endforeach

</div>