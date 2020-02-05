// Детальная информация о заказе
$(document).on('click', '.order__detail a', function(event) {

    event.preventDefault();

    var order_id = $(this).attr('order-id');
    $.ajax({
        url: '/account/order/get-order-info?order_id=' + order_id,
        type: 'post',
        data: {},
        success: function (html) {

            $("body").append('<div class="main-overlay"></div>');
            $(".main-overlay").click(function(event) {
                closeOrderDetail();
            });

            $('#order-detail-container').html(html);
            $('.order-detail[order-id="' + order_id + '"]').show();
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });





    /*
    $("body").append('<div class="main-overlay"></div>');
    $(".main-overlay").click(function(event) {
        closeOrderDetail();
    });

    // $('.reservation-drop--1').find('.reservation-drop__content').html(html);
    $('.order-detail').show();
    */
});

$(document).on('click', '.order-detail__topline-close', function () {

    console.log('trololo');
    closeOrderDetail();

});

function closeOrderDetail() {

    // $('.reservation-drop--1').find('.reservation-drop__content').html('');
    $('.order-detail').hide();
    $(".main-overlay").remove();
}

// отмена заказа
$(document).on('click', '.cancel-order', function () {

    //var order_id = $(this).parents('.reservation').attr('order-id');
    var access_code = $(this).parents('.reservation').attr('access-code');

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

// $(document).on('click', '.edit-order', function() {
//
//     var access_code = $(this).parents('.reservation').attr('access-code');
//
//     location.href = '/site/create-order?c=' + access_code;
// });