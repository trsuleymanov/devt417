


// загрузка списка
function pointLoadList(obj) {

    var search = $.trim(obj.next('.psw-outer-block').find('.psw-search').val());
    var current_value = obj.find('input[type="hidden"]').val();
    //var element_name = getYiiFieldName(obj);
    var element_id = obj.find('input[type="hidden"]').attr('id');


    // передаваемые значения в ajax-запрос по умолчанию
    var data = {
        search: search
    };

    // получим набор передаваемых значений для ajax-запроса из вызова виджета, если таковой был задан (параметр ['ajax']['data'])
    if(psw_setting[element_id].ajax_data != undefined) {
        var ajax_data_expression = psw_setting[element_id].ajax_data; // получили
        data = ajax_data_expression(data, obj);           // применили
    }

    $.ajax({
        url: psw_setting[element_id].ajax_url,
        type: "POST",
        data: data,
        success: function (response) {

            var html = '';

            //console.log('resp:'); console.log(response);

            if (response.results.length > 0) {
                var group_name = '';
                var elem = null;
                var is_simple_list = false;
                var critical_point = 0;
                var alias = "";

                if(void 0 !== response.results[0]['children']) { // значит это список с делением по группам

                    //html += '<li class="empty-value" value="">Удалить значение</li>';
                    for(var key in response.results) {

                        group_name = response.results[key].text;

                        critical_point = response.results[key].critical_point;
                        alias = response.results[key].alias;

                        html += '<li class="section-list" alias="' + alias + '" critical_point="' + critical_point + '"><strong>' + group_name + '</strong><ul class="simple-list">';
                        if(response.results[key].children.length > 0) {
                            for(var key2 in response.results[key].children) {
                                elem = response.results[key].children[key2];

                                if(elem.id == current_value) {
                                    html += '<li value="' + elem.id + '" aria-selected="true" alias="' + elem.alias + '" critical_point="' + elem.critical_point + '">' + elem.text + '</li>';
                                }else {
                                    html += '<li value="' + elem.id + '" alias="' + elem.alias + '" critical_point="' + elem.critical_point + '">' + elem.text + '</li>';
                                }
                            }
                        }
                        html += '</ul></li>';
                    }

                }else { // обычный простой линейный список
                    is_simple_list = true;
                    //html += '<li class="empty-value" value="">Удалить значение</li>';
                    for(var key in response.results) {

                        critical_point = response.results[key].critical_point;
                        alias = response.results[key].alias;

                        if(response.results[key].id == current_value) {
                            html += '<li value="' + response.results[key].id + '" aria-selected="true" alias="' + alias + '" critical_point="' + critical_point + '">' + response.results[key].text + '</li>';
                        }else {
                            html += '<li value="' + response.results[key].id + '" alias="' + alias + '" critical_point="' + critical_point + '">' + response.results[key].text + '</li>';
                        }
                    }
                }

            }else {
                if(psw_setting[element_id].add_new_value_url != undefined) {
                    html = '<li class="empty-value">Не найдено <a id="add-new-value" data-toggle="tooltip" title="Добавить новое значение"><i class="glyphicon glyphicon-plus-sign">&nbsp;</i></a></li>';
                }else {
                    html = '<li class="empty-value">Не найдено</li>';
                }
                is_simple_list = true;
            }

            if(html != '') {
                html = '<ul class="main-list ' + (is_simple_list ? 'simple-list' : '') + '">' + html + '</ul>';
                obj.next('.psw-outer-block').find('.psw-select-block').html(html);
                obj.next('.psw-outer-block').find('.psw-select-block').show();
            }


            if(psw_setting[element_id].afterRequest != undefined) {
                psw_setting[element_id].afterRequest(response);
            }
        },
        error: function (data, textStatus, jqXHR) {
            // сворачиваем виджет до первоначального вида и отображаем ошибку
            pointToggleSelect(obj, false);

            //var field_name = getYiiFieldName(obj);
            if(textStatus == 'error')
            {
                if (void 0 !== data.responseJSON) {
                    if (data.responseJSON.message.length > 0) {
                        //$(obj).parents('form').yiiActiveForm('updateAttribute', field_name, [data.responseJSON.message]);
                        alert(data.responseJSON.message);
                    }
                } else {
                    if (data.responseText != undefined &&  data.responseText.length > 0) {
                        //$(obj).parents('form').yiiActiveForm('updateAttribute', field_name, [data.responseText]);
                        alert(data.responseText);
                    }
                }
            }
        }
    });
}

