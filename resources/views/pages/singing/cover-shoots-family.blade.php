@extends('templates.singing-experience')

@section('pagetitle') Cover Shoot For Families (Coming Soon) - Recording Studio Manchester @endsection

@section('pagedescription')
	
	<meta name="description" content="Give your family an experience they’ll treasure – a Winter Wonderland themed famil photo shoot session from Singing Experience" />

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
		            <img alt="Singing experience offers cover shoots for families (coming soon)" src="{{asset('images/singing/covershoots.jpg')}}">
		        </div>
		    </div>
		    <div class="item_bottom tot_awe_pro_right">
		        <div class="item_info_box">
		            <div class="item_title">
		                <h1>Cover Shoot For Families (Coming Soon)</h1>
		            </div>
		        </div>
		        <section class="item_desc_each item_desc_expandable">
		            <h2 class="item_desc_head">Introduction</h2>
		            <p class="item_desc_body">
		                Give your family an experience they’ll treasure – a Winter Wonderland themed famil photo shoot session from Singing Experience.
		            </p>
		            <p class="item_desc_body">
                        If you love Winter/Christmas and all things festive, then you will love this. Grab your Christmas jumpers and head over to the same studio where the likes of One Direction have had a shoot. With a pro photographer on hand to make you look picture perfect, you can pose for some magical shots.
		            </p>
		        </section>
		        <section class="item_desc_each">
		            <h2 class="item_desc_head">Singing Experience - A professional recording studio</h2>
		            <div class="item_desc_body">
		                <p>
		                    Get ready for the greatest singing experience ever! A full day out for the professional recording studios in Manchester recording your very own pop star CD!
		                </p><br>
		                <p>
		                    The famous Cotyso Recording Studios in Manchester are opening their doors to members of the public so that you and your friends can perform in the very same studios that hosted your idols perhaps just hours before!
		                </p><br>
		                <p>
		                    Whether you want a recording studio gift experience or are searching for an unusual birthday gift idea, our experienced and professional recording engineers will help you choose the perfect gift package. Our Manchester recording studios make the perfect birthday venues for anyone, no matter how old or young - no singing ability required
		                </p><br>
		                <p>
		                    Spend time chosing your backing track before entering our studios then get the chance to record a number of takes with our sound engineers. Once you have recorded a perfect track and you are happy with it, our team will lead you to the professional photography suite to capture that ideal cover shot. You get to take away a copy of your CD there and then! Choose a cover shot you prefer and you will be sent a digitally enhanced master copy of your CD to treasure. (CD cover photo is optional extra)
		                </p><br>
		                <p>
		                    If you are a struggling band or singer our expertise can help set you on the right track and give a professionally mixed demo CD to keep. Get a taste of what it's like to perform in a real studio that many iconic bands before you have used. Soak up the atmosphere for some creative inspiration. As a gift experience it beats all other hands down!
		                </p>
		            </div>
		        </section>
		        @include('parts.item-singing-intro')
		    </div>
		</div>
	</main>
@endsection

@section('footer')

	@include('parts.singing-footer')

@endsection