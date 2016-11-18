function messageerror(message)
{
    $('html, body').animate({scrollTop: $('#notification').offset().top}, 'slow');
    $("#notification").empty();
    $("#notification").append("<div class=\"warning\">" + message + "<img src=\"" + baseurl + "asset/user/image/close.png\" alt=\"\" class=\"close\"></div>");
}
function messagesuccess(message)
{
    $('html, body').animate({scrollTop: $('#notification').offset().top}, 'slow');
    $("#notification").empty();
    $("#notification").append("<div class=\"success\">" + message + "<img src=\"" + baseurl + "asset/user/image/close.png\" alt=\"\" class=\"close\"></div>");
}
function RefreshCart()
{
    $.ajax({
        type: 'POST',
        url: baseurl + 'index.php/cart/GetTopCart',
        success: function (data) {
            $("#cart").html(data);
        },
        error: function (xhr, status, error) {
            messageerror(xhr.responseText);
        }
    });
    return false;
}
function modaldialog(message)
{
    $("#modaldesc").html(message);
    $('[data-remodal-id = mymodal]').remodal().open();
}
function display(jenis)
{
    if (jenis == "list")
    {
        $(".product-grid").addClass("product-list");
        $(".product-grid").removeClass("product-grid");
    }
    else
    {
        $(".product-list").addClass("product-grid");
        $(".product-list").removeClass("product-list");
    }
}



function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57) && charCode != 45)
        return false;

    return true;
}
$(document).ready(function () {

    $(".checkout-heading").click(function () {
        var content = $(this).parent().find('.checkout-content');
        $(".checkout-content").css("display", "none");
        if (content.css("display") == "none")
        {
            content.css("display", "block");
        }
        else
        {
            content.css("display", "none");
        }

    })

})

var LoadBar = {
    show: function () {
        $(".loadbar").removeClass("hide");
    },
    hide: function ()
    {
        $(".loadbar").addClass("hide");
    }

}

function AnimationShow(id, type)
{
    var currentheight = 0;
    var toheight = 0;
    if (type == 'full')
    {

        $(id).css('height', 'auto');
        toheight = $(id).height();

    }
    else
    {
        $(id).css('height', 'auto');
        currentheight = $(id).height();
    }

    $(id).height(0).animate(
            {
                height: toheight
            }, 1000
            , function () {
                if (type == 'full')
                {
                    $(id).css("height", "");
                  //  $('html, body').animate({scrollTop: $(id).position().top - 100}, 'slow');

                }
            }
    );

}
function RefreshDropDownCountry(from, tujuan, value)
{
    $.ajax(
            {
                url: baseurl + "/index.php/user/getState",
                data:
                        {
                            id_country: $(from).val()
                        },
                dataType: "json",
                type: "post",
                success: function (data)
                {
                    $(tujuan).empty();
                    var subcat = $('<option />');
                    subcat.val(0);
                    subcat.text(' --- Please Select --- ');
                    $(tujuan).append(subcat);
                    $.each(data, function (index, value) {
                        subcat = $('<option />');
                        subcat.val(value.kode);
                        subcat.text(value.name);
                        $(tujuan).append(subcat);

                    });
                    if (value != 0)
                    {
                        $(tujuan).val(value);
                    }
                    if (!$(tujuan + " option:selected").length) {
                        $(tujuan).val(0);
                    }
                },
                error: function (xhr, status, error)
                {

                    messageerror(xhr.responseText);
                }
            });
}
function CleanTulisan(text)
{
    return text.replace(/<(?:.|\n)*?>/gm, '');
}
