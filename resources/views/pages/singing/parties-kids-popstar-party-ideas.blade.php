@extends('templates.singing-experience')

@section('pagetitle') Kids Popstar Party - Special Package - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Our professional recording engineers can cater for absolutely any age group so if you are struggling for party ideas in Manchester, Liverpool, Birmingham and more, then let us give you a helping hand and provide them with an unforgettable party that beats yet another Indoor Bowling session hands-down! So don't just give them a gift this year, give them an experience to treasure forever!" />

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
		        <div class="item_thumb user_product_img_thumb ">
		            <img alt="Singing experience has nation wide studios for parties" src="{{asset('images/singing/kids_popstar_party.jpg')}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Singing Experience Special Offer - Kids Popstar Party (Coming Soon)</h1>
		            </div>
		        </div>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Product Description</h2>
		            <p class="item_desc_body">
		                The ultimate gift for singers - out recording studio experiences offer one of the ultimate party experiences. Give your children, work collages or wedding parties the day to remember, that gift experience that will truly blow them away along with a unique and personal souvenir that they will treasure forever. Here at the Cotyso Experience, we can provide an unforgettable adventure that will both delight and thrill!
		            </p><br>
		            <p class="item_desc_body">
		                Male or female, old or young, all they need to enjoy the experience of a lifetime is a good sense of fun and a whole lot of character! They don't even need to have a great singing voice!
		            </p><br>
		            <p class="item_desc_body">
		                Or if you are looking for birthday party ideas then why not throw a singing party with a difference? Get a whole group of people together to a fun recording session – a great party idea, which is guaranteed to have plenty of laughs, entertainment and thrills! It really doesn't matter what singing ability they have, once they get stuck in they'll be belting out the hits and surprising themselves!
		            </p><br>
		            <p class="item_desc_body">
		                Our professional recording engineers can cater for absolutely any age group so if you are struggling for party ideas in Manchester, Liverpool, Birmingham and more, then let us give you a helping hand and provide them with an unforgettable party that beats yet another Indoor Bowling session hands-down!

		                So don't just give them a gift this year, give them an experience to treasure forever!
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