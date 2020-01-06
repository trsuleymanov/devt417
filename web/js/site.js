function is_mobile() {

    if( $(document).width() > 992 ){
        return false;
    } else {
        return true;
    }

}


function clearAndHideRegForms() {

    $('#modal_enter_password').html();
    $('#modal_restorepassword').html();
    $('#modal_confirm_phone').html();
    $('#modal_entersmscode').html();
    $('#modal_registration').html();
    $('.for_enter_wrap').hide();
}

function clearAndHideMobileRegForms() {

    $.each( $('.iziModal') , function(index, modal) {
        // console.log('q index='+index+' modal:'); console.log(modal);
        if( $(modal).data().iziModal !== undefined ){
            // console.log('найден iziModal!:'); console.log(modal);
            var state = $(modal).iziModal('getState');
            if(state == 'opened' || state == 'opening'){
                console.log('закрываем iziModal: '); console.log(modal);
                $(modal).iziModal('close');
            }
        }else {
            //console.log('закрываем id=' + $(this).attr('id'));
            var id = $(this).attr('id');
            console.log(id);
            if(id == 'enter_password-mobile' || id == 'restorepassword-mobile' || id == 'confirm_phone-mobile' || id == 'entersmscode-mobile' || id == 'registration-mobile') {
                console.log('очищаем id='+$(this).attr('id'));
                $(this).html('').fadeOut(100);
            }
        }

        //$(modal).close();
        // $(modal).iziModal('close');
    });

    // $('#enter_password-mobile').html();
    // $('#restorepassword-mobile').html();
    // $('#entersmscode-mobile').html();
    // $('#registration-mobile').html();
    // $('.mobile_menu').hide();
}


// скрипт https://github.com/pratik916/jQuery-Hide-Show-Event для отслеживания событий отображения/скрытия элемента
"use strict";
((typeof jQuery === "function") && !((function($,w){
    $.fn.extend({
        hideShow : function(callback) {
            this.checkForVisiblilityChange(callback);
            return this;
        },

        checkForVisiblilityChange : function(callback) {

            if(!(this.length >>>0 ))
                return undefined;

            var elem,i=0;

            while ( ( elem = this[ i++ ] ) ) {
                var curValue = $(elem).is(":visible");

                (elem.lastVisibility === undefined) && (elem.lastVisibility = curValue);

                (curValue !== elem.lastVisibility) && (

                    elem.lastVisibility = curValue,

                    (typeof callback === "function") && (
                        callback.apply(this, [new jQuery.Event('visibilityChanged'), curValue ? "shown" : "hidden"])
                    ),
                        (function(elem, curValue, w){
                            w.setTimeout(function(){
                                $(elem).trigger('visibilityChanged',[curValue ? "shown" : "hidden"])
                            },10)
                        })(elem, curValue, w)
                )
            }

            (function(that, a, w){
                w.setTimeout(function(){
                    that.checkForVisiblilityChange.apply(that,a);
                },10)
            })(this, arguments, w)
        }
    })
})(jQuery, window))) || console.error("hideShow plugin requires jQuery")


var placeholder = '<span class="sw-placeholder">Выбрать точку</span>';
$(document).on('change', '#direction', function() {
    //selectWidgetInsertValue($('input[name="ClientExt[yandex_point_from]"]').parents('.sw-element'), 0, "");
    //$('.sw-element[attribute-name="ClientExt[yandex_point_from]"] .sw-value').html(placeholder);

    $('.sw-element[attribute-name="ClientExt[yandex_point_from_id]"]').find('.sw-delete').click();
    setTimeout(function() {
        $('.sw-element[attribute-name="ClientExt[yandex_point_from_id]"] .sw-value').html(placeholder);
    }, 300);
});

/*
$(document).on('click', '.sw-element[attribute-name="ClientExt[yandex_point_from]"] .sw-delete', function()
{
    // вначале срабатывает стандартная функция js удаления значения, а потом текущий функция
    setTimeout(function() {
        $('.sw-element[attribute-name="ClientExt[yandex_point_from]"] .sw-value').html(placeholder);
    }, 300);

    return false;
});
*/



$(document).ready(function() {

    // $.datepicker.setDefaults($.datepicker.regional["ru"]);
    // $('#date').datepicker({
    //     // onSelect: function(dateText, inst) {
    //     //     location.href = '/?date='+dateText;
    //     // }
    // });

    $('#search-form-date').datepicker({
        dateFormat: 'dd-mm-yy'
    });

    //var obj_date = new Date();
    //var day = obj_date.getDay();
    //var month = obj_date.getMonth() + 1;
    //var date = (day < 10 ? '0' + day : day) + '-' + (month < 10 ? '0' + month : month) + '-' + obj_date.getFullYear();
    ////alert('date='+date);
    //
    //var hours = obj_date.getHours()
    //if(hours <= 15) {
    //    //$('#search-form-date').datepicker("setDate",'2018-10-04');
    //    $('#search-form-date').val('Сегодня');
    //}else {
    //    //$('#search-form-date').datepicker("setDate",'2018-10-07');
    //    $('#search-form-date').val('Завтра');
    //}

    // отлавливаем события появления/скрытия датапикера и правим положение
    //$(".ui-datepicker").hideShow(function(e, visibility){
    //    if(visibility == 'shown') {
    //        var left = parseFloat($(this).css('left')) - 16;
    //        $(this).css('left', left);
    //    }
    //});

    $('.cookie-trigger').click(function() {
        $.cookie('use-cookie', true, { expires: 365, path: '/' });
        $('#use-cookie').remove();
    });

    $('#date span').click(function() {
        $('#search-form-date').focus().click();

        return false;
    });


    $('#direction-switcher').click(function() {
        var from = $('#point-from input').val();
        var to = $('#point-to input').val();
        $('#point-from input').val(to);
        $('#point-to input').val(from);

        return false;
    });


    $(document).on('click', function() {
        $('.field-error').hide();

        if($('#search-form').attr('is-submitted') == true) {
            animateSearchForm(false);
        }
    });


    $('#search-form').submit(function() {

        //alert('submit');
        var has_errors = false;

        var from = $('#point-from input').val();
        var to = $('#point-to input').val();
        if(
            (from == 'Альметьевск' && to == 'Казань')
            || (from == 'Казань' && to == 'Альметьевск')
        ) {

        }else { // есть ошибка в названиях
            if(from != 'Альметьевск' && from != 'Казань') {
                $('#point-from .field-error').text('Уточните пункт отправки').show();
                //console.log('Уточните пункт отправки');
                has_errors = true;
            }
            if(to != 'Альметьевск' && to != 'Казань') {
                $('#point-to .field-error').text('Уточните пункт назначения').show();
                //console.log('Уточните пункт назначения');
                has_errors = true;
            }
        }

        var obj_date = new Date();
        var day = obj_date.getDay();
        var month = obj_date.getMonth() + 1;
        var today_date = (day < 10 ? '0' + day : day) + '-' + (month < 10 ? '0' + month : month) + '-' + obj_date.getFullYear();

        var obj_today = obj_date.setDate(obj_date.getDate() + 1); // завтра
        var day = obj_date.getDay();
        var month = obj_date.getMonth() + 1;
        var tomorrow_date = (day < 10 ? '0' + day : day) + '-' + (month < 10 ? '0' + month : month) + '-' + obj_date.getFullYear();
        //alert('today_date='+today_date+' tomorrow_date='+tomorrow_date);


        var date = $('#search-form-date').val();
        if(date == 'Сегодня') {
            date = today_date;
        }else if(date == 'Завтра') {
            date = tomorrow_date;
        }
        if(date.length != 10) {
            //console.log('Уточните дату');
            $('#date .field-error').text('Уточните дату').show();
            has_errors = true;
        }

        if(has_errors == true) {
            console.log('ошибки в форме');
            return false;
        }else {
            console.log('сабмитим форму');
        }
    });


    var search_form_expanded = false;
    function animateSearchForm(expand) {

        if(expand == true) {

            // console.log('search_form_expanded='+search_form_expanded);
            if(search_form_expanded == false) {
                $("#search-form").animate(
                    {
                        'font-size': "18px",
                        'margin-left': "0px",
                        width: "100%",
                        height: "45px",
                        'margin-top': "60px"
                    },
                    350,
                    function() {
                        //console.log('раскрыли');
                        //$('#header').css('height', '150px');
                    }
                );

                $('#header').animate({'height': '130px'}, 350);

                search_form_expanded = true;
            }

        }else {
            if(search_form_expanded == true) {
                $("#search-form").animate(
                    {
                        'font-size': "15px",
                        'margin-left': "190px",
                        width: "73%",
                        height: "36px",
                        'margin-top': "16px"
                    },
                    350,
                    function() {
                        //console.log('закрыли');
                        //$('#header').css('height', '70px');
                    }
                );
                $('#header').animate({'height': '70px'}, 350);
                search_form_expanded = false;
            }
        }
    }

    $('#point-from input').click(function() {
        if($('#search-form').attr('is-submitted') == true) {
            animateSearchForm(true);
        }
        return false;
    });

    $('#point-to input').click(function() {
        if($('#search-form').attr('is-submitted') == true) {
            animateSearchForm(true);
        }
        return false;
    });
    //$('#date').click(function() {
    //    animateSearchForm(true);
    //    return false;
    //});



    function showHideArrows(left) {

        var arrow_right_position_left = $('.scroller_arrow_side_right').offset().left;
        var last_elem_left = $('.priceline_cell:last').offset().left;
        var last_elem_width = $('.priceline_cell:last').width();
        var last_elem_right = last_elem_left + last_elem_width;
        //alert('arrow_right_position_left='+arrow_right_position_left+' last_elem_left='+last_elem_left);
        //console.log('last_elem_right='+last_elem_right+' arrow_right='+(arrow_right_position_left + 100));
        if(last_elem_right < arrow_right_position_left + 100) {
            $('.scroller_arrow_side_right').hide();
        }else {
            $('.scroller_arrow_side_right').show();
        }

        if(left < 0) {
            $('.scroller_arrow_side_left').show();
        }else {
            $('.scroller_arrow_side_left').hide();
        }
    }

    $(document).on('click', '.scroller_arrow_side_right', function() {
        var left = $('.priceline_timeline').css('left');
        if(left == undefined) {
            left = 0;
        }
        left = parseInt(left);
        left = left - 200;

        $('.priceline_timeline').animate({'left': left}, 350, function() {
            showHideArrows(left);
        });
    });

    $(document).on('click', '.scroller_arrow_side_left', function() {

        var left = $('.priceline_timeline').css('left');
        if(left == undefined) {
            left = 0;
        }
        left = parseInt(left);
        left = left + 200;

        $('.priceline_timeline').animate({'left': left}, 350, function() {
            showHideArrows(left);
        });
    });


});

