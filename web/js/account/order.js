
$(document).on('click', '#order-list-page .cancel-order', function() {

    var order_id = $(this).attr('order-id');

    if(confirm("Вы уверены что хотите отменить заказ?")) {
        $.ajax({
            url: '/account/order/ajax-cancel-order?id=' + order_id,
            type: 'post',
            data: {},
            success: function (response) {
                if (response.success === true) {
                    location.reload();
                } else {
                    alert('Ошибка отмены заказа');
                }
            },
            error: function (data, textStatus, jqXHR) {
                if (textStatus === 'error' && data !== undefined) {
                    if (void 0 !== data.responseJSON) {
                        if (data.responseJSON.message.length > 0) {
                            alert(data.responseJSON.message);
                        }
                    } else {
                        if (data.responseText.length > 0) {
                            alert(data.responseText);
                        }
                    }
                } else {
                    //handlingAjaxError(data, textStatus, jqXHR);
                }
            }
        });
    }

    return false;
});


$(document).on('click', '.cancel-not-ready-order', function() {

    var access_code = $(this).attr('access-code');

    if(confirm("Вы уверены что хотите отменить заказ?")) {
        $.ajax({
            url: '/account/order/ajax-cancel-order?c=' + access_code,
            type: 'post',
            data: {},
            success: function (response) {
                if (response.success === true) {
                    location.reload();
                } else {
                    alert('Ошибка отмены заказа');
                }
            },
            error: function (data, textStatus, jqXHR) {
                if (textStatus === 'error' && data !== undefined) {
                    if (void 0 !== data.responseJSON) {
                        if (data.responseJSON.message.length > 0) {
                            alert(data.responseJSON.message);
                        }
                    } else {
                        if (data.responseText.length > 0) {
                            alert(data.responseText);
                        }
                    }
                } else {
                    //handlingAjaxError(data, textStatus, jqXHR);
                }
            }
        });
    }

    return false;
});