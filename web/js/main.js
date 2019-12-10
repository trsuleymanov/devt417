 /* js-код используемый и на сайте, и в админке */


$(document).ready(function() {


});

// format date_str - 'dd.mm.YYYY' (30.01.2017)
function getDateObject(date_str) {

    var objDate = new Date(parseInt(date_str.substr(6, 4)), parseInt(date_str.substr(3, 2)) - 1, parseInt(date_str.substr(0, 2)));

    return objDate;
}

function getWeekDay(objDate)
{
    var weekDayNum = objDate.getDay();

    var weekDay = '';
    switch (weekDayNum) {
        case 0:
            weekDay = 'воскресенье';
            break;
        case 1:
            weekDay = 'понедельник';
            break;
        case 2:
            weekDay = 'вторник';
            break;
        case 3:
            weekDay = 'среда';
            break;
        case 4:
            weekDay = 'четверг';
            break;
        case 5:
            weekDay = 'пятница';
            break;
        case 6:
            weekDay = 'суббота';
            break;
    }

 return weekDay;
}

// Функция первую букву строки string переводит в верхний регистр
function toUpperCaseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// использование Math.round() даст неравномерное распределение!
function getRandomInt(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


// функция возвращает окончания строки перед которой указано число. Например 7 заказ'ов'
function getStringWithEnd(num, zero_string, one_string, two_string) {

    var string = '';

    // получаем последнюю цифру числа
    var str_num = '' + num;
    var finish_number = str_num[(str_num.length - 1)];

    //console.log('num=' + num + ' finish_number='+finish_number);
    if(finish_number == 0 || finish_number == 5 || finish_number == 6 || finish_number == 7
        || finish_number == 8 || finish_number == 9) {
        string = zero_string;
    }else {
        if(num >= 10) {
            var prev_finish_number = str_num[(str_num.length - 2)];
            if(prev_finish_number == 1) {
                string = zero_string;
            }else {
                if(finish_number == 1) {
                    string = one_string;
                }else { // остались 2,3,4
                    string = two_string;
                }
            }
        }else {
            if(finish_number == 1) {
                string = one_string;
            }else { // остались 2,3,4
                string = two_string;
            }
        }
    }

    return string;
}



/* **********   ФУНКЦИИ ДЛЯ ЯНДЕКС-КАРТЫ    **************/

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


// функция возвращает html-контент для точки

// is_editing - true/false/не передается - форма с "раскрытыми" полями для редактирования
// can_change_params - true/false/не передается - изменение дополнительных параметров
// is_allowed_edit - true/false/не передается - разрешение на возможность активизации редактирования данных
// create_new_point - true/false/не передается - параметр в аттрибутах шаблона, обозначающий что после нажатия "ок" будет создана точка

// point_text - текст яндекс-точки
// index - индекс элемента на карте (point_placemark = map.geoObjects.get(index);)
// point_id - id точки
// critical_point - true/false  (была 1) - критическая ли точка
// alias - элиас точки - текст

// function getPlacemarketTemplate(point_text, index, point_id, is_editing, create_new_point, can_change_params, critical_point, alias) {
/*
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
         //'<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
         //'<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
         '<input class="input-placemark" style="display: none;" type="text" value="' + params['point_text'] + '" />' +
         '<span class="span-placemark not-edit"> ' + params['point_text'] + '</span>' +
         '</div>';

 }else if(params['is_editing'] == true) {

     var content =
         '<div class="placemark-balloon-content" index="' + params['index'] + '" yandex-point-id="' + params['point_id'] + '" create-new-point="' + params['create_new_point'] + '">';
     //if(params['can_change_params'] == true) {
     //
     //    content +=  '<input class="point-of-arrival" type="checkbox" ' + (params['point_of_arrival'] == true ? "checked" : "") + ' /> является точкой прибытия <br />' +
     //        '<input class="critical-point" type="checkbox" ' + (params['critical_point'] == true ? "checked" : "") + ' /> критическая точка <br />' +
     //        '<input class="alias" type="text" value="' + params['alias'] + '" placeholder="airport" /><br />';
     //}
     content +=
         // '<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
         // '<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
         '<input class="input-placemark" type="text" value="' + params['point_text'] + '" />' +
         '<button class="ok-placemark">Ок</button>' +
         '<span class="span-placemark" style="display: none;">' + params['point_text'] + '</span>' +
         '</div>';

 }else {

     var content =
         '<div class="placemark-balloon-content" index="' + params['index'] + '" yandex-point-id="' + params['point_id'] + '" create-new-point="' + params['create_new_point'] + '">';

     //if(params['can_change_params'] == true) {
     //    content +=  '<input class="point-of-arrival" type="checkbox" ' + (params['point_of_arrival'] == true ? "checked" : "") + ' /> является точкой прибытия <br />' +
     //        '<input class="critical-point" type="checkbox" ' + (params['critical_point'] == true ? "checked" : "") + ' /> критическая точка <br />' +
     //        '<input class="alias" type="text" value="' + params['alias'] + '" placeholder="airport" /><br />';
     //}

     content +=
         // '<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
         // '<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
         '<input class="input-placemark" style="display: none;" type="text" value="' + params['point_text'] + '" />' +
         '<button class="ok-placemark" style="display: none;">Ок</button>' +
         '<span class="span-placemark">' + params['point_text'] + '</span>' +
         '</div>';

 }

 return content;
}
*/

// function parseCriticalPointFromTemplate(content) {
//
//     var pos_start = content.indexOf('critical-point');
//     var text = content.substring(pos_start);
//     var pos_start = text.indexOf('>') + 1;
//     var text = text.substring(pos_start);
//     var pos_end = text.indexOf('</span>');
//     var text = text.substring(0, pos_end);
//
//     return text;
// }
//
// function parseAliasFromTemplate(content) {
//
//     var pos_start = content.indexOf('alias');
//     var text = content.substring(pos_start);
//     var pos_start = text.indexOf('>') + 1;
//     var text = text.substring(pos_start);
//     var pos_end = text.indexOf('</span>');
//     var text = text.substring(0, pos_end);
//
//     return text;
// }

/*
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
*/

// сохранение изменений в данных точки в полях формы создания/редактирования заказа
function updateOrderFormYandexPoint(point_from, point_id, point_lat, point_long, point_name) {
    var name = point_id + '_' + point_lat + '_' + point_long + '_' + point_name;

    if(point_from == true) {
        $('input[name="Order[yandex_point_from]"]').val(name);
    }else {
        $('input[name="Order[yandex_point_to]"]').val(name);
    }
}



// создание точки на карте
//function createPlacemark(index, point_text, point_id, point_lat, point_long, is_editing, create_new_point, to_select, can_change_params, critical_point, alias) {
//var create_placemark_params = {
//    index: index,
//    point_text: point_text,
//    point_id: point_id,
//    point_lat: point_lat,
//    point_long: point_long,
//    is_editing: is_editing,
//    create_new_point: create_new_point,
//    to_select: to_select,
//    can_change_params: can_change_params,
//    critical_point: critical_point,
//    alias: alias
//};

/*
function createPlacemark(params) {
 //console.log('can_change_params='+can_change_params);

 //var create_placemark_params = {
 //    index: index,
 //    point_text: yandex_point.name,
 //    point_id: yandex_point.id,
 //    point_lat: yandex_point.lat,
 //    point_long: yandex_point.long,
 //    //is_editing: true,
 //    //create_new_point: true,
 //    //to_select: false,
 //    //can_change_params: false,
 //    //critical_point: yandex_point.critical_point,
 //    //alias: yandex_point.alias
 //};

 if(params['index'] == undefined) {
     params['index'] = '';
 }
 if(params['point_text'] == undefined) {
     params['point_text'] = '';
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
     index: params['index'],
     point_id: params['point_id'],
     point_of_arrival: params['point_of_arrival'],
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
     var hintContent = '<button class="btn-select-placemark hint-btn" placemark-index="' + params['index'] + '">Выбрать</button> ' + params['point_text'];
     var balloonContent = getPlacemarketTemplate(placemarket_template_params)
         + '<button class="btn-select-placemark content-btn" placemark-index="' + params['index'] + '">Выбрать</button>';
 }

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

 map.geoObjects.add(placemark);

 placemark.events
     .add('dragend', function (event) {

         var coordinates = point_placemark.geometry.getCoordinates();
         var balloonContent = point_placemark.properties.get('balloonContent');
         var index = parseIndexFromTemplate(balloonContent);
         var yandex_point_id = parseIdFromTemplate(balloonContent);

         if(yandex_point_id > 0) {
             //updateYandexPoint(index, yandex_point_id, null, coordinates[0], coordinates[1]);
             var update_yandex_point_params = {
                 index: index,
                 point_id: yandex_point_id,
                 lat: coordinates[0],
                 long: coordinates[1]
             };
             updateYandexPoint(update_yandex_point_params);
         }
         if($('#order-create-modal').length > 0) {
             var point_name = parseNameFromTemplate(balloonContent);
             updateOrderFormYandexPoint(true, yandex_point_id, coordinates[0], coordinates[1], point_name)
         }
     })
     .add('mouseenter', function (e) {
         e.get('target').options.set('iconColor', '#56DB40');

     })
     .add('mouseleave', function (e) {
         e.get('target').options.unset('iconColor');
     });

   return placemark;
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

    console.log('main.js selectPointPlacemark');

 //select_point_placemark_params = {
 //    index: index,
 //    point_text: point_text,
 //    point_id: point_id,
 //    is_editing: is_editing,
 //    create_new_point: create_new_point,
 //    can_change_params: can_change_params,
 //    critical_point: critical_point,
 //    alias: alias,
 //    draggable: draggable,
 //    is_allowed_edit: is_allowed_edit
 //}

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
                 placemark.options.set('visible', false);
             }
         })
     } else { // отображаю все точки кроме выбранной
         current_map.geoObjects.each(function (placemark, i) {
             if (i != point_placemark_index) {
                 placemark.options.set('visible', true);
             }
         })
     }
 }
}

 // функция создания яндекс-точки
 //function createYandexPoint(placemark, can_change_params, critical_point, alias) {
function createYandexPoint(placemark, params) {

 //var create_yandex_point_params = {
 //    can_change_params: can_change_params,
 //    point_of_arrival: point_of_arrival,
 //    critical_point: critical_point,
 //    alias: alias
 //};

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



    if($('#order-create-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа
        var city_id = $('#order-create-modal .search-point').attr('city-id');
    }else {                 // иначе вызывается из админки
        var city_id = $('#city-form').attr('city-id');
    }

    var balloonContent = placemark.properties.get('balloonContent');
    var name = parseNameFromTemplate(balloonContent);
    var coordinates = placemark.geometry.getCoordinates();
    var lat = coordinates[0];
    var long = coordinates[1];

    var data = {};
    if(params['can_change_params'] == true) {
        data.point_of_arrival = params['point_of_arrival'];
        data.super_tariff_used = params['super_tariff_used'];
        data.critical_point = params['critical_point'];
        data.alias = params['alias'];
    }

    $.ajax({
     url: '/admin/yandex-point/ajax-create-yandex-point?city_id='+city_id+'&name='+name+'&lat='+lat+'&long='+long,
     type: 'post',
     data: data,
     success: function (data) {

         if(data.success == true) {
             if ($('#order-create-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа

                 // обновление контента точки чтобы там в скрытом поле прописался id точки
                 var index = parseIndexFromTemplate(balloonContent);
                 //console.log('name='+name+' index='+index+' id='+data.yandex_point.id);

                 var select_point_placemark_params = {
                     index: index,
                     point_text: data.yandex_point.name,
                     point_id: data.yandex_point.id
                 }
                 if(typeof point_focusing_scale != "undefined") {
                     select_point_placemark_params.point_focusing_scale = point_focusing_scale;
                 }
                 //selectPointPlacemark(index, data.yandex_point.name, data.yandex_point.id);
                 selectPointPlacemark(select_point_placemark_params);

                 // обновление поля "откуда" в форме создания заказа
                 var key = data.yandex_point.id + '_' + data.yandex_point.lat + '_' + data.yandex_point.long + '_' + data.yandex_point.name;
                 selectWidgetInsertValue($('input[name="Order[yandex_point_from]"]').parents('.sw-element'), key, data.yandex_point.name);

             } else {                // иначе вызывается из админки

                 alert('Точка создана и сохранена');

                 // закрытие модального окна
                 $('#default-modal').modal('hide');

                 // обновление страницы города со списком яндекс-точек
                 $.pjax.reload({
                     container: "#yandex-points-grid",
                     data: {
                         city_id: city_id
                     }
                 });
             }

         }else {

             var errors = '';
             for (var field in data.errors) {
                 var field_errors = data.errors[field];
                 for (var key in field_errors) {
                     errors += field_errors[key] + ' ';
                 }
             }
             alert(errors);

             map.geoObjects.remove(placemark);
             placemark = null;

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

    return true;
}


 // функция изменения названия яндекс-точки
 //function updateYandexPoint(index, yandex_point_id, name, lat, long, can_change_params, critical_point, alias) {
function updateYandexPoint(params) {

     //var update_yandex_point_params = {
     //    index: index,
     //    point_id: point_id,
     //    point_text: point_text,
     //    lat: lat,
     //    long: long,
     //    can_change_params: can_change_params,
     //    critical_point: critical_point,
     //    alias: alias
     //};

    if(params['index'] == undefined) {
        params['index'] = '';
    }
    if(params['point_id'] == undefined) {
        params['point_id'] = 0;
    }
    if(params['point_text'] == undefined) {
        params['point_text'] = '';
    }
    if(params['lat'] == undefined) {
        params['lat'] = 0;
    }
    if(params['long'] == undefined) {
        params['long'] = 0;
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



 var data = {};
 if(params['point_text'] != undefined && params['point_text'] != '') {
     data.name = params['point_text'];
 }

 if(params['lat'] != undefined && params['long'] != undefined) {
     data.lat = params['lat'];
     data.long = params['long'];
 }

 if(params['can_change_params'] == true) {
     data.critical_point = params['critical_point'];
     data.point_of_arrival = params['point_of_arrival'];
     data.super_tariff_used = params['super_tariff_used'];
     data.alias = params['alias'];
 }

 $.ajax({
     //url: '/yandex-point/ajax-update-yandex-point?id=' + params['point_id'] + '&name=' + params['point_text'],
     url: '/yandex-point/ajax-update-yandex-point?id=' + params['point_id'],
     type: 'post',
     data: data,
     success: function (data) {

         if(data.success == true) {
             if ($('#order-create-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа


                 var select_point_placemark_params = {
                     index: params['index'],
                     point_text: params['point_text'],
                     point_id: params['point_id'],
                     is_editing: false,
                     create_new_point: false,
                     can_change_params: params['can_change_params'],
                     point_of_arrival: params['point_of_arrival'],
                     super_tariff_used: params['super_tariff_used'],
                     critical_point: params['critical_point'],
                     alias: params['alias']
                     //draggable: draggable,
                     //is_allowed_edit: is_allowed_edit
                 }
                 if(typeof point_focusing_scale != "undefined") {
                     select_point_placemark_params.point_focusing_scale = point_focusing_scale;
                 }
                 selectPointPlacemark(select_point_placemark_params);
                 //selectPointPlacemark(params['index'], params['point_text'], params['point_id'], false, false, params['can_change_params'], params['critical_point'], alias);

                 // обновление поля "откуда" в форме создания заказа
                 var key = data.yandex_point.id + '_' + data.yandex_point.lat + '_' + data.yandex_point.long + '_' + data.yandex_point.name;
                 selectWidgetInsertValue($('input[name="Order[yandex_point_from]"]').parents('.sw-element'), key, data.yandex_point.name);

             } else {  // иначе вызывается из админки

                 alert('Изменения точки сохранены');

                 // закрытие модального окна
                 //$('#default-modal').modal('hide');

                 // обновление страницы города со списком яндекс-точек
                 var city_id = $('#city-form').attr('city-id');
                 $.pjax.reload({
                     container: "#yandex-points-grid",
                     data: {
                         city_id: city_id
                     }
                 });
             }
         }else {

             var errors = '';
             for (var field in data.errors) {
                 var field_errors = data.errors[field];
                 for (var key in field_errors) {
                     errors += field_errors[key] + ' ';
                 }
             }

             alert(errors);

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

 return true;
}
*/

/*
$(document).on('click', '.btn-select-placemark', function() {

    alert('main.js .btn-select-placemark');

 if(map != null) {

     var index = $(this).attr('placemark-index');
     var placemark = map.geoObjects.get(index);

     // в hintContent и balloonContent прячу кнопки "Выбрать"
     var balloonContent = placemark.properties.get('balloonContent');
     var yandex_point_id = parseIdFromTemplate(balloonContent);
     var yandex_point_name = parseNameFromTemplate(balloonContent);
     var draggable = getDraggable(yandex_point_id);

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


     if($('#order-create-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа

         // обновление поля "откуда" в форме создания заказа
         var coordinates = placemark.geometry.getCoordinates();
         var lat = coordinates[0];
         var long = coordinates[1];
         var key = yandex_point_id + '_' + lat + '_' + long + '_' + yandex_point_name;
         selectWidgetInsertValue($('input[name="Order[yandex_point_from]"]').parents('.sw-element'), key, yandex_point_name);

     }else {  // иначе вызывается из админки

     }
 }
});
*/

/*
$(document).on('click', '#order-create-modal .span-placemark, #default-modal .span-placemark', function() {

 if($(this).hasClass('not-edit')) {
     return false;
 }

 $(this).hide();
 $(this).parent().find('.input-placemark').show();
 $(this).parent().find('.ok-placemark').show();
});

$(document).on('click', '#order-create-modal .ok-placemark, #default-modal .ok-placemark', function() {

 var text = $.trim($(this).parent().find('.input-placemark').val());

 if(text == '') {
     alert('Необходимо заполнить текст');
 }else {
     var index = $(this).parent().attr('index');
     var yandex_point_id = $(this).parent().attr('yandex-point-id');
     var create_new_point = $(this).parent().attr('create-new-point');

     if($(this).parent().find('.critical-point').length > 0) {
         var can_change_params = true;
         var point_of_arrival = ($(this).parent().find('.point-of-arrival').is(':checked') == true ? 1 : 0);
         var super_tariff_used = ($(this).parent().find('.super-tariff-used').is(':checked') == true ? 1 : 0);
         var critical_point = ($(this).parent().find('.critical-point').is(':checked') == true ? 1 : 0);
         var alias = $(this).parent().find('.alias').val();
     }else {
         var can_change_params = false;
         var point_of_arrival = 0;
         var super_tariff_used = 0;
         var critical_point = 0;
         var alias = '';
     }

     // функция выбора точки обновляет контент/название точки
     // selectPointPlacemark(index, point_text, point_id, edit, create_new_point, can_change_params, critical_point, alias)
     var draggable = getDraggable(yandex_point_id);

     var select_point_placemark_params = {
         index: index,
         point_text: text,
         point_id: yandex_point_id,
         is_editing: false,
         create_new_point: false,
         can_change_params: can_change_params,
         critical_point: critical_point,
         point_of_arrival: point_of_arrival,
         super_tariff_used: super_tariff_used,
         alias: alias,
         draggable: draggable
         //is_allowed_edit: is_allowed_edit
     }
     if(typeof point_focusing_scale != "undefined") {
         select_point_placemark_params.point_focusing_scale = point_focusing_scale;
     }
     var placemark = selectPointPlacemark(select_point_placemark_params);
     //var placemark = selectPointPlacemark(index, text, yandex_point_id, false, false, can_change_params, critical_point, alias, draggable);

     if(yandex_point_id > 0) {

         // сохраняем в базе изменения в точке
         var coordinates = placemark.geometry.getCoordinates();
         var lat = coordinates[0];
         var long = coordinates[1];

         //updateYandexPoint(index, yandex_point_id, text, lat, long, can_change_params, critical_point, alias);
         var update_yandex_point_params = {
             index: index,
             point_id: yandex_point_id,
             point_text: text,
             lat: lat,
             long: long,
             can_change_params: can_change_params,
             point_of_arrival: point_of_arrival,
             super_tariff_used: super_tariff_used,
             critical_point: critical_point,
             alias: alias
         };
         updateYandexPoint(update_yandex_point_params);


     }else {
         // создаем точку и обновляем контент кнопки чтобы там прописался id точки
         if(create_new_point == 'true') {
             //createYandexPoint(placemark, can_change_params, critical_point, alias);

             var create_yandex_point_params = {
                 can_change_params: can_change_params,
                 point_of_arrival: point_of_arrival,
                 super_tariff_used: super_tariff_used,
                 critical_point: critical_point,
                 alias: alias
             };
             createYandexPoint(placemark, create_yandex_point_params);

         }else {
             if($('#order-create-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа
                 // обновление поля "откуда" в форме создания заказа
                 var coordinates = placemark.geometry.getCoordinates();
                 var lat = coordinates[0];
                 var long = coordinates[1];
                 var key = '0_' + lat + '_' + long + '_' + text;
                 selectWidgetInsertValue($('input[name="Order[yandex_point_from]"]').parents('.sw-element'), key, text);

                 var select_point_placemark_params = {
                     index: index,
                     point_text: text,
                     point_id: yandex_point_id,
                     is_editing: false,
                     create_new_point: false,
                     can_change_params: can_change_params,
                     point_of_arrival: point_of_arrival,
                     super_tariff_used: super_tariff_used,
                     critical_point: critical_point,
                     alias: alias,
                     draggable: getDraggable(yandex_point_id)
                     //is_allowed_edit: is_allowed_edit
                 }
                 if(typeof point_focusing_scale != "undefined") {
                     select_point_placemark_params.point_focusing_scale = point_focusing_scale;
                 }
                 selectPointPlacemark(select_point_placemark_params);
                 //selectPointPlacemark(index, text, yandex_point_id, false, false, can_change_params, critical_point, alias, draggable);

             }else {  // иначе вызывается из админки

                 alert('Не предполагается в админке сохранение временной точки');
             }
         }
     }
 }
});


 // поиск точки на яндекс-карте
$(document).on('keyup', '#order-create-modal .search-point, #default-modal .search-point', function(e) {

 var $search_obj = $(this);
 var search = $.trim($(this).val());

 if(search.length > 3) {

     var city_long = $search_obj.attr('city-long');
     var city_lat = $search_obj.attr('city-lat');
     var city_name = $search_obj.attr('city-name');

     //var url = 'https://suggest-maps.yandex.ru/suggest-geo?lang=ru_RU&ll='
     //    + city_long + ',' + city_lat + '&part=Республика Татарстан, ' + search;

     var url = 'https://suggest-maps.yandex.ru/suggest-geo?' +
             //'&v=5' +
         '&v=9' +
             //'&search_type=tp' +
             //'&search_type=tune' +
         '&search_type=all' +
         '&part=Республика Татарстан, ' + search +
         '&lang=ru_RU' +
         '&origin=jsapi2Geocoder' +
         '&ll=' + city_long + ',' + city_lat;

     $.ajax({
         url: url,
         dataType: 'jsonp',
         type: 'post',
         data: {},
         success: function (response) {

             var html = '';
             //var results = response[1];
             //console.log('results:'); console.log(response.results);


             if(response.results.length > 0) {

                 html = '<ul class="main-list">';
                 var lis = [];
                 var first_lis = []; // для мини-сортировки - строки в которых используется название города попадают в первый список
                 for(var i = 0; i < response.results.length; i++) {
                     //    var result = results[i][1]; // массив частей строк (территориальных делений)
                     //    //console.log('result:'); console.log(result);
                     //
                     //    if(result.length > 0) {
                     //        var str = '';
                     //        for(var j = 0; j < result.length; j++) { // 3 - это в конце масива: [..., 'Республика', ' ', 'Татарстан']
                     //            //console.log('type=' + typeof(result[j]));
                     //            if(typeof(result[j]) == 'object') {
                     //                str += result[j][1];
                     //            }else { // type = string
                     //                str += result[j];
                     //            }
                     //        }
                     //        str = str.replace(', Республика Татарстан', '');
                     //        str = '<li>' + str + '</li>';
                     //
                     //        if(str.indexOf(city_name) > -1) {
                     //            first_lis.push(str);
                     //        }else {
                     //            lis.push(str);
                     //        }
                     //    }


                     var result = response.results[i];
                     //console.log('result:'); console.log(result);

                     // Орион, Россия, Республика Татарстан
                     // Орион, Россия, Республика Татарстан, Набережные Челны
                     // Орион, Россия, Республика Татарстан, Казань

                     // Россия, Республика Татарстан, Альметьевск, улица Ленина
                     // Россия, Республика Татарстан, Бугульма, улица Ленина
                     // ...

                     var str = result.text; //
                     str = str.replace('Россия, Республика Татарстан, ', '');
                     str = '<li>' + str + '</li>';

                     if(str.indexOf(city_name) > -1) {
                         first_lis.push(str);
                     }else {
                         lis.push(str);
                     }
                 }

                 html += first_lis.join('') + lis.join('');
                 html += '</ul>';
                 $search_obj.next('.search-result-block').html(html).show();

             }else {
                 $search_obj.next('.search-result-block').html('').hide();
             }
         },
         error: function (data, textStatus, jqXHR) {
             alert('request error');
         }
     });

 }else {
     $search_obj.next('.search-result-block').html('').hide();
 }
});


 // в яндекс-карте щелчек на строке в выпадающем списке результатов поиска
$(document).on('click', '.map-control-block .search-result-block li', function() {

 if(map == null) {
     return false;
 }

 var str = $(this).text();
 var myGeocoder = ymaps.geocode(str);
 myGeocoder.then(
     function (res) {

         var coordinates = res.geoObjects.get(0).geometry.getCoordinates();
         str = str.replace(', Республика Татарстан', '');


         if($('#order-create-modal').length > 0) { // вызывается со страницы сайта где есть форма создания заказа

             // создание точки - соответствующей выбранной в результатах поиска строке
             var index = map.geoObjects.getLength();


             //var placemark = createPlacemark(str, index, 0, coordinates[0], coordinates[1], true, false, false);
             var create_placemark_params = {
                 index: index,
                 point_text: str,
                 point_id: 0,
                 point_lat: coordinates[0],
                 point_long: coordinates[1],
                 is_editing: true,
                 create_new_point: false,
                 to_select: true
                 //can_change_params: can_change_params,
                 //point_of_arrival: point_of_arrival,
                 //critical_point: critical_point,
                 //alias: alias
             };
             var placemark = createPlacemark(create_placemark_params);


             //var select_point_placemark_params = {
             //    index: index,
             //    point_text: str,
             //    point_id: 0,
             //    is_editing: true,
             //    create_new_point: false
             //    //can_change_params: can_change_params,
             //    //point_of_arrival: point_of_arrival,
             //    //critical_point: critical_point,
             //    //alias: alias,
             //    //draggable: getDraggable(yandex_point_id)
             //    //is_allowed_edit: is_allowed_edit
             //}
             //selectPointPlacemark(select_point_placemark_params);
             //selectPointPlacemark(index, str, 0, true, false);


             //placemark.balloon.open(); // если его поставить после " map.setCenter(coordinates, point_focusing_scale, {duration: 500});", то установка центра карты не успевает завершиться

             $('#order-create-modal .search-point').next('.search-result-block').html('').hide();
             $('#time_air_train_arrival_label').html('');
             $('#time_air_train_arrival_block').hide();

             if(typeof point_focusing_scale != "undefined") {
                 var coordinates = placemark.geometry.getCoordinates();
                 map.setCenter(coordinates, point_focusing_scale, {duration: 500}); // , iconColor: '#FF0000'
             }

             placemark.options.unset('iconLayout');
             placemark.options.unset('iconColor');
             placemark.options.unset('iconImageSize');
             placemark.options.unset('iconImageOffset');
             placemark.options.unset('iconShape');
             placemark.options.set({
                 iconColor: '#ff0000'
             });
             placemark.events
                 .add('mouseenter', function (e) {
                     e.get('target').options.set('iconColor', '#56DB40');
                 })
                 .add('mouseleave', function (e) {
                     e.get('target').options.set('iconColor', '#ff0000');
                 });


         }else {  // иначе вызывается из админки

             // создание точки - соответствующей выбранной в результатах поиска строке
             var index = map.geoObjects.getLength();
             //var placemark = createPlacemark(str, index, 0, coordinates[0], coordinates[1], true, true, false);
             var create_placemark_params = {
                 index: index,
                 point_text: str,
                 point_id: 0,
                 point_lat: coordinates[0],
                 point_long: coordinates[1],
                 is_editing: true,
                 create_new_point: true,
                 to_select: false
                 //can_change_params: can_change_params,
                 //point_of_arrival: point_of_arrival,
                 //critical_point: critical_point,
                 //alias: alias
             };
             var placemark = createPlacemark(create_placemark_params);
             //placemark.events.remove('mouseenter');
             //placemark.events.remove('mouseleave');


             var select_point_placemark_params = {
                 index: index,
                 point_text: str,
                 point_id: 0,
                 is_editing: true,
                 create_new_point: true
                 //can_change_params: can_change_params,
                 //point_of_arrival: point_of_arrival,
                 //critical_point: critical_point,
                 //alias: alias,
                 //draggable: getDraggable(yandex_point_id)
                 //is_allowed_edit: is_allowed_edit
             }
             if(typeof point_focusing_scale != "undefined") {
                 select_point_placemark_params.point_focusing_scale = point_focusing_scale;
             }
             selectPointPlacemark(select_point_placemark_params);
             //selectPointPlacemark(index, str, 0, true, true);

             placemark.balloon.open();

             $('#default-modal .search-point').next('.search-result-block').html('').hide();
         }


         //var coordinates = placemark.geometry.getCoordinates();
         //map.setCenter(coordinates, MAP_SEARCH_SCALE, {duration: 500});

     },
     function (err) {
         alert('Ошибка');
     }
 );

 return false;
});


 $(document).on('click', '#order-list-page .make-simple-payment', function() {

     //var summ = $.trim($('#payment-summ').val());
     // var float_summ = parseFloat(summ);
     // if(summ == '' || isNaN(float_summ) || float_summ <= 0) {
     //     alert('Неправильное значение в поле сумма оплаты');
     //     return false;
     // }

     var client_ext_id = $(this).attr('client-ext-id');

     $.ajax({
         url: '/yandex-payment/payment/ajax-make-simple-payment?client_ext_id=' + client_ext_id + '&source_page=account/order',
         type: 'post',
         data: {},
         success: function (response) {
             if (response.success == true) {
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