/*
function openLoginForm(access_code) {

    $.ajax({
        url: '/site/ajax-get-login-form?c=' + access_code ,
        type: 'post',
        data: {},
        success: function (response) {

            if(response.success == true) {

                $('#default-modal').find('.modal-body').html(response.html);
                $('#default-modal').find('.modal-dialog').width('450px');
                $('#default-modal .modal-title').html('Вход');
                $('#default-modal').modal('show');

            }else {
                //alert('Ошибка');

                // inputphoneform_errors
                //   mobile_phone
                //      0   Необходимо заполнить «Телефон».

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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}
*/
/*
// Вход - открытие формы
$(document).on('click', '#open-login-form', function() {

    openLoginForm(0);

    return false;
});
*/

// Вход - отправка данных
/*
$(document).on('submit', '#login-form', function(event) {

    var formData = $('#login-form').serialize();

    $.ajax({
        url: $('#login-form').attr('action'),
        type: 'post',
        data: formData,
        beforeSend: function () {
            //allow_send_order = false;
        },
        success: function (data) {

            if (data.success == true) {
                location.reload();
            } else {
                for (var field in data.loginform_errors) {
                    var field_errors = data.loginform_errors[field];
                    $('#login-form').yiiActiveForm('updateAttribute', 'loginform-' + field, field_errors);
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
                alert('Ошибка');
            }
        }
    });


    return false;
});
*/


