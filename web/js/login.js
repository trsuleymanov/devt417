

// перехват автопроверок полей формы
$(document).on('ajaxBeforeSend', '#login-form', function(event, jqXHR, textStatus) {
    // очищаем ошибки формы
    //$('#login-form').yiiActiveForm('updateMessages', {
    //    //'bonuscardssettings-work_with_service_products': ['Ошибка']
    //}, true);

    alert('ajaxBeforeSend');
});

// перехват автопроверок полей формы
$(document).on('ajaxBeforeSend', '#login-form', function(event, jqXHR, textStatus) {
    // очищаем ошибки формы
    //$('#login-form').yiiActiveForm('updateMessages', {
    //    //'bonuscardssettings-work_with_service_products': ['Ошибка']
    //}, true);

    alert('ajaxBeforeSend');
});