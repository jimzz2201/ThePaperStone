
function display(view) {
    if (view == 'list') {
        $('.product-grid').attr('class', 'product-list');

        $('.product-list > div.product_holder > div.product_holder_inside').each(function (index, element) {

            html = '';
            if ($(element).children().hasClass("special_promo")) {
                html += '<div class="special_promo"></div>'
            }
            ;

            html += '<div class="right">';
            html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
            html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
            html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
            html += '</div>';

            html += '<div class="left">';

            var image = $(element).find('.image').html();

            if (image != null) {
                html += '<div class="image">' + image + '</div>';
            }

            var price = $(element).find('.price').html();

            if (price != null) {
                html += '<div class="price">' + price + '</div>';
            }

            html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
            html += '  <div class="description">' + $(element).find('.description').html() + '</div>';

            var rating = $(element).find('.rating').html();

            if (rating != null) {
                html += '<div class="rating">' + rating + '</div>';
            }

            html += '</div>';


            $(element).html(html);
        });

        $('.display').html('<b>Display:</b> &nbsp;&nbsp;<a onclick="display(\'list\');" class="list_view_link">List</a>   <a onclick="display(\'grid\');" class="grid_view_link_active">Grid</a>');

        $.totalStorage('display', 'list');
    } else {
        $('.product-list').attr('class', 'product-grid');

        $('.product-grid > div.product_holder > div.product_holder_inside').each(function (index, element) {
            html = '';

            var image = $(element).find('.image').html();

            if ($(element).children().hasClass("special_promo")) {
                html += '<div class="special_promo"></div>'
            }
            ;

            if (image != null) {
                html += '<div class="image">' + image + '</div>';
            }

            html += '<div class="name">' + $(element).find('.name').html() + '</div>';
            html += '<div class="description">' + $(element).find('.description').html() + '</div>';

            var price = $(element).find('.price').html();

            if (price != null) {
                html += '<div class="price">' + price + '</div>';
            }

            var rating = $(element).find('.rating').html();

            if (rating != null) {
                html += '<div class="rating">' + rating + '</div>';
            }

            html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
            html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
            html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';

            $(element).html(html);
        });

        $('.display').html('<b>Display:</b> &nbsp;&nbsp;<a onclick="display(\'list\');" class="list_view_link_active">List</a>   <a onclick="display(\'grid\');" class="grid_view_link">Grid</a>');

        $.totalStorage('display', 'grid');
    }
}

view = $.totalStorage('display');

if (view) {
    display(view);
} else {
    display('grid');
}