function openConfirmPhoneForm(user_phone, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-confirm-phone-form?user_phone='+ user_phone +'&is_mobile='+ is_mobile,
        type: 'post',
        data: {},
        success: function (response) {

            if(response.success == true) {

                // $('#default-modal').find('.modal-body').html(response.html);
                // $('#default-modal').find('.modal-dialog').width('650px');
                // $('#default-modal .modal-title').html('Регистрация');
                // $('#default-modal').modal('show');

            //     //$('.for_enter_wrap').hide();
                if(is_mobile == 0) {

                    clearAndHideRegForms();
                    $('#modal_confirm_phone').html(response.html).fadeIn(100);

                }else {

                    clearAndHideMobileRegForms();
                    $('#confirm_phone-mobile').iziModal({
                        width: '100%',
                        top: 0,
                        loop: false,
                        overlayColor: 'rgba(0,0,0,.9)',
                        zindex: 9999,
                        onOpening: function(modal){
                            modal.startLoading();
                            $('#confirm_phone-mobile .iziModal-content').html(response.html)
                            modal.stopLoading();
                        }
                    });
                    $('#confirm_phone-mobile').iziModal('open');

                }

                $(document).on('click', '#confirm_phone_link', function(event){

                    $.ajax({
                        url: '/user/ajax-get-call-auth?number='+ response.number +'&reg_number='+ response.reg_number +'&reg_time_limit='+ response.reg_time_limit,
                        type: 'post',
                        data: {},
                        dataType: 'json',
                        success: function () {

                            if(is_mobile == 0) {

                                $('#modal_confirm_actions').html('<p>Ожидание звонка: <span id = "modal_confirm_timer">'+ response.reg_time_limit +'</span></p>');

                            } else {

                                $('#confirm_phone-mobile .modal_global__btn').html('<p class = "text_16">Ожидание звонка: <span id = "modal_confirm_timer">'+ response.reg_time_limit +'</span></p>');

                            }

                            var limit = response.reg_time_limit;
                            var interval = setInterval(function(){

                                if( limit ){

                                    limit -= 1;
                                    $('#modal_confirm_timer').text(limit);

                                } else {

                                    clearInterval(interval);

                                    if(is_mobile == 0) {

                                        $('#modal_confirm_phone').html('<div class = "for_enter">Указанный вами телефон не подтвержден</div>')

                                    } else {

                                        $('#confirm_phone-mobile .modal_global__enter').html('<div class="modal_global__content" style="padding: 20px;"><p class = "text_16">Указанный вами телефон не подтвержден</p></div>');

                                    }

                                }

                                if(limit % 10 == 1){

                                    $.ajax({
                                        url: '/user/ajax-get-auth-result?number='+ response.number +'&user_phone='+ user_phone,
                                        type: 'post',
                                        data: {},
                                        success: function (response) {

                                            console.log(response);
                                            if( response.success && response.auth ){

                                                clearInterval(interval);
                                                openEmailAndPasswordForm(response.access_code, is_mobile);

                                            }

                                        }
                                    });

                                }

                            }, 1000);

                        }
                    });

                });

            }else {
                alert('Ошибка');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

}



function openInputCodeForm(access_code, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-input-code-form?c='+access_code + '&client_ext_id='+ window.client_ext_id +'&is_mobile=' + is_mobile,
        type: 'post',
        data: {},
        success: function (response) {
            if(response.success == true) {

                // $('#default-modal').find('.modal-body').html(response.html);
                // $('#default-modal').find('.modal-dialog').width('650px');
                // $('#default-modal .modal-title').html('Регистрация');
                // $('#default-modal').modal('show');

                //$('.for_enter_wrap').hide();
                if(is_mobile == 0) {
                    clearAndHideRegForms();
                    $('#modal_entersmscode').html(response.html).fadeIn(100);
                }else {
                    clearAndHideMobileRegForms();
                    $('#entersmscode-mobile').html(response.html).fadeIn(100);
                }

            }else {
                //alert('Ошибка');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}

function openInsertPassword(user_phone, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-insert-password-form?phone=' + user_phone + '&is_mobile=' + is_mobile,
        type: 'post',
        data: {},
        success: function (response) {
            console.log(response);
            if(response.success == true) {

                if(is_mobile == 0) {

                    clearAndHideRegForms();
                    $('#modal_enter_password').html(response.html).fadeIn(100);

                } else {

                    // clearAndHideMobileRegForms();
                    $('#enter_password-mobile').iziModal({
                        width: '100%',
                        top: 0,
                        loop: false,
                        overlayColor: 'rgba(0,0,0,.9)',
                        zindex: 9999,
                        onOpening: function(modal){
                            modal.startLoading();
                            $('#enter_password-mobile .iziModal-content').html(response.html)
                            modal.stopLoading();
                        }
                    });
                    $('#enter_password-mobile').iziModal('open');
                    // $('#enter_password-mobile').iziModal('startLoading');
                    // $('#enter_password-mobile').iziModal('setContent', response.html);
                    // $('#enter_password-mobile').iziModal('stopLoading');

                }

            }else {

                //alert('Ошибка');

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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}


function openEmailAndPasswordForm(access_code, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-input-email-password-form?c='+access_code + '&client_ext_id='+ window.client_ext_id +'&is_mobile=' + is_mobile,
        type: 'post',
        data: {},
        success: function (response) {

            //$('#default-modal').find('.modal-body').html(response.html);
            // $('#default-modal').find('.modal-dialog').width('650px');
            //$('#default-modal .modal-title').html('Заполните электронную почту и установите пароль для входа');
            // $('#default-modal').modal('show');

            //$('.for_enter_wrap').hide();

            if(is_mobile == 0) {
                clearAndHideRegForms();
                $('#modal_registration').html(response.html).fadeIn(100);
            }else {
                clearAndHideMobileRegForms();
                $('#registration-mobile').html(response.html).fadeIn(100);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}


function sendMobileForm(phone, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-login-form?client_ext_id='+ window.client_ext_id +'&is_mobile=' + is_mobile,
        type: 'post',
        data: {
            'InputPhoneForm[mobile_phone]': phone
        },
        success: function (response) {

            if(response.success == true) {

                if(response.next_step == "confirm_phone") {

                    // alert('registration');
                    openConfirmPhoneForm(response.user_phone, is_mobile);

                } else if(response.next_step == "registration") {

                    // alert('registration');
                    openEmailAndPasswordForm(response.access_code, is_mobile);

                } else if(response.next_step == "insert_password") {

                    // alert('insert_password');
                    openInsertPassword(response.user_phone, is_mobile);

                }

            } else {

                if(is_mobile == "1") {
                    for (var field in response.inputphoneform_errors) {
                        var field_errors = response.inputphoneform_errors[field];
                        $('#inputphone-form-mobile').yiiActiveForm('updateAttribute', 'inputphoneform-mobile_phone2', field_errors);
                    }
                }else {
                    for (var field in response.inputphoneform_errors) {
                        var field_errors = response.inputphoneform_errors[field];
                        $('#inputphone-form').yiiActiveForm('updateAttribute', 'inputphoneform-' + field, field_errors);
                    }
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}

$(document).on('click', '#submit-login-phone-mobile', function() {

    var phone = $('#inputphone-form-mobile').find('input[name="InputPhoneForm[mobile_phone2]"]').val();
    sendMobileForm(phone, 1);

    return false;
});
$(document).on('click', '#submit-login-phone', function() {

    var phone = $('#inputphone-form').find('input[name="InputPhoneForm[mobile_phone]"]').val();
    sendMobileForm(phone, 0);

    return false;
});

// отправка пароля в форме входа
$(document).on('click', '#input-password-submit', function() {

    var phone = $('input[name="User[phone]"]').val();
    var password = $('input[name="User[password]"]').val();
    var rememberMe = ($('input[name="User[rememberMe]"]').is(':checked') ? 1 : 0);

    $.ajax({
        url: '/site/ajax-get-insert-password-form?phone=' + phone,
        type: 'post',
        data: {
            "User[password]": password,
            "User[rememberMe]": rememberMe
        },
        success: function (response) {

            if(response.success == true) {

                if($('#order-client-form').length > 0 || $('.reservation-form').length > 0) {
                    location.reload();
                }else {
                    location.href = '/account/order/history';
                }

            }else {
                for (var field in response.errors) {
                    var field_errors = response.errors[field];
                    $('#input-password-form').yiiActiveForm('updateAttribute', 'user-' + field, field_errors);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    $('#enter_password-mobile')

});

function resendCode(access_code, is_mobile) {

    $.ajax({
        url: '/site/ajax-resend-code?c=' + access_code + '&is_mobile=' + is_mobile,
        type: 'post',
        data: {},
        success: function (response) {

            if(response.success == true) {
                $('.field-currentreg-check_code').show();
                alert('Смс с кодом отправлено');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}

// + Запрос повторной отправки кода в смс
$(document).on('click', '#resend-code-button', function() {

    var access_code = $(this).attr('access_code');

    $('#error').text('');
    $('input[name="CurrentReg[check_code]"]').val('');
    $('.field-currentreg-check_code').show();
    $('#check-code-button').show();
    $('#resend-code-button').hide();

    resendCode(access_code, 0);

    return false;
});
$(document).on('click', '#resend-code-button-mobile', function() {

    var access_code = $(this).attr('access_code');

    $('#error').text('');
    $('input[name="CurrentReg[check_code]"]').val('');
    $('.field-currentreg-check_code').show();
    $('#check-code-button').show();
    $('#resend-code-button-mobile').hide();

    resendCode(access_code, 1);

    return false;
});


function checkCode(access_code, sms_code, is_mobile) {

    $.ajax({
        url: '/site/ajax-check-code?c=' + access_code + '&sms_code=' + sms_code + '&is_mobile=' + is_mobile,
        type: 'post',
        data: {},
        success: function (response) {

            if(response.success == true) {

                openEmailAndPasswordForm(access_code, is_mobile);  // открываем форму заполнения email и пароля для входа

            }else {
                //$('#registration-step-2').yiiActiveForm('updateAttribute', 'currentreg-check_code', [response.error]);
                $('input[name="CurrentReg[check_code]"]').val('');
                $('.field-currentreg-check_code').hide();
                $('#check-code-button').hide();

                if(response.available_sms_count == "0") {
                    // alert('Код не верен. Доступные сегодняшние смс закончились.');
                    $('#resend-code-button').hide();
                    $('#error').text('Код не верен. Доступные сегодняшние смс закончились.');

                }else {
                    // alert('Код не верен. Запросите новое смс с кодом');
                    $('#resend-code-button').show();
                    $('#error').text('Код не верен. Запросите новое смс с кодом');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}

// отправка формы с введенном кодом - доработать !
$(document).on('click', '#check-code-button', function() {

    var access_code = $(this).attr('access_code');
    var sms_code = $('input[name="CurrentReg[check_code]"]').val();

    checkCode(access_code, sms_code, 0);

    return false;
});

// отправка формы с введенном кодом - доработать !
$(document).on('click', '#check-code-button-mobile', function() {

    var access_code = $(this).attr('access_code');
    var sms_code = $('input[name="CurrentReg[check_code]"]').val();

    checkCode(access_code, sms_code, 1);

    return false;
});



function sendEmailPasswordForm(access_code, email, password, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-input-email-password-form?c=' + access_code + '&client_ext_id=' + window.client_ext_id + '&is_mobile='+ is_mobile,
        type: 'post',
        data: {
            "CurrentReg[email]": email,
            "CurrentReg[password]": password
        },
        success: function (response) {

            if(response.success == true) {
                if($('#order-client-form').length > 0) {
                    location.reload();
                }else {
                    location.href = '/account/order/history';
                }
            }else {
                for (var field in response.errors) {
                    var field_errors = response.errors[field];
                    $('#inputphone-form').yiiActiveForm('updateAttribute', 'registration-step-3-' + field, field_errors);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}

// установка email и пароля пользователя - доработать !
$(document).on('click', '#send-email-password-button', function() {

    var access_code = $(this).attr('access_code');
    var email = $('input[name="CurrentReg[email]"]').val();
    var password = $('input[name="CurrentReg[password]"]').val();

    sendEmailPasswordForm(access_code, email, password, 0);

    return false;
});
$(document).on('click', '#send-email-password-button-mobile', function() {

    var access_code = $(this).attr('access_code');
    var email = $('input[name="CurrentReg[email]"]').val();
    var password = $('input[name="CurrentReg[password]"]').val();

    sendEmailPasswordForm(access_code, email, password, 1);

    return false;
});


// Регистрация - открытие формы
/*
$(document).on('click', '#open-registration-form', function() {

    $.ajax({
        url: '/site/ajax-get-registration-form',
        type: 'post',
        data: {},
        success: function (response) {
            if(response.success == true) {

                $('#default-modal').find('.modal-body').html(response.html);
                $('#default-modal .modal-title').html('Регистрация');
                $('#default-modal').modal('show');

            }else {
                //alert('Ошибка');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});
*/

/*
$(document).on('click', '#open-start-registration-form', function() {

    $.ajax({
        url: '/site/ajax-get-start-registration-form',
        type: 'post',
        data: {},
        success: function (response) {
            if(response.success == true) {

                $('#default-modal').find('.modal-body').html(response.html);
                $('#default-modal .modal-title').html('Регистрация');
                $('#default-modal').modal('show');

            }else {
                //alert('Ошибка');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});

// нажатие кнопки "далее" в форме ввода телефона
$(document).on('click', '#submit-start-registration', function() {

    //var email = $('#currentreg-mobile_phone').val();
    var mobile_phone = $('#currentreg-mobile_phone').val();

    $.ajax({
        url: '/site/ajax-get-start-registration-form',
        type: 'post',
        data: {
            //email: email
            mobile_phone: mobile_phone
        },
        success: function (response) {

            //console.log('response:'); console.log(response);
            if(response.success == true) {
                $('#default-modal').find('.modal-body').html(response.html);
            }else {
                $('#start-registration-form').yiiActiveForm('updateAttribute', 'currentreg-mobile_phone', response.currentreg_errors.mobile_phone);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});
 */
/*
// нажатие кнопки "далее" в форме ввода оставшихся полей: Эл.почты, ФИО, пароль
$(document).on('click', '#submit-end-registration', function() {

    var mobile_phone = $('#currentreg-mobile_phone').val();
    var email = $('#currentreg-email').val();
    var fio = $('#currentreg-fio').val();
    var password = $('#currentreg-password').val();
    var confirm_password = $('#currentreg-confirm_password').val();

    $.ajax({
        url: '/site/ajax-get-end-registration-form',
        type: 'post',
        data: {
            mobile_phone: mobile_phone,
            email: email,
            fio: fio,
            password: password,
            confirm_password: confirm_password
        },
        success: function (response) {

            $('#end-registration-form').yiiActiveForm('add', {
                id: 'currentreg-email',
                name: 'currentreg-email',
                container: '.field-currentreg-email',
                input: '#currentreg-email',
                error: '.help-block',
                validate:  function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, {message: "Validation Message Here"});
                }
            });
            $('#end-registration-form').yiiActiveForm('add', {
                id: 'currentreg-fio',
                name: 'currentreg-fio',
                container: '.field-currentreg-fio',
                input: '#currentreg-fio',
                error: '.help-block',
                validate:  function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, {message: "Validation Message Here"});
                }
            });
            $('#end-registration-form').yiiActiveForm('add', {
                id: 'currentreg-password',
                name: 'currentreg-password',
                container: '.field-currentreg-password',
                input: '#currentreg-password',
                error: '.help-block',
                validate:  function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, {message: "Validation Message Here"});
                }
            });
            $('#end-registration-form').yiiActiveForm('add', {
                id: 'currentreg-confirm_password',
                name: 'currentreg-confirm_password',
                container: '.field-currentreg-confirm_password',
                input: '#currentreg-confirm_password',
                error: '.help-block',
                validate:  function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, {message: "Validation Message Here"});
                }
            });

            //console.log('response:'); console.log(response);
            if(response.success == true) {

                $('#default-modal').find('.modal-body').html('<br />Вы успешно зарегистрированы. И можете войти на сайт.<br />');

                setTimeout(function(){
                    $('#default-modal').modal('hide');
                },3000);

            }else {
                //$('#start-registration-form').yiiActiveForm('updateAttribute', 'currentreg-mobile_phone', response.currentreg_errors.mobile_phone);
                //console.log('email:'); console.log(response.currentreg_errors.email);
                if(void 0 !== response.currentreg_errors.email) {
                    $('#end-registration-form').yiiActiveForm('updateAttribute', 'currentreg-email', response.currentreg_errors.email);
                }
                if(void 0 !== response.currentreg_errors.fio) {
                    $('#end-registration-form').yiiActiveForm('updateAttribute', 'currentreg-fio', response.currentreg_errors.fio);
                }
                if(void 0 !== response.currentreg_errors.password) {
                    $('#end-registration-form').yiiActiveForm('updateAttribute', 'currentreg-password', response.currentreg_errors.password);
                }
                if(void 0 !== response.currentreg_errors.confirm_password) {
                    $('#end-registration-form').yiiActiveForm('updateAttribute', 'currentreg-confirm_password', response.currentreg_errors.confirm_password);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});
*/
/*
// нажатие "Далее" в форме проверки введенного кода
$(document).on('click', '#submit-check-registration-code', function() {

    var mobile_phone = $('#currentreg-mobile_phone').val();
    var check_code = $('#currentreg-check_code').val();

    $.ajax({
        url: '/site/ajax-check-registration-code',
        type: 'post',
        data: {
            mobile_phone: mobile_phone,
            check_code: check_code
        },
        success: function (response) {


            //console.log('response:'); console.log(response);
            if(response.success == true) {

                //$('#default-modal').find('.modal-body').html('<br />Вы успешно зарегистрированы. И можете войти на сайт.<br />');
                //
                //setTimeout(function(){
                //    $('#default-modal').modal('hide');
                //},3000);

                // после проверки кода загружаем форму ввода оставшихся полей с историей поездок
                $('#default-modal').find('.modal-body').html(response.html);

                $('#end-registration-form').yiiActiveForm('add', {
                    id: 'currentreg-email',
                    name: 'currentreg-email',
                    container: '.field-currentreg-email',
                    input: '#currentreg-email',
                    error: '.help-block',
                    validate:  function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: "Validation Message Here"});
                    }
                });
                $('#end-registration-form').yiiActiveForm('add', {
                    id: 'currentreg-fio',
                    name: 'currentreg-fio',
                    container: '.field-currentreg-fio',
                    input: '#currentreg-fio',
                    error: '.help-block',
                    validate:  function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: "Validation Message Here"});
                    }
                });
                $('#end-registration-form').yiiActiveForm('add', {
                    id: 'currentreg-password',
                    name: 'currentreg-password',
                    container: '.field-currentreg-password',
                    input: '#currentreg-password',
                    error: '.help-block',
                    validate:  function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: "Validation Message Here"});
                    }
                });
                $('#end-registration-form').yiiActiveForm('add', {
                    id: 'currentreg-confirm_password',
                    name: 'currentreg-confirm_password',
                    container: '.field-currentreg-confirm_password',
                    input: '#currentreg-confirm_password',
                    error: '.help-block',
                    validate:  function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: "Validation Message Here"});
                    }
                });


            }else {


                $('#form-check-registration-code').yiiActiveForm('add', {
                    id: 'currentreg-check_code',
                    name: 'currentreg-check_code',
                    container: '.field-currentreg-check_code',
                    input: '#currentreg-check_code',
                    error: '.help-block',
                    validate:  function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: "Validation Message Here"});
                    }
                });
                $('#submit-check-registration-code').hide();


                if(void 0 !== response.update_send_button && response.update_send_button == 1) {
                    $('#send-registration-code').show();
                }

                if(void 0 !== response.currentreg_errors.check_code) {
                    $('#form-check-registration-code').yiiActiveForm('updateAttribute', 'currentreg-check_code', response.currentreg_errors.check_code);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});
*/
/*
// нажатие на кнопке "Отправить код еще раз"
$(document).on('click', '#send-registration-code', function() {

    var mobile_phone = $('#currentreg-mobile_phone').val();
    $('#form-check-registration-code').yiiActiveForm('updateAttribute', 'currentreg-check_code', '');
    $('#submit-check-registration-code').show(200);
    $('#send-registration-code').hide(200);
    $('#currentreg-check_code').val('');

    $.ajax({
        url: '/site/ajax-send-sms-with-code',
        type: 'post',
        data: {
            mobile_phone: mobile_phone
        },
        success: function (response) {},
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

    return false;
});
*/

/*
// Регистрация - отправка данных
var allow_send_registration = true;
$(document).on('submit', '#registration-form', function(event) {

    if(allow_send_registration == true) {
        var formData = $('#registration-form').serialize();
        $.ajax({
            url: $('#registration-form').attr('action'),
            type: 'post',
            data: formData,
            beforeSend: function () {
                allow_send_registration = false;
                $('body').css('cursor', 'wait');
            },
            success: function (data) {

                allow_send_registration = true;
                $('body').css('cursor', 'default');
                if (data.success == true) {
                    //location.reload();
                    $('#default-modal').find('.close').click();
                    alert('На вашу почту отправлена ссылка. Необходимо пройти по ссылке чтобы подтвердить почту и затем аутентифицироваться на сайте.');

                } else {
                    for (var field in data.currentreg_errors) {
                        var field_errors = data.currentreg_errors[field];
                        $('#registration-form').yiiActiveForm('updateAttribute', 'currentreg-' + field, field_errors);
                    }
                }
            },
            error: function (data, textStatus, jqXHR) {

                allow_send_registration = true;
                $('body').css('cursor', 'default');
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
                } else {
                    alert('Ошибка');
                }
            }
        });
    }else {
        //alert('хватить жать на кнопку - запрос обрабатывается...');
    }


    return false;
});
*/


// Восстановление пароля
function getRestorePasswordForm(phone, is_mobile) {

    $.ajax({
        url: '/site/ajax-get-restore-password-form?phone=' + phone + '&is_mobile=' + is_mobile,
        type: 'post',
        data: {},
        success: function (response) {

            // $('.for_enter_wrap').hide();
            if(is_mobile == 0) {
                clearAndHideRegForms();
                $('#modal_restorepassword').html(response.html).fadeIn(100);
            }else {
                clearAndHideMobileRegForms();
                $('#restorepassword-mobile').html(response.html).fadeIn(100);
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}
$(document).on('click', '#open-restore-password-form', function() {

    var phone = $('input[name="User[phone]"]').val();
    getRestorePasswordForm(phone, is_mobile());

    return false;
});
$(document).on('click', '#close-restore-password-form', function() {

    
    return false;
});

// Восстановление пароля - отправка данных - доработать !
$(document).on('submit', '#restore-password-form', function(event) {

    var formData = $('#restore-password-form').serialize();

    $.ajax({
        url: $('#restore-password-form').attr('action'),
        type: 'post',
        data: formData,
        beforeSend: function () {
            //allow_send_order = false;
        },
        success: function (data) {

            if (data.success == true) {
                //location.reload();
                alert('Для восстановления доступа пройдите по ссылке в письме отправленном на вашу почту.');
                $('#default-modal').find('.close').click();

            } else {
                for (var field in data.restorepassword_errors) {
                    var field_errors = data.restorepassword_errors[field];
                    $('#restore-password-form').yiiActiveForm('updateAttribute', 'restorepasswordform-' + field, field_errors);
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
                alert('Ошибка');
            }
        }
    });


    return false;
});

// Изменение пароля - открытие формы
$(document).on('click', '#open-change-password-form', function() {

    $.ajax({
        url: '/site/ajax-get-change-password-form',
        type: 'post',
        data: {},
        success: function (response) {
            if(response.success == true) {

                $('#default-modal').find('.modal-body').html(response.html);
                $('#default-modal .modal-title').html('Изменение пароля');
                $('#default-modal').modal('show');

            }else {
                //alert('Ошибка');
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });

    return false;
});


// Изменение пароля - отправка данных
$(document).on('submit', '#change-password-form', function(event) {

    var formData = $('#change-password-form').serialize();

    $.ajax({
        url: $('#change-password-form').attr('action'),
        type: 'post',
        data: formData,
        beforeSend: function () {
            //allow_send_order = false;
        },
        success: function (data) {

            if (data.success == true) {
                alert('Пароль изменен.');
                $('#default-modal').find('.close').click();

            } else {
                for (var field in data.changepassword_errors) {
                    var field_errors = data.changepassword_errors[field];
                    $('#restore-password-form').yiiActiveForm('updateAttribute', 'changepasswordform-' + field, field_errors);
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
                alert('Ошибка');
            }
        }
    });


    return false;
});


// расчет и установка значения итоговой цены заказа по данным на форме
function calcTotalPrice() {

    var totalPrice = 0;
    $('.passenger-form').each(function() {
        totalPrice += parseFloat($(this).find('.passenger-form-price').text());
    });

    $('#total-price').html(totalPrice + ' &#8399;');
}


$(document).on('click', '#add-passenger', function() {

    $.ajax({
        url: '/trip/ajax-get-passenger-form',
        type: 'post',
        data: {},
        beforeSend: function () {},
        success: function (response) {
            $('.passenger-form:last').after(response.html);
            $('.passenger-form-remove').show();
            calcTotalPrice();
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
                alert('Ошибка');
            }
        }
    });

    return false;
});

$(document).on('click', '.passenger-form-remove', function() {
    $(this).parents('.passenger-form').remove();
    if($('.passenger-form').length == 1) {
        $('.passenger-form-remove').hide();
    }
    calcTotalPrice();
});


$(document).on('change', '.passenger-form *[name="Passenger[tariff_type]"]', function() {
    var price = $(this).find('option:selected').attr('price') + ' &#8399;';
    $(this).parents('.passenger-form').find('.passenger-form-price').html(price);
    calcTotalPrice();
});


$(document).on('change', '.passenger-form *[name="Passenger[document_type]"]', function() {

    //switch($(this).val()) {
    //    case 'passport':
    //        $('input[name="Passenger[series_number]"]').attr('placeholder', '1234 123456');
    //        break;
    //    case 'birth_certificate':
    //        $('input[name="Passenger[series_number]"]').attr('placeholder', 'VI-БА № 123456');
    //        break;
    //    case 'international_passport':
    //        $('input[name="Passenger[series_number]"]').attr('placeholder', '12 321123');
    //        break;
    //    case 'foreign_passport':
    //        $('input[name="Passenger[series_number]"]').attr('placeholder', '');
    //        break;
    //}

    // series_number_placeholder
    var $option = $(this).find('option:selected');
    var value = $option.attr('value');
    var placeholder = $option.attr('series_number_placeholder');

    //alert('value='+value+' placeholder='+placeholder);
    $('input[name="Passenger[series_number]"]').attr('placeholder', placeholder);

    if(value == 'foreign_passport') {
        $(this).parents('.passenger-form').find('.passenger-form-citizenship').show();
    }else {
        $(this).parents('.passenger-form').find('.passenger-form-citizenship').hide();
    }
});

$(document).ready(function() {
    calcTotalPrice();
});



$(document).on('change', '*[name="Passenger[fio]"]', function() {
    if($(this).parent('.y-input').next('.form-input-error-msg').length > 0) {
        $(this).parent('.y-input').next('.form-input-error-msg').remove();
    }
});
$(document).on('change', '*[name="Passenger[date_of_birth]"]', function() {
    if($(this).parent('.y-input').next('.form-input-error-msg').length > 0) {
        $(this).parent('.y-input').next('.form-input-error-msg').remove();
    }
});
$(document).on('change', '*[name="Passenger[citizenship]"]', function() {
    if($(this).parent('.y-input').next('.form-input-error-msg').length > 0) {
        $(this).parent('.y-input').next('.form-input-error-msg').remove();
    }
});
$(document).on('change', '*[name="Passenger[series_number]"]', function() {
    if($(this).parent('.y-input').next('.form-input-error-msg').length > 0) {
        $(this).parent('.y-input').next('.form-input-error-msg').remove();
    }
});


$(document).on('change', '*[name="User[phone]"]', function() {
    if($(this).parent('.y-input').next('.form-input-error-msg').length > 0) {
        $(this).parent('.y-input').next('.form-input-error-msg').remove();
    }
});
$(document).on('change', '*[name="User[email]"]', function() {
    if($(this).parent('.y-input').next('.form-input-error-msg').length > 0) {
        $(this).parent('.y-input').next('.form-input-error-msg').remove();
    }
});
$(document).on('change', '*[name="agreement-checkbox"]', function() {
    if($('.agreement-label_error').length > 0) {
        $('.agreement-label_error').removeClass('agreement-label_error');
    }
});


function getTripFormData() {

    var User = {
        phone: $.trim($('*[name="User[phone]"]').val()),
        email: $.trim($('*[name="User[email]"]').val())
    };


    var yandex_point_from_id = 0;
    var yandex_point_from_lat = 0;
    var yandex_point_from_long = 0;
    var yandex_point_from_name = "";

    var yandex_point_to_id = 0;
    var yandex_point_to_lat = 0;
    var yandex_point_to_long = 0;
    var yandex_point_to_name = 0;

    var yandex_point_from = $('input[name="ClientExt[yandex_point_from]"]').val();
    if(yandex_point_from != undefined) {
        var yandex_point_from_data = yandex_point_from.split('_');
        yandex_point_from_id = yandex_point_from_data[0];
        yandex_point_from_lat = yandex_point_from_data[1];
        yandex_point_from_long = yandex_point_from_data[2];
        yandex_point_from_name = yandex_point_from_data[3];
    }

    var yandex_point_to = $('input[name="ClientExt[yandex_point_to]"]').val();
    if(yandex_point_to != undefined) {
        var yandex_point_to_data = yandex_point_to.split('_');
        yandex_point_to_id = yandex_point_to_data[0];
        yandex_point_to_lat = yandex_point_to_data[1];
        yandex_point_to_long = yandex_point_to_data[2];
        yandex_point_to_name = yandex_point_to_data[3];
    }

    var ClientExt = {
        //yandex_point_from: $.trim($('*[name="ClientExt[yandex_point_from]"]').val()),
        //yandex_point_to: $.trim($('*[name="ClientExt[yandex_point_to]"]').val())
        yandex_point_from_id: yandex_point_from_id,
        yandex_point_from_lat: yandex_point_from_lat,
        yandex_point_from_long: yandex_point_from_long,
        yandex_point_from_name: yandex_point_from_name,

        yandex_point_to_id: yandex_point_to_id,
        yandex_point_to_lat: yandex_point_to_lat,
        yandex_point_to_long: yandex_point_to_long,
        yandex_point_to_name: yandex_point_to_name
    };

    var agreement_checkbox = $('*[name="agreement-checkbox"]').is(':checked');

    var Passengers = [];
    $('.passenger-form').each(function() {
        Passengers[Passengers.length] = {
            tariff_type: $(this).find('*[name="Passenger[tariff_type]"]').val(),
            fio: $.trim($(this).find('*[name="Passenger[fio]"]').val()),
            gender: $(this).find('*[name="Passenger[gender]"]').val(),
            date_of_birth: $.trim($(this).find('*[name="Passenger[date_of_birth]"]').val()),
            document_type: $(this).find('*[name="Passenger[document_type]"]').val(),
            //citizenship: '',// $.trim($(this).find('*[name="Passenger[citizenship]"]').val()),
            series_number: $.trim($(this).find('*[name="Passenger[series_number]"]').val())
        }

        if($(this).find('*[name="Passenger[citizenship]"]').is(':visible') == true) {
            Passengers[Passengers.length - 1].citizenship = $.trim($(this).find('*[name="Passenger[citizenship]"]').val());
        }
    });

    return {
        User: User,
        ClientExt: ClientExt,
        Passengers: Passengers,
        agreement_checkbox: agreement_checkbox
    };
}


// Регистрация - отправка данных
var allow_send_trip_form = true;
$(document).on('submit', '#trip-form', function(event) {

    if(allow_send_trip_form == true) {

        //var formData = $('#trip-form').serialize();
        $('.form-input-error-msg').remove();
        $('#agreement-label').removeClass('agreement-label_error');


        var formData = getTripFormData();
        //console.log('formData:'); console.log(formData);

        var form_has_error = false;

        var trip_id = $('#trip-form').attr('trip-id');

        if(formData['agreement_checkbox'] == false) {
            form_has_error = true;
            $('#agreement-label').addClass('agreement-label_error');
        }
        if(formData['User']['phone'] == '') {
            form_has_error = true;
            $('*[name="User[phone]"]').parent('.y-input').after('<span class="form-input-error-msg">Некорректный телефон</span>');
        }
        if(formData['User']['email'] == '') {
            form_has_error = true;
            $('*[name="User[email]"]').parent('.y-input').after('<span class="form-input-error-msg">Некорректный Email</span>');
        }
        if(formData['ClientExt']['yandex_point_from'] == '') {
            form_has_error = true;
            $('*[name="ClientExt[yandex_point_from]"]').parents('.y-input').after('<span class="form-input-error-msg">Укажите точку Откуда</span>');
        }
        if(formData['ClientExt']['yandex_point_to'] == '') {
            form_has_error = true;
            $('*[name="ClientExt[yandex_point_to]"]').parents('.y-input').after('<span class="form-input-error-msg">Укажите точку Куда</span>');
        }



        var Passengers = formData.Passengers;
        for(var i = 0; i < Passengers.length; i++) {
            var Passenger = Passengers[i];

            if(Passenger['fio'] == '') {
                form_has_error = true;
                $('.passenger-form').eq(i).find('*[name="Passenger[fio]"]').parent('.y-input').after('<span class="form-input-error-msg">Укажите фамилию, имя и отчество</span>');
            }
            if(Passenger['date_of_birth'] == '') {
                form_has_error = true;
                $('.passenger-form').eq(i).find('*[name="Passenger[date_of_birth]"]').parent('.y-input').after('<span class="form-input-error-msg">Неверная дата</span>');
            }
            if(Passenger['citizenship'] == '') {
                form_has_error = true;
                $('.passenger-form').eq(i).find('*[name="Passenger[citizenship]"]').parent('.y-input').after('<span class="form-input-error-msg">Укажите гражданство</span>');
            }
            if(Passenger['series_number'] == '') {
                form_has_error = true;
                $('.passenger-form').eq(i).find('*[name="Passenger[series_number]"]').parent('.y-input').after('<span class="form-input-error-msg">Укажите серию и номер документа</span>');
            }
        }
/**/
        if(form_has_error == false) {
            $.ajax({
                url: '/trip/ajax-save-trip-form?trip_id=' + trip_id,
                type: 'post',
                data: formData,
                beforeSend: function () {
                    allow_send_trip_form = false;
                    $('body').css('cursor', 'wait');
                },
                success: function (data) {

                    allow_send_trip_form = true;
                    $('body').css('cursor', 'default');
                    if (data.success == true) {
                        //location.reload();
                        //alert('На вашу почту отправлена ссылка. Необходимо пройти по ссылке чтобы подтвердить почту и затем аутентифицироваться на сайте.');
                        //alert('Заказ создан, переходим на следующую страницу...');

                        //location.href = '/trip/client-ext-payment?id=' + data.client_ext_id;
                        location.href = '/trip/client-ext-payment?c=' + data.client_ext_code;

                    } else {

                        $('.form-input-error-msg').remove();
                        for (var field in data.user_errors) {
                            var field_errors = data.user_errors[field];
                            //$('#registration-form').yiiActiveForm('updateAttribute', 'currentreg-' + field, field_errors);

                            var field_str_errors = '';
                            for (var key in field_errors) {
                                field_str_errors += field_errors[key] + ' ';
                            }

                            var html_error = '<span class="form-input-error-msg">' + field_str_errors + '</span>';
                            $('*[name="User[' + field + ']"]').parent('.y-input').after(html_error);
                        }

                        for (var pas_key in data.passengers_errors) {
                            var passenger_errors = data.passengers_errors[pas_key];
                            //console.log('passenger_errors:'); console.log(passenger_errors);

                            for (var field in passenger_errors) {
                                var field_errors = passenger_errors[field];

                                var field_str_errors = '';
                                for (var key in field_errors) {
                                    field_str_errors += field_errors[key] + ' ';
                                }

                                var html_error = '<span class="form-input-error-msg">' + field_str_errors + '</span>';
                                $('.passenger-form').eq(pas_key).find('*[name="Passenger[' + field + ']"]').parent('.y-input').after(html_error);
                            }
                        }

                        var field_str_errors = '';
                        for (var clientext_key in data.client_ext_errors) {
                            var field_errors = data.client_ext_errors[clientext_key];
                            $('#trip-form').yiiActiveForm('updateAttribute', 'clientext-' + field, field_errors);
                        }

                        //alert(field_str_errors);
                    }
                },
                error: function (data, textStatus, jqXHR) {

                    allow_send_trip_form = true;
                    $('body').css('cursor', 'default');
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
                    } else {
                        alert('Ошибка');
                    }
                }
            });
        }
    }else {
        //alert('хватить жать на кнопку - запрос обрабатывается...');
    }


    return false;
});

/*
$(document).on('click', '#rezerv-client-ext', function() {

    var access_code = $(this).attr('access-code');
    $.ajax({
        url: '/trip/reserv-client-ext?c=' + access_code,
        type: 'post',
        data: {},
        beforeSend: function () {
            $('body').css('cursor', 'wait');
        },
        success: function (data) {

            $('body').css('cursor', 'default');
            if (data.success == true) {
                alert('Заказ сохранен');
                location.href = '/';
            } else {
                //alert(field_str_errors);
            }
        },
        error: function (data, textStatus, jqXHR) {

            $('body').css('cursor', 'default');
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
            } else {
                alert('Ошибка');
            }
        }
    });

    return false;
});
*/

/*
// отображение/скрытие точек в зависимости от зума карты
function showHidePlacemarks(current_map, map_zoom, all_points_show_scale) {

    //console.log('showHidePlacemarks all_points_show_scale=' + all_points_show_scale + ' map_zoom='+map_zoom);

    var point_placemark_index = -1;
    if(point_placemark != null) {
        var balloonContent = point_placemark.properties.get('balloonContent');
        var point_placemark_index = parseIndexFromTemplate(balloonContent);
    }

    if(current_map != null) {
        if (map_zoom < all_points_show_scale) { // прячу все точки кроме выбранной точки
            current_map.geoObjects.each(function (placemark, i) {
                if (i != point_placemark_index) {
                    console.log('прячем точку');
                    placemark.options.set('visible', false);
                }
            })
        } else { // отображаю все точки кроме выбранной
            current_map.geoObjects.each(function (placemark, i) {
                if (i != point_placemark_index) {
                    console.log('отображаем точку');
                    placemark.options.set('visible', true);
                }
            })
        }
    }
}


// можно ли редактировать данные точки
function getIsAllowedEditParam() {

    if($('.city-update').length > 0) {
        return true;
    }else {
        return false;
    }
}

// можно ли перемещать точку
function getDraggable(yandex_point_id) {

    if($('#order-create-modal').length > 0) {
        //if (yandex_point_id > 0) {
        //    var draggable = false;
        //} else {
        //    var draggable = true;
        //}
        var draggable = false;
    }else if($('.city-update').length > 0) {
        var draggable = true;
    }else {
        var draggable = false;
    }

    return draggable;
}


function getPlacemarketTemplate(params) {

    if(params['point_text'] == undefined) {
        params['point_text'] = '';
    }
    if(params['index'] == undefined) {
        params['index'] = '';
    }
    if(params['point_id'] == undefined) {
        params['point_id'] = 0;
    }
    if(params['critical_point'] != 1) {
        params['critical_point'] = 0;
    }
    if(params['point_of_arrival'] != 1) {
        params['point_of_arrival'] = 0;
    }
    if(params['super_tariff_used'] != 1) {
        params['super_tariff_used'] = 0;
    }
    if(params['alias'] == undefined) {
        params['alias'] = '';
    }

    if(params['is_editing'] != true) {
        params['is_editing'] = false;
    }
    if(params['can_change_params'] != true) {
        params['can_change_params'] = false;
    }
    if(params['is_allowed_edit'] != true) {
        params['is_allowed_edit'] = false;
    }
    if(params['create_new_point'] != true) {
        params['create_new_point'] = false;
    }
    //if(params['is_temp_point'] != true) {
    //    params['is_temp_point'] = false;
    //}
    //if(params['is_base_point'] != true) {
    //    params['is_base_point'] = false;
    //}


    if(params['can_change_params'] == true) {
        params['is_editing'] = true;
    }


    if(params['is_allowed_edit'] == false) {

        var content =
            '<div class="placemark-balloon-content" index="' + params['index'] + '" yandex-point-id="' + params['point_id'] + '">';
        content +=
            '<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
            '<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
            '<input class="input-placemark" style="display: none;" type="text" value="' + params['point_text'] + '" />' +
            '<span class="span-placemark not-edit"> ' + params['point_text'] + '</span>' +
            '</div>';

    }else if(params['is_editing'] == true) {

        var content =
            '<div class="placemark-balloon-content" index="' + params['index'] + '" yandex-point-id="' + params['point_id'] + '" create-new-point="' + params['create_new_point'] + '">';
        if(params['can_change_params'] == true) {

            content +=
                '<input class="point-of-arrival" type="checkbox" ' + (params['point_of_arrival'] == true ? "checked" : "") + ' /> является точкой прибытия <br />' +
                '<input class="super-tariff-used" type="checkbox" ' + (params['super_tariff_used'] == true ? "checked" : "") + ' /> применяется супер тариф <br />' +
                '<input class="critical-point" type="checkbox" ' + (params['critical_point'] == true ? "checked" : "") + ' /> критическая точка <br />' +
                '<input class="alias" type="text" value="' + params['alias'] + '" placeholder="airport" /><br />';
        }
        content +=
            '<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
            '<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
            '<input class="input-placemark" type="text" value="' + params['point_text'] + '" />' +
            '<button class="ok-placemark">Ок</button>' +
            '<span class="span-placemark" style="display: none;">' + params['point_text'] + '</span>' +
            '</div>';

    }else {

        var content =
            '<div class="placemark-balloon-content" index="' + params['index'] + '" yandex-point-id="' + params['point_id'] + '" create-new-point="' + params['create_new_point'] + '">';

        if(params['can_change_params'] == true) {
            content +=
                '<input class="point-of-arrival" type="checkbox" ' + (params['point_of_arrival'] == true ? "checked" : "") + ' /> является точкой прибытия <br />' +
                '<input class="super-tariff-used" type="checkbox" ' + (params['super_tariff_used'] == true ? "checked" : "") + ' /> применяется супер тариф <br />' +
                '<input class="critical-point" type="checkbox" ' + (params['critical_point'] == true ? "checked" : "") + ' /> критическая точка <br />' +
                '<input class="alias" type="text" value="' + params['alias'] + '" placeholder="airport" /><br />';
        }

        content +=
            '<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
            '<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
            '<input class="input-placemark" style="display: none;" type="text" value="' + params['point_text'] + '" />' +
            '<button class="ok-placemark" style="display: none;">Ок</button>' +
            '<span class="span-placemark">' + params['point_text'] + '</span>' +
            '</div>';

    }

    return content;
}

function parseCriticalPointFromTemplate(content) {

    var pos_start = content.indexOf('critical-point');
    var text = content.substring(pos_start);
    var pos_start = text.indexOf('>') + 1;
    var text = text.substring(pos_start);
    var pos_end = text.indexOf('</span>');
    var text = text.substring(0, pos_end);

    return text;
}

function parseAliasFromTemplate(content) {

    var pos_start = content.indexOf('alias');
    var text = content.substring(pos_start);
    var pos_start = text.indexOf('>') + 1;
    var text = text.substring(pos_start);
    var pos_end = text.indexOf('</span>');
    var text = text.substring(0, pos_end);

    return text;
}

// извлечение из html-контента названия яндекс-точки
function parseNameFromTemplate(content) {

    var pos_start = content.indexOf('span-placemark') + 14;
    var text = content.substring(pos_start);
    var pos_start = text.indexOf('>') + 1;
    var text = text.substring(pos_start);
    var pos_end = text.indexOf('</span></div>');
    var text = text.substring(0, pos_end);

    return text;
}

// извлечение из html-контента id яндекс-точки
function parseIdFromTemplate(content) {

    var pos_start = content.indexOf('yandex-point-id=') + 17;
    var id = content.substring(pos_start);
    var pos_end = id.indexOf('"');
    var id = id.substring(0, pos_end);

    return id;
}

// извлечение из html-контента индекса placemark в коллекции
function parseIndexFromTemplate(content) {

    var pos_start = content.indexOf('index=') + 7;
    var index = content.substring(pos_start);
    var pos_end = index.indexOf('"');
    var index = index.substring(0, pos_end);

    return index;
}

// сохранение изменений в данных точки в полях формы создания/редактирования заказа
function updateOrderFormYandexPoint(point_from, point_id, point_lat, point_long, point_name) {
    var name = point_id + '_' + point_lat + '_' + point_long + '_' + point_name;

    if(point_from == true) {
        $('input[name="Order[yandex_point_from]"]').val(name);
    }else {
        $('input[name="Order[yandex_point_to]"]').val(name);
    }
}

 */





// Метод реализует выбор точки
// index - индекс элемента на карте (point_placemark = map.geoObjects.get(index);)
// point_text - текст яндекс-точки
// point_id - id точки
// critical_point - true/false  (была 1) - критическая ли точка
// alias - элиас точки - текст
// is_editing - true/false/не передается - форма с "раскрытыми" полями для редактирования
// create_new_point - true/false/не передается - параметр в аттрибутах шаблона, обозначающий что после нажатия "ок" будет создана точка
// can_change_params - true/false/не передается - изменение дополнительных параметров
// is_allowed_edit - true/false/не передается - разрешение на возможность активизации редактирования данных
// draggable - true/false/не передается - может ли точка перемещаться
//function selectPointPlacemark(index, point_text, point_id, is_editing, create_new_point, can_change_params, critical_point, alias, draggable, is_allowed_edit) {
/*
function selectPointPlacemark(params) {

    console.log('site.js selectPointPlacemark');


    if(params['index'] == undefined) {
        params['index'] = '';
    }
    if(params['point_text'] == undefined) {
        params['point_text'] = '';
    }
    if(params['point_id'] == undefined) {
        params['point_id'] = 0;
    }
    if(params['critical_point'] != 1) {
        params['critical_point'] = 0;
    }
    if(params['point_of_arrival'] != 1) {
        params['point_of_arrival'] = 0;
    }
    if(params['alias'] == undefined) {
        params['alias'] = '';
    }
    if(params['is_editing'] != true) {
        params['is_editing'] = false;
    }
    if(params['can_change_params'] != true) {
        params['can_change_params'] = false;
    }
    if(params['is_allowed_edit'] == undefined) {
        params['is_allowed_edit'] = getIsAllowedEditParam();
    }
    if(params['create_new_point'] != true) {
        params['create_new_point'] = false;
    }
    if(params['draggable'] != true) {
        params['draggable'] = false;
    }
    if(params['point_focusing_scale'] == undefined) {
        params['point_focusing_scale'] = 0;
    }


    //console.log('selectPointPlacemark');
    unselectOldPointPlacemark();

    point_placemark = map.geoObjects.get(params['index']);

    var hintContent = params['point_text'] + ' (точка выбрана)';

    var placemarket_template_params = {
        point_text: params['point_text'],
        index: params['index'],
        point_id: params['point_id'],
        critical_point: params['critical_point'],
        point_of_arrival: params['point_of_arrival'],
        alias: params['alias'],
        create_new_point: params['create_new_point'],
        is_editing: params['is_editing'],
        can_change_params: params['can_change_params'],
        is_allowed_edit: params['is_allowed_edit']
    };

    //var balloonContent = getPlacemarketTemplate(point_text, index, point_id, edit, create_new_point, can_change_params, critical_point, alias)
    var balloonContent = getPlacemarketTemplate(placemarket_template_params)
        + ' (точка выбрана)';

    var fio = $.trim($('#client-name').val());
    if(fio == '') {
        fio = 'Выбран';
    }

    point_placemark.properties.set({
        //preset: 'islands#blackStretchyIcon',
        visible: false,
        hintContent: hintContent,
        balloonContent: balloonContent,
        iconContent: fio
    });

    point_placemark.options.unset('iconImageOffset');
    point_placemark.options.unset('iconImageSize');
    point_placemark.options.unset('iconLayout');
    point_placemark.options.unset('iconShape');

    point_placemark.options.set({
        //iconColor: '#1E98FF',
        preset: 'islands#darkGreenStretchyIcon',
        draggable: params['draggable'],
    });
    //point_placemark.balloon.open();

    if(params['point_focusing_scale'] > 0) {
        var coordinates = point_placemark.geometry.getCoordinates();
        map.setCenter(coordinates, params['point_focusing_scale'], {duration: 500});
    }

    return point_placemark;
}
*/

/*
// метод снимает выделение с точки
function unselectOldPointPlacemark() {

    if (point_placemark != null) {

        //var dbSavedPlacemark = point_placemark.options.get('dbSavedPlacemark');

        var balloonContent = point_placemark.properties.get('balloonContent');
        var index = parseIndexFromTemplate(balloonContent);
        var yandex_point_id = parseIdFromTemplate(balloonContent);
        var yandex_point_name = parseNameFromTemplate(balloonContent);

        var hintContent = '<button class="btn-select-placemark hint-btn" placemark-index="' + index + '">Выбрать</button> ' + yandex_point_name;


        var params = {
            point_text: yandex_point_name,
            index: index,
            point_id: yandex_point_id,
            is_allowed_edit: getIsAllowedEditParam()
        };
        //var balloonContent = getPlacemarketTemplate(yandex_point_name, index, yandex_point_id)
        var balloonContent = getPlacemarketTemplate(params)
            + '<button class="btn-select-placemark content-btn" placemark-index="' + index + '">Выбрать</button>';

        point_placemark.properties.set('hintContent', hintContent);
        point_placemark.properties.set('balloonContent', balloonContent);

        if (yandex_point_id == 0) { // вновь созданная точка становиться серой
            point_placemark.options.set({'iconColor': '#BFBFBF'});
        } else {// а у старой точки просто меняются свойства на обычную точку
            point_placemark.options.set({'iconColor': '#1E98FF'});
        }

        point_placemark.options.unset('preset');
        point_placemark.options.unset('draggable');
        point_placemark.properties.unset('iconContent');

        point_placemark.options.set({
            iconLayout: 'islands#circleIcon',
            //iconColor: '#1E98FF',
            iconImageSize: [16, 16],
            iconImageOffset: [-8, -8],
            // Определим интерактивную область над картинкой.
            iconShape: {
                type: 'Circle',
                coordinates: [0, 0],
                radius: 8
            }
        });
    }
}



function createPlacemark(params) {

    console.log('site.js createPlacemark');

    if(params['index'] == undefined) {
        params['index'] = '';
    }
    if(params['point_text'] == undefined) {
        params['point_text'] = '';
    }
    if(params['point_description'] == undefined) {
        params['point_description'] = '';
    }
    if(params['point_id'] == undefined) {
        params['point_id'] = 0;
    }
    if(params['point_lat'] == undefined) {
        params['point_lat'] = 0;
    }
    if(params['point_long'] == undefined) {
        params['point_long'] = 0;
    }
    if(params['is_editing'] != true) {
        params['is_editing'] = false;
    }
    if(params['create_new_point'] != true) {
        params['create_new_point'] = false;
    }
    if(params['to_select'] != true) {
        params['to_select'] = false;
    }
    if(params['can_change_params'] != true) {
        params['can_change_params'] = false;
    }
    if(params['point_of_arrival'] != 1) {
        params['point_of_arrival'] = 0;
    }
    if(params['super_tariff_used'] != 1) {
        params['super_tariff_used'] = 0;
    }
    if(params['critical_point'] != 1) {
        params['critical_point'] = 0;
    }
    if(params['alias'] == undefined) {
        params['alias'] = '';
    }

    if(params['is_temp_point'] != true) {
        params['is_temp_point'] = false;
    }
    if(params['is_base_point'] != true) {
        params['is_base_point'] = false;
    }



    var placemarket_template_params = {
        point_text: params['point_text'],
        point_description: params['point_description'],
        index: params['index'],
        point_id: params['point_id'],
        point_of_arrival: params['point_of_arrival'],
        super_tariff_used: params['super_tariff_used'],
        critical_point: params['critical_point'],
        alias: params['alias'],
        create_new_point: params['create_new_point'],
        is_editing: params['is_editing'],
        can_change_params: params['can_change_params'],
        is_allowed_edit: getIsAllowedEditParam(),
        is_temp_point: params['is_temp_point'],
        is_base_point: params['is_base_point'],
    };

    var balloonContentHeader = '';
    if(params['is_temp_point'] == true) {
        balloonContentHeader = '<div style="width: 100%; background: #f4f4f4; color: #000000;">&nbsp;&nbsp;Создание разовой точки</div>';
    }else if(params['is_base_point']) {
        balloonContentHeader = '<div style="width: 100%; background: #367FA9; color: #FFFFFF;">&nbsp;&nbsp;Создание опорной точки</div>';
    }

    if(params['to_select'] == false) {
        var hintContent = params['point_text'];

        //var balloonContent = getPlacemarketTemplate(params['point_text'], params['index'], params['point_id'], params['is_editing'], params['create_new_point'], params['can_change_params'], params['critical_point'], alias);
        var balloonContent = getPlacemarketTemplate(placemarket_template_params);
    }else {

        //console.log('создаем точку с Выбрать');

        var hintContent = '<button class="btn-select-placemark hint-btn" placemark-index="' + params['index'] + '">Выбрать</button> ' + params['point_text'];
        var balloonContent = getPlacemarketTemplate(placemarket_template_params)
            + '<button class="btn-select-placemark content-btn" placemark-index="' + params['index'] + '">Выбрать</button>';
    }

    //console.log('point_lat='+params['point_lat'] + ' point_long=' + params['point_long']);

    var placemark = new ymaps.Placemark([params['point_lat'], params['point_long']], {
        hintContent: hintContent,
        //balloonContentHeader: '<div style="width: 100%; background: #FF0000; color: #FFFFFF;">qqq</div>',
        balloonContentHeader: balloonContentHeader,
        balloonContent: balloonContent,
    }, {
        iconLayout: 'islands#circleIcon',
        iconColor: '#1E98FF',
        iconImageSize: [16, 16],
        iconImageOffset: [-8, -8],
        // Определим интерактивную область над картинкой.
        iconShape: {
            type: 'Circle',
            coordinates: [0, 0],
            radius: 8
        }
    });

    if(map == null) {
        console.log('map = null');
    }

    map.geoObjects.add(placemark);


    return placemark;
}



var map_html =
    '<div class="map-block">' +
    //'<div class="map-block-header">' +
    //'<button type="button" class="map-block-close">×</button>' +
    //'<span class="map-block-title">Установка точки</span>' +
    //'</div>' +
    '<div class="map-block-body">' +
    '<div class="map-control-block">' +
    '<input type="text" class="search-point form-control" placeholder="Начните ввод адреса..." />' +
    '<div class="search-result-block sw-select-block" style="display: none;"></div>' +
    '</div>' +
    '<div id="ya-map"></div>' +
    '</div>' +
    '</div>';



var map = null;
//var search_placemark = null;
var point_placemark = null;
var point_focusing_scale = 10; // масштаб фокусировки выбранной точки
//var create_temp_point_button = null;

// открытие яндекс-карты с кучей функционала
function openMapWithPointFrom(search) {


    if(search == undefined) {
        search = '';
    }

    map = null;
    point_placemark = null;


    // var direction_id = $('#trip-form').attr('direction-id');
    var direction_id = $('#direction').val();
    if(direction_id == "" || direction_id == null) {
        alert('Необходимо выбрать направление');
        return false;
    }


    if( screen.width <= 480 ) {
        var width = screen.width - 20;
        $('#default-modal').find('.modal-dialog').width(width + 'px');
    }else {
        $('#default-modal').find('.modal-dialog').width('802px');
    }

    $('#default-modal').find('.modal-body').html('<div id="trips-map"></div>').css('padding', '0');
    $('#default-modal .modal-title').html('Выберите точку отправки');
    $('#default-modal').modal('show');

    $('#default-modal').on('hidden.bs.modal', function(e) {
        $('#default-modal').find('.modal-body').css('padding', '15px');
    });
    $('#default-modal').find('.modal-body').html(map_html);
    $('#default-modal').find('.map-block').attr('type-point', 'from');


    //var selected_yandex_point_id = $('input[name="ClientExt[yandex_point_from]"]').val();
    //var yandex_point_from = $('input[name="ClientExt[yandex_point_from]"]').val();
    var selected_yandex_point_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
    //console.log('yandex_point_from='+yandex_point_from);

    $.ajax({
        url: '/direction/ajax-get-direction-map-data?id=' + direction_id + '&from=1',
        type: 'post',
        data: {},
        success: function (response) {

            if (response.city == null) {
                alert('Город не определен');
                return false;
            }

            $('#default-modal .map-block').find('.search-point')
                .attr('city-long', response.city.center_long)
                .attr('city-lat', response.city.center_lat)
                .attr('city-name', response.city.name)
                .attr('city-id', response.city.id)
                .focus();

            //response.city.search_scale - Приближение карты при поиске
            //response.city.point_focusing_scale - Масштаб фокусировки точки
            //response.city.all_points_show_scale - Масшаб отображения всех точек
            point_focusing_scale = response.city.point_focusing_scale;


            ymaps.ready(function(){

                //console.log('создаем карту city.map_scale='+response.city.map_scale);
                map = new ymaps.Map("ya-map", {
                    center: [response.city.center_lat, response.city.center_long],
                    zoom: response.city.map_scale,
                    //type: "yandex#satellite",
                    //controls: []  // Карта будет создана без элементов управления.
                    controls: [
                        'zoomControl',
                        //'searchControl',
                        //'typeSelector',
                        //'routeEditor',  // построитель маршрута
                        'trafficControl' // пробки
                        //'fullscreenControl'
                    ]
                });

                //console.log('map.zoom=' + map.getZoom());

                map.events.add('boundschange', function (event) {
                    //console.log('oldZoom='+event.get('oldZoom') + ' newZoom=' + event.get('newZoom'));
                    // response.city.point_focusing_scale
                    showHidePlacemarks(map, event.get('newZoom'), response.city.all_points_show_scale)
                });

                //var searchControl = map.controls.get('searchControl');
                //searchControl.options.set('provider', 'yandex#search');
                //console.log('yandex_points:'); console.log(response.yandex_points);

                // Множество существующих точек
                for (var key in response.yandex_points) { // только базовые точки в списке

                    var yandex_point = response.yandex_points[key];

                    var index = map.geoObjects.getLength();
                    //var placemark = createPlacemark(index, yandex_point.name, yandex_point.id, yandex_point.lat, yandex_point.long);
                    var create_placemark_params = {
                        index: index,
                        point_text: yandex_point.name,
                        point_id: yandex_point.id,
                        point_lat: yandex_point.lat,
                        point_long: yandex_point.long,
                        //is_editing: true,
                        //create_new_point: true,
                        to_select: true,
                        can_change_params: false,
                        //critical_point: yandex_point.critical_point,
                        //alias: yandex_point.alias
                    };
                    var placemark = createPlacemark(create_placemark_params);


                    if (yandex_point.id == selected_yandex_point_id) {
                        // установка point_placemark


                        var select_point_placemark_params = {
                            index: index,
                            point_text: yandex_point.name,
                            point_id: yandex_point.id,
                            //is_editing: true,
                            //create_new_point: true,
                            can_change_params: false,
                            //critical_point: yandex_point.critical_point,
                            //alias: yandex_point.alias,
                            draggable: false,
                            is_allowed_edit: false,
                            point_focusing_scale: point_focusing_scale
                        }
                        selectPointPlacemark(select_point_placemark_params);

                        //selectPointPlacemark(index, yandex_point.name, yandex_point.id, null, null, null, null, null, false);

                        var coordinates = placemark.geometry.getCoordinates();
                        map.setCenter(coordinates, response.city.map_scale, {duration: 500});
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
}



// нажатие на "выбрать на карте" для яндекс-точки "откуда"
$(document).on('click', '#select-yandex-point-from', function() {
    openMapWithPointFrom();
    return false;
});

function openMapWithPointTo(search) {

    if(search == undefined) {
        search = '';
    }

    map = null;
    //var create_base_point_button = null;
    point_placemark = null;


    var direction_id = $('#trip-form').attr('direction-id');
    if(direction_id.length == 0 || direction_id == 0) {
        alert('Необходимо выбрать направление');
        return false;
    }


    $('#default-modal').find('.modal-dialog').width('802px');
    $('#default-modal').find('.modal-body').html('<div id="trips-map"></div>').css('padding', '0');
    $('#default-modal .modal-title').html('Выберите точку прибытия');
    $('#default-modal').modal('show');

    $('#default-modal').on('hidden.bs.modal', function(e) {
        $('#default-modal').find('.modal-body').css('padding', '15px');
    });
    $('#default-modal').find('.modal-body').html(map_html);
    $('#default-modal').find('.map-block').attr('type-point', 'to');

    var yandex_point_to = $('input[name="ClientExt[yandex_point_to]"]').val();

    if(yandex_point_to != '') {
        var yandex_point_to_data = yandex_point_to.split('_');
        var selected_yandex_point_id = parseInt(yandex_point_to_data[0]);
        var selected_yandex_point_to_lat = yandex_point_to_data[1];
        var selected_yandex_point_to_long = yandex_point_to_data[2];
        var selected_yandex_point_to_name = yandex_point_to_data[3];

        //console.log('selected_yandex_point_id='+selected_yandex_point_id);
    }


    $.ajax({
        url: '/direction/ajax-get-direction-map-data?id=' + direction_id + '&from=0',
        type: 'post',
        data: {},
        success: function (response) {

            if (response.city == null) {
                alert('Город не определен');
                return false;
            }

            $('#default-modal .map-block').find('.search-point')
                .attr('city-long', response.city.center_long)
                .attr('city-lat', response.city.center_lat)
                .attr('city-name', response.city.name)
                .attr('city-id', response.city.id)
                .focus();

            //response.city.search_scale - Приближение карты при поиске
            //response.city.point_focusing_scale - Масштаб фокусировки точки
            //response.city.all_points_show_scale - Масшаб отображения всех точек
            point_focusing_scale = response.city.point_focusing_scale;


            ymaps.ready(function(){

                //console.log('создаем карту city.map_scale='+response.city.map_scale);
                map = new ymaps.Map("ya-map", {
                    center: [response.city.center_lat, response.city.center_long],
                    zoom: response.city.map_scale,
                    //type: "yandex#satellite",
                    //controls: []  // Карта будет создана без элементов управления.
                    controls: [
                        'zoomControl',
                        //'searchControl',
                        //'typeSelector',
                        //'routeEditor',  // построитель маршрута
                        'trafficControl' // пробки
                        //'fullscreenControl'
                    ]
                });

                map.events.add('boundschange', function (event) {
                    showHidePlacemarks(map, event.get('newZoom'), response.city.all_points_show_scale)
                });


                // Множество существующих точек
                for (var key in response.yandex_points) { // только базовые точки в списке

                    var yandex_point = response.yandex_points[key];

                    var index = map.geoObjects.getLength();
                    //var placemark = createPlacemark(index, yandex_point.name, yandex_point.id, yandex_point.lat, yandex_point.long);
                    var create_placemark_params = {
                        index: index,
                        point_text: yandex_point.name,
                        point_id: yandex_point.id,
                        point_lat: yandex_point.lat,
                        point_long: yandex_point.long,
                        //is_editing: true,
                        //create_new_point: true,
                        to_select: true,
                        can_change_params: false,
                        //critical_point: yandex_point.critical_point,
                        //alias: yandex_point.alias
                    };
                    var placemark = createPlacemark(create_placemark_params);


                    if (yandex_point.id == selected_yandex_point_id) {
                        // установка point_placemark


                        var select_point_placemark_params = {
                            index: index,
                            point_text: yandex_point.name,
                            point_id: yandex_point.id,
                            //is_editing: true,
                            //create_new_point: true,
                            can_change_params: false,
                            //critical_point: yandex_point.critical_point,
                            //alias: yandex_point.alias,
                            draggable: false,
                            is_allowed_edit: false,
                            point_focusing_scale: point_focusing_scale
                        }
                        selectPointPlacemark(select_point_placemark_params);

                        var coordinates = placemark.geometry.getCoordinates();
                        map.setCenter(coordinates, response.city.map_scale, {duration: 500});
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
}
 */

/* позже закомментируй эту функцию где-то после 04.10.2019  */
/*
$(document).on('click', '.btn-select-placemark', function() {

    if(map != null) {

        var type_point = $('#default-modal').find('.map-block').attr('type-point');

        var index = $(this).attr('placemark-index');
        var placemark = map.geoObjects.get(index);

        // в hintContent и balloonContent прячу кнопки "Выбрать"
        var balloonContent = placemark.properties.get('balloonContent');
        var yandex_point_id = parseIdFromTemplate(balloonContent);
        var yandex_point_name = parseNameFromTemplate(balloonContent);
        var draggable = getDraggable(yandex_point_id);

        // critical_point=1 alias=airport
        // critical_point=0 alias=
        var critical_point = parseCriticalPointFromTemplate(balloonContent);
        var alias = parseAliasFromTemplate(balloonContent);
        // console.log('critical_point='+critical_point+' alias='+alias);

        // эта функция работает только для точки Откуда
        if(critical_point == "1") {
            var label = '';
            if(alias == "airport") {
                label = 'Время регистрации авиарейса';
            }else {
                label = 'Время отправления поезда';
            }

            $('#time_air_train_arrival_label').html(label);
            $('#time_air_train_arrival_block').show();
        }

        //alert('yandex_point_name='+yandex_point_name);

        var select_point_placemark_params = {
            index: index,
            point_text: yandex_point_name,
            point_id: yandex_point_id,
            is_editing: false,
            //create_new_point: false,
            can_change_params: false,
            //critical_point: critical_point,
            //alias: alias,
            draggable: draggable
            //is_allowed_edit: is_allowed_edit
        }
        if(typeof point_focusing_scale != "undefined") {
            select_point_placemark_params.point_focusing_scale = point_focusing_scale;
        }
        selectPointPlacemark(select_point_placemark_params);
        //selectPointPlacemark(index, yandex_point_name, yandex_point_id, false, null, false, null, null, draggable);


        // if($('#default-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа
        //
        //     // обновление поля "откуда" в форме создания заказа
        //     var coordinates = placemark.geometry.getCoordinates();
        //     var lat = coordinates[0];
        //     var long = coordinates[1];
        //     var key = yandex_point_id + '_' + lat + '_' + long + '_' + yandex_point_name;
        //
        //     if(type_point == 'from') {
        //         selectWidgetInsertValue($('input[name="ClientExt[yandex_point_from_id]"]').parents('.sw-element'), key, yandex_point_name);
        //     }else {
        //         selectWidgetInsertValue($('input[name="ClientExt[yandex_point_to_id]"]').parents('.sw-element'), key, yandex_point_name);
        //     }
        //
        //     $('#default-modal').find('.close').click();
        //
        // }else {  // иначе вызывается из админки
        //
        // }

        if($('#search-place-from').length > 0) {

            $('#search-place-from').val(yandex_point_name);

            $('input[name="ClientExt[yandex_point_from_id]"]').val(yandex_point_id);
            //alert('Показываем А-ВРПТ точки');
            var client_ext_id = $('#order-client-form').attr('client-ext-id');

            $(".selecting-trip").removeAttr("trip-id").removeAttr("travel_time_h").removeAttr("travel_time_m").html("");
            $('#map-text').html("");

            $.ajax({
                url: '/client-ext/ajax-trips-time-confirm?client_ext_id=' + client_ext_id + '&yandex_point_from_id=' + yandex_point_id,
                type: 'post',
                data: {},
                success: function (response) {

                    var has_elems = false;
                    for(var key in response) {
                        has_elems = true;
                        var trip_obj = response[key];
                        var str = '';
                        if(trip_obj.data != undefined) {
                            str += "<span class='trip-data'>" + trip_obj.data + "</span><br />";
                        }
                        str += "<span class='trip-time'>" + trip_obj.time + "</span>";
                        var i = 1 + parseInt(key);
                        $('#trip-time-confirm-' + i).html(str)
                            .attr('trip-id', trip_obj.trip_id)
                            .attr('travel_time_h', trip_obj.travel_time_h)
                            .attr('travel_time_m', trip_obj.travel_time_m);
                    }

                    if(has_elems == true) {
                        $('#select-trip-list').show();
                        $('#map-text').html("<br />Выберите время посадки на указанной точке:");
                    }else {
                        $('#select-trip-list').hide();
                        $('#map-text').html("<br />На выбранной точке к сожалению нельзя сесть. Выберите пожалуйста другую точку.");
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
        }

    }
});*/

/*

// нажатие на "выбрать на карте" для яндекс-точки "откуда"
// $(document).on('click', '#select-yandex-point-from', function() {
//
//     if($('#default-modal').length > 0) {
//         $('#default-modal').find('.close').click();
//     }
//     openMapWithPointFrom();
//     return false;
// });

// нажатие на "выбрать на карте" для яндекс-точки "откуда"
$(document).on('click', '#select-yandex-point-to', function() {

    if($('#default-modal').length > 0) {
        $('#default-modal').find('.close').click();
    }
    openMapWithPointTo();
    return false;
});


//
$(document).on('click', '.modal-prev', function() {

    var enter_mobile = $(this).attr('prev-modal');

    switch(enter_mobile) {
        case 'enter-mobile':
            clearAndHideMobileRegForms();
            //$('#enter-mobile').show();
            //$('#enter-mobile').iziModal('open');
            break;
        case 'enter_password-mobile':
            clearAndHideMobileRegForms();
            var phone = $(this).attr('phone');
            openInsertPassword(phone, 1);
            break;
        // case 'restorepassword-mobile':
        //     clearAndHideMobileRegForms();
        //     break;
        // case 'registration-mobile':
        //     clearAndHideMobileRegForms();
        //     break;
        case 'entersmscode-mobile':
            clearAndHideMobileRegForms();
            var reg_code = $(this).attr('reg_code');
            var client_ext_id = $(this).attr('client_ext_id');
            openInputCodeForm(reg_code, client_ext_id, 1);
            break;
        case 'close': //close

            clearAndHideMobileRegForms();
            break;
    }

});

$(document).on('click', '.modal-close', function() {
    clearAndHideMobileRegForms();
    return false;
});

 */


/*
function getVRPT(yandex_point_from_id, trip_id, callback_function) {

    $.ajax({
        url: '/client-ext/ajax-get-time-confirm?yandex_point_from_id=' + yandex_point_from_id + '&trip_id=' + trip_id,
        type: 'post',
        data: {},
        success: function (response) {
            callback_function(response);
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
}*/

/*
$(document).on('change', 'input[name="ClientExt[yandex_point_from]"]', function() {

    var yandex_point_from = $('input[name="ClientExt[yandex_point_from]"]').val();

    var yandex_point_from_name = $('input[name="ClientExt[yandex_point_from]"]').parents('.sw-element').find('.sw-value').text();
    if(yandex_point_from_name != "") {

        var yandex_point_from_params = yandex_point_from.split('_');
        var yandex_point_from_id = yandex_point_from_params[0];
        var trip_id = $('#trip-form').attr('trip-id');

        // посылается запрос на сервер чтобы получить(рассчитать) автоматическое ВРПТ
        getVRPT(yandex_point_from_id, trip_id, function(response) {
            //console.log('response:'); console.log(response);

            if(response.time_confirm_str != '') {
                $('#point-from-name').text(yandex_point_from_name);
                $('#time-confirm').text(response.time_confirm_str);
                $('#final-text').show(250);
            }else {
                $('#final-text').hide();
            }
        });

    }else {
        $('#final-text').hide();
    }

});
*/

/*
$(document).on('click', '#make-simple-payment', function() {

    // var summ = $.trim($('#payment-summ').val());
    // var float_summ = parseFloat(summ);
    // if(summ == '' || isNaN(float_summ) || float_summ <= 0) {
    //     alert('Неправильное значение в поле сумма оплаты');
    //     return false;
    // }

    var client_ext_id = $(this).attr('client-ext-id');

    $.ajax({
        //url: '/yandex-payment/payment/ajax-make-simple-payment?client_ext_id=' + client_ext_id + '&summ=' + float_summ,
        url: '/yandex-payment/payment/ajax-make-simple-payment?client_ext_id=' + client_ext_id,
        type: 'post',
        data: {},
        success: function (response) {
            if (response.success === true) {
                //console.log('response:'); console.log(response);
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
});
*/