// открытие ссылки (открытие окна)
function pointOpenLink(obj) {

    //var element_name = getYiiFieldName(obj);
    var element_id = obj.find('input[type="hidden"]').attr('id');

    // запустим переданную из-вне функцию чтобы получить её результат
    var open_url = '';
    if(psw_setting[element_id].open_url != undefined) {
        var ajax_data_expression = psw_setting[element_id].open_url; // получили
        open_url = ajax_data_expression(open_url);           // применили
    }

    return window.open(open_url);
}


// открытие/закрытие списка с поиском
function pointToggleSelect(obj, set_state) {

    var psw_block = obj.next('.psw-outer-block');
    var search_obj = psw_block.find('.psw-search');
    //var element_name = getYiiFieldName(obj);
    var element_id = obj.find('input[type="hidden"]').attr('id');

    if(obj.find('input[type="hidden"]').attr('disabled') != undefined) {
        return false;
    }
    if(element_id == undefined) {
        return false;
    }

    // console.log('element_id='+element_id);
    // console.log('psw_setting:'); console.log(psw_setting);


    if (set_state != undefined) {
        if (set_state == true)
            psw_setting[element_id].psw_is_open = false;
        else if(set_state == false) {
            psw_setting[element_id].psw_is_open = true;
        }
    }


    //console.log('psw_setting:'); console.log(psw_setting);
    if(psw_setting[element_id].psw_is_open == false) {

        $('.psw-outer-block').hide();
        $('.psw-search').val('');
        for(var key in psw_setting) {
            psw_setting[key].psw_is_open = false;
        }

        // открываем поиск со списком
        psw_block.show();
        search_obj.focus();
        psw_setting[element_id].psw_is_open = true;
        pointLoadList(obj);

    }else {
        // закрываем поиск со списком
        psw_block.hide();
        search_obj.val('');
        psw_setting[element_id].psw_is_open = false;

        //var field_name = getYiiFieldName(obj);
        //if(field_name.length > 0) {
        //    //console.log('отправлен запрос на проверку валидности field_name='+field_name);
        //    obj.parents('form').yiiActiveForm('validateAttribute', field_name);
        //}
    }
}


// Добавление значение в результат поиска (в виджет)
function pointSelectWidgetInsertValue(obj, value, text, critical_point, alias)
{
    if(value != '') {
        obj.find('.simple-list li[aria-selected="true"]').attr('aria-selected', "false");
        obj.find('.simple-list li[value="' + value + '"]').attr('aria-selected', "true");

        obj.find('.psw-text .psw-value').html(text);
        obj.find('.psw-text .psw-delete').show();
        obj.find('.psw-text .psw-open').show();

        if(void 0 !== critical_point) {
            obj.find('input[type="hidden"]').attr('critical_point', critical_point);
        }
        if(void 0 !== alias) {
            obj.find('input[type="hidden"]').attr('alias', alias);
        }
        obj.find('input[type="hidden"]').val(value).change();

    }else {
        obj.find('.simple-list li[aria-selected="true"]').attr('aria-selected', "false");
        obj.find('.psw-delete').hide();
        obj.find('.psw-open').hide();
        obj.find('.psw-value').html('');
        obj.find('input[type="hidden"]').attr('critical_point', 0);
        obj.find('input[type="hidden"]').attr('alias', '');
        obj.find('input[type="hidden"]').val('').change();
    }
    pointToggleSelect(obj, false);

    //var element_name = getYiiFieldName(obj);
    var element_id = obj.find('input[type="hidden"]').attr('id');
    if(element_id == undefined) {
        return false;
    }

    if(psw_setting[element_id].afterChange != undefined) {
        psw_setting[element_id].afterChange(obj, value, text);
    }

    return false;
}

