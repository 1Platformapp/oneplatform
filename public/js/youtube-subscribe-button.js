

function fillSocialTabWithYoutubeSubscribeButton(){

	var container = document.getElementById('yt-button-container-render');
	if(container){
		var options = {
			'channelId': container.getAttribute('data-channelid'),
		    'layout': 'full'
		};
		gapi.ytsubscribe.render(container, options);
	}
}