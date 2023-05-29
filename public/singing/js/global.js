
$('document').ready(function(){

    var browserWidth = $( window ).width();

    var back = $('.page_background').attr('data-url');
    $('.page_background').css('background-image', 'url('+back+')');

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});


function loadDeferredTasks() {
    
    var browserWidth = $( window ).width();
    var stylesheetDefer = $('link.switchmediaall');
    for (var i=0; i<stylesheetDefer.length; i++) {
        stylesheetDefer[i].setAttribute('media','all'); 
    } 
    var imgDefer = $('img.defer_loading');
    for (var i=0; i<imgDefer.length; i++) {
        if(imgDefer[i].getAttribute('data-src')) {
            imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
        } 
    }
    var backgroundLength = $('.back_inactive').length;
    if(backgroundLength){

        $('.back_inactive').each(function(){
            $(this).css('background-image', 'url(' + $(this).attr('data-url') + ')');
            $(this).removeClass('back_inactive').addClass('active');
        });
    }

    if( browserWidth > 767 ){

    
    } 
}

document.addEventListener("DOMContentLoaded", function(event) {

    setTimeout(function(){

        loadDeferredTasks();
    }, 3000);
    
});