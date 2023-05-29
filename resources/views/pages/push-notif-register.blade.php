<!doctype html>

<html lang="en">

	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Push Notification Registration</title>
	    <style>
	    	main { position: relative; }
	    	.overlay { height: 100%; width: 100%; position: fixed; top: 0; left: 0; background: #000; opacity: 0.75; z-index: 5; }
	    	.wait { z-index: 11; display: flex; align-items: center; flex-direction: column; font-size: 18px; font-family: sans-serif; justify-content: center; height: 100%; width: 100%; position: fixed; }
	    	.text { margin-top: 10px; color: #fff; }
	    	.wait img { width: 80px; }
	    	.back { background-image: url(https://www.1platform.tv/images/license_back_2.jpg); height: 100%; top: 0; position: fixed; left: 0; width: 100%; background-size: cover; background-position: top center; background-repeat: no-repeat; }
		</style>
		<script type="text/javascript">
			setTimeout(() => {
				window.location.href = '{{$redirectUrl}}';
			}, 8000)
		</script>
	</head>

	<body>

		<div class="back"></div>
		<main>

			<div class="overlay"></div>
			<div class="wait">

				<img src="{{asset('images/wait.gif')}}" />
				<div class="text">Please wait ...</div>
			</div>
		</main>
	</body>
</html>





