$(document).ready(function() {

    var owl = $("#owl-demo");
    if(owl.length){

        var maxSlidesOne = $('#owl_content').attr('data-max-slides');
        var maxSlidesTwo = maxSlidesOne;
        if(typeof maxSlidesOne === typeof undefined || maxSlidesOne === false || maxSlidesOne == 0){

            var maxSlidesOne = 4;
            var maxSlidesTwo = 5;
        }
        maxSlidesOne = parseInt(maxSlidesOne);
        maxSlidesTwo = parseInt(maxSlidesTwo);
        owl.owlCarousel({
            itemsCustom : [
                [0, 1],
                [450, 1],
                [600, 2],
                [767, 3],
                [700, 3],
                [1000, maxSlidesOne],
                [1200, maxSlidesOne],
                [1400, maxSlidesTwo],
                [1600, maxSlidesTwo],
            ],
            navigation : true,
            pagination : false,
            autoPlay: 6000,
            slideSpeed : 1000,

        });
    }
});