// щелчек где-либо на странице закрывает виджет
$(document).on('click', function() {
    $('.psw-element').each(function() {
        pointToggleSelect($(this), false);
    });
});


// щелчек на поле виджета "раскрывает" поле
$(document).on('click', '.psw-element', function() {
    pointToggleSelect($(this));
    return false;
});

$(document).on('click', '.psw-search', function() {
    return false;
});

// написание в поле поиска обновляет результаты поиска
$(document).on('keyup', '.psw-search', function() {
    //pointLoadList($(this).parents('.psw-outer-block').prev('.psw-element'));
});
$(document).on('keydown', '.psw-search', function(e) {

    if(e.keyCode == 13) {
        //var $obj = $(this).parents('.psw-outer-block').prev('.psw-element');
        //pointSelectWidgetInsertValue($obj, "0", $(this).val());
        return false;
    }else {
        pointLoadList($(this).parents('.psw-outer-block').prev('.psw-element'));
    }
});



// выбор элемента в списке
$(document).on('click', '.psw-outer-block .simple-list li:not(.empty-value)', function() {

    var value = $(this).attr('value');
    var text =  $(this).text();
    var critical_point = $(this).attr('critical_point');
    var alias = $(this).attr('alias');

    //alert('critical_point='+critical_point+' alias='+alias);

    var obj = $(this).parents('.sw-outer-block').prev('.psw-element');
    pointSelectWidgetInsertValue(obj, value, text, critical_point, alias);

    //return false;
});


// удаление выбранного элемента
$(document).on('click', '.psw-element:not([disabled]) .psw-delete', function()
{
    var obj = $(this).parents('.psw-element');

    pointSelectWidgetInsertValue(obj, '');

    return false;
});

// щелчек по "глазу" открывает ссылку
$(document).on('click', '.sw-open', function()
{
    var obj = $(this).parents('.psw-element');

    pointOpenLink(obj);

    return false;
});


$(document).on('click', '#add-new-value', function() {

    var obj = $(this).parents('.psw-outer-block').prev('.psw-element');
    var element_id = obj.find('input[type="hidden"]').attr('id');

    var url = '';
    var ajax_data_expression = psw_setting[element_id].add_new_value_url; // получили
    var url = ajax_data_expression(url);                             // применили

    if(url != undefined) {
        $.ajax({
            url: url,
            type: "POST",
            data: {},
            success: function (response) {
                var html = '';
                if (response.success == true) {
                    pointSelectWidgetInsertValue(obj, response.point.id, response.point.name);
                }
            },
            error: function (data, textStatus, jqXHR) {
                if (textStatus == 'error') {
                    if (void 0 !== data.responseJSON) {
                        if (data.responseJSON.message.length > 0) {
                            alert(data.responseJSON.message);
                        }
                    } else {
                        if (data.responseText.length > 0) {
                            alert(data.responseText);
                        }
                    }
                }
            }
        });
    }

    return false;
});


$(document).on('click', '.psw-element[attribute-name="DetailMeasurementValue[name]"]', function() {

    var errors = new Array();

    var model_id = parseInt($('*[name="NomenclatureDetail[model_id]"]').val());
    if(model_id == 0) {
        errors[errors.length] = "Необходимо выбрать Принадлежность. ";
    }

    var name = $('*[name="NomenclatureDetail[name]"]').val();
    if(name == '') {
        errors[errors.length] = "Необходимо выбрать Наименование з/ч. ";
    }

    //var installation_place = parseInt($('*[name="NomenclatureDetail[installation_place]"]').val());
    //if(installation_place == 0) {
    //    errors[errors.length] = "Необходимо выбрать Место установки. ";
    //}

    //var installation_side = parseInt($('*[name="NomenclatureDetail[installation_side]"]').val());
    //if(installation_side == 0) {
    //    errors[errors.length] = "Необходимо выбрать Сторону установки. ";
    //}

    if(errors.length > 0) {
        var str_errors = '';
        for(var i = 0; i < errors.length; i++) {
            str_errors += errors[i] + ' ';
        }
        alert(str_errors);

        return false;
    }
});