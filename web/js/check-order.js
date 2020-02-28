
/*
$(document).on('click', '.make-simple-payment-checkorderpage', function() {

    // var client_ext_id = $('#order-client-form').attr('client-ext-id');
    var access_code = $(this).attr('access_code');

    $.ajax({
        url: '/site/ajax-save-but-checkout?c=' + access_code + '&type_button=payment',
        type: 'post',
        data: {},
        success: function (response) {

            $.ajax({
                url: '/yandex-payment/payment/ajax-make-simple-payment?c=' + access_code + '&source_page=check-order',
                type: 'post',
                data: {},
                success: function (response) {
                    if (response.success === true) {
                        //alert(response.redirect_url);
                        location.href = response.redirect_url;
                    }else {
                        alert(response);
                    }
                },
                error: function (data, textStatus, jqXHR) {
                    if (textStatus == 'error' && data != undefined) {
                        if (void 0 !== data.responseJSON) {
                            if (data.responseJSON.message.length > 0) {
                                alert(data.responseJSON.message);
                            }
                        } else {
                            if (data.responseText.length > 0) {
                                alert(data.responseText);
                            }
                        }
                    }else {
                        //handlingAjaxError(data, textStatus, jqXHR);
                    }
                }
            });


        },
        error: function (data, textStatus, jqXHR) {
            if (textStatus == 'error' && data != undefined) {
                if (void 0 !== data.responseJSON) {
                    if (data.responseJSON.message.length > 0) {
                        alert(data.responseJSON.message);
                    }
                } else {
                    if (data.responseText.length > 0) {
                        alert(data.responseText);
                    }
                }
            }else {
                //handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});

*/

var t;
function upScreen() {

    var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
    if(top > 0) {
        window.scrollBy(0,-40);
        t = setTimeout('upScreen()',20);
    } else {
        $('.header__login').click();
        setTimeout(function() {
            if($('#inputphoneform-mobile_phone').is(':visible')) {
                $('#inputphoneform-mobile_phone').focus();
            }
            if($('.mobile-burger').is(':visible')) {
                //$('.mobile-burger .burger').click();
                $('.modal_global__login[data-izimodal-open="#enter-mobile"]').click();
            }
        }, 500);
        clearTimeout(t);
    }

    return false;
}

$(document).on('submit', '.reservation-form', function() {
    return false;
});