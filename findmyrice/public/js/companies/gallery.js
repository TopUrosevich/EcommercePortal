(function($) {
    var $images_box = $('#images_box');
    $images_box.imagesLoaded( function(){
        $images_box.masonry({
            itemSelector : '.box',
            /*gutterWidth: 25,*/
            columnWidth: 5,
            isAnimated: true
        });
    });
})(jQuery);