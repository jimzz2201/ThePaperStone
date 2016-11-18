// Push the top links away from Cart
function positionHeaderLinks() {
    var cart_header_w = $('#cart-total').width();
    if (cart_header_w >= 124) {
        $('#header_links').css('right', (cart_header_w + 78) + 'px');
    }
}

// Bind the possible Add to Cart btns with event to position top links
$(document).ready(function () {

    // Menu Animation
    $('#menu ul li').hover(
            function () {
                $(this).addClass("active");
                $(this).find('div').stop(false, true).slideDown(200);
            },
            function () {
                $(this).removeClass("active");
                $(this).find('div').stop(false, true).slideUp(100);
            }
    );

    positionHeaderLinks();

    $('.cart a').bind('click', function () {
        positionHeaderLinks();
    });
    $('.cart .sm_button').bind('click', function () {
        positionHeaderLinks();
    });
    $('.cart .button').bind('click', function () {
        positionHeaderLinks();
    });




    /* Override the Ajax Cart */

    $('#cart > .heading a').die('click');
    $('#cart').die('mouseleave');



    $('#cart > .heading a').live('click', function () {

        $('#header #cart .content').slideDown(400);
        $('#cart').addClass('active');

        $('#cart').live('mouseleave', function () {
            $('#header #cart .content').slideUp(200, function () {
                $(this).removeClass('active');
            });
        });
    });


    // Fading products	
    $('#content .product_holder').hover(
            function () {
                if (typeof (fading_effects) != "undefined" && fading_effects) {
                    $(this).siblings().find('img').stop().fadeTo(150, 0.6);
                }
            },
            function () {
                if (typeof (fading_effects) != "undefined" && fading_effects) {
                    $(this).siblings().find('img').stop().fadeTo(150, 1);
                }
            }
    );

    $('.jcarousel-item').hover(
            function () {
                if (typeof (fading_effects) != "undefined" && fading_effects) {
                    $(this).siblings().find('img').stop().fadeTo(300, 0.5);
                }
            },
            function () {
                if (typeof (fading_effects) != "undefined" && fading_effects) {
                    $(this).siblings().find('img').stop().fadeTo(300, 1);
                }
            }
    );


});




