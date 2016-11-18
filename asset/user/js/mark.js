

function resizeSlideshow() {

    if ($(window).width() < 768) {
        var newHeight = 400 / 960 * $('.nivoSlider').height();
        $('.nivoSlider').height(newHeight);
    }
    else {
        $('.nivoSlider').height(400);
    }

}