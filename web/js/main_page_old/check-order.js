

$(document).on('click', '#make-simple-payment-checkorderpage', function() {

    var client_ext_id = $('#order-client-form').attr('client-ext-id');

    $.ajax({
        url: '/site/ajax-save-but-checkout?client_ext_id=' + client_ext_id + '&type_button=payment',
        type: 'post',
        data: {},
        success: function (response) {


            $.ajax({
                url: '/yandex-payment/payment/ajax-make-simple-payment?client_ext_id=' + client_ext_id + '&source_page=check-order',
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


$(document).on('click', '#but_reservation', function() {

    var client_ext_id = $('#order-client-form').attr('client-ext-id');

    $.ajax({
        url: '/site/ajax-save-but-checkout?client_ext_id=' + client_ext_id + '&type_button=reservation',
        type: 'post',
        data: {},
        success: function (response) {

            if (response.success === true) {
                $('#order-client-form').submit();
            }else {
                if(response.action == 'need_auth') {
                    openLoginForm(client_ext_id);
                }
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

    return false;
});