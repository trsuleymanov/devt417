

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
function selectPointPlacemark(map, params) {

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
    if(params['point_description'] == undefined) {
        params['point_description'] = '';
    }
    if(params['point_id'] == undefined) {
        params['point_id'] = 0;
    }
    if(params['critical_point'] != 1) {
        params['critical_point'] = 0;
    }
    if(params['popular_departure_point'] != 1) {
        params['popular_departure_point'] = 0;
    }
    if(params['popular_arrival_point'] != 1) {
        params['popular_arrival_point'] = 0;
    }
    if(params['external_use'] != 1) {
        params['external_use'] = 0;
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
    if(params['is_allowed_edit'] == undefined) {
        params['is_allowed_edit'] = false;
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

    if(params['index'] == '' && params['point_id'] > 0) {

        map.geoObjects.each(function (placemark, i) {

            var balloonContent = placemark.properties.get('balloonContent');
            //var index = parseIndexFromTemplate(balloonContent);
            var yandex_point_id = parseIdFromTemplate(balloonContent);

            if(params['point_id'] == yandex_point_id) {
                point_placemark = placemark;

                if(params['point_text'] == '') {
                    params['point_text'] = parseNameFromTemplate(balloonContent);
                }
                //alert('point_text='+params['point_text']);

                return;
            }
        })

    }else if(params['index'] != '') {
        point_placemark = map.geoObjects.get(params['index']);
    }else {
        alert('Невозможно найти точку на карте');
    }


    var hintContent = params['point_text'] + ' (точка выбрана)';

    var placemarket_template_params = {
        point_text: params['point_text'],
        point_description: params['point_description'],
        index: params['index'],
        point_id: params['point_id'],
        critical_point: params['critical_point'],
        popular_departure_point: params['popular_departure_point'],
        popular_arrival_point: params['popular_arrival_point'],
        external_use: params['external_use'],
        point_of_arrival: params['point_of_arrival'],
        super_tariff_used: params['super_tariff_used'],
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

    //console.log('selectPointPlacemark отработала');


    return point_placemark;
}



// метод снимает выделение с точки
function unselectOldPointPlacemark() {

    if (point_placemark != null) {

        //var dbSavedPlacemark = point_placemark.options.get('dbSavedPlacemark');

        var balloonContent = point_placemark.properties.get('balloonContent');
        var index = parseIndexFromTemplate(balloonContent);
        var yandex_point_id = parseIdFromTemplate(balloonContent);
        var yandex_point_name = parseNameFromTemplate(balloonContent);
        // var yandex_point_description = parseDescriptionFromTemplate(balloonContent);
        var hintContent = '<button class="btn-select-placemark hint-btn" placemark-index="' + index + '">Выбрать</button> ' + yandex_point_name;


        var params = {
            point_text: yandex_point_name,
            // point_description: yandex_point_description,
            index: index,
            point_id: yandex_point_id,
            is_allowed_edit: false
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

        // point_placemark.options.unset('preset'); // вызывает ошибку
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

        // console.log('unselectOldPointPlacemark отработал');
    }
}


function addOverlay($popup, triggerActiveClass) {
    $("body").append('<div class="popup-overlay"></div>');
    $(".popup-overlay").click(function(event) {
        $("." + triggerActiveClass).removeClass(triggerActiveClass);
        $popup.removeClass("d-b");
        $(event.currentTarget).remove();
    });
}

// function addMainOverlay($popup, triggerActiveClass) {
//     $("body").append('<div class="main-overlay"></div>');
//     $(".main-overlay").click(function(event) {
//         $("." + triggerActiveClass).removeClass(triggerActiveClass);
//         $popup.removeClass("d-b");
//         $(event.currentTarget).remove();
//     });
// }
// function removeOverlay() {
//     $(".popup-overlay").remove();
// }
// function removeMainOverlay() {
//     $(".main-overlay").remove();
// }


//Address steps
var isCompletedAddress = false;
var isCompletedDest = false;

var geolocation = null;
var map_from = null;
var map_from2 = null;
var map_from_static = null;
var map_to = null;
var point_placemark = null;
var point_focusing_scale = 10; // масштаб фокусировки выбранной точки

// извлечение из html-контента индекса placemark в коллекции
function parseIndexFromTemplate(content) {

    var pos_start = content.indexOf('index=') + 7;
    var index = content.substring(pos_start);
    var pos_end = index.indexOf('"');
    var index = index.substring(0, pos_end);

    return index;
}

// извлечение из html-контента id яндекс-точки
function parseIdFromTemplate(content) {

    var pos_start = content.indexOf('yandex-point-id=') + 17;
    var id = content.substring(pos_start);
    var pos_end = id.indexOf('"');
    var id = id.substring(0, pos_end);

    return id;
}

// извлечение из html-контента названия яндекс-точки
function parseNameFromTemplate(content) {

    var pos_start = content.indexOf('span-placemark');
    var text = content.substring(pos_start);
    var pos_start = text.indexOf('>') + 1;
    var text = text.substring(pos_start);
    var pos_end = text.indexOf('</span>');
    var text = text.substring(0, pos_end);

    return text;
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


// можно ли перемещать точку
function getDraggable(yandex_point_id) {

    if($('#order-create-modal').length > 0) {
        var draggable = false;
    }else if($('.city-update').length > 0) {
        var draggable = true;
    }else {
        var draggable = false;
    }

    return draggable;
}

// это аналог функции openMapWithPointFrom()
function loadMap(map_name, map_id, is_from, return_function) {

    //map_from_static = null;

    var direction_id = $('#order-client-form').attr('direction-id');
    $.ajax({
        url: '/direction/ajax-get-direction-map-data?id=' + direction_id + '&from=' + is_from,
        type: 'post',
        data: {},
        success: function (response) {

            ymaps.ready(function(){

                if( $('#' + map_id).html() == '' ){

                    this[map_name] = new ymaps.Map(map_id, {
                        center: [response.city.center_lat, response.city.center_long],
                        zoom: response.city.map_scale,
                        controls: [
                            'zoomControl',
                            //'searchControl',
                            //'typeSelector',
                            //'routeEditor',  // построитель маршрута
                            'trafficControl' // пробки
                            //'fullscreenControl'
                        ]
                    });


                    this[map_name].events.add('boundschange', function (event) {
                        showHidePlacemarks(this[map_name], event.get('newZoom'), response.city.all_points_show_scale)
                    });

                    // Множество существующих точек
                    for (var key in response.yandex_points) { // только базовые точки в списке

                        var yandex_point = response.yandex_points[key];

                        var index = this[map_name].geoObjects.getLength();
                        var create_placemark_params = {
                            index: index,
                            point_text: yandex_point.name,
                            point_description: yandex_point.description,
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
                        var placemark = createPlacemark(this[map_name], create_placemark_params);
                    }

                    return_function();
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



function loadTripTimes(access_code, yandex_point_id, response_function) {

    // нужна дата заказа и время заказа

    $.ajax({
        url: '/client-ext/ajax-trips-time-confirm?c=' + access_code + '&yandex_point_from_id=' + yandex_point_id,
        type: 'post',
        data: {},
        success: function (response) {

            if( typeof response_function != 'undefined' ){


                var has_elems = false;
                var trips_html = '';
                for(var key in response.trips_time) {
                    has_elems = true;
                    var trip_obj = response.trips_time[key];
                    // var str = '';
                    // if(trip_obj.data != undefined) {
                    //     str += "<span class='trip-data'>" + trip_obj.data + "</span><br />";
                    // }
                    // str += "<span class='trip-time'>" + trip_obj.time + "</span>";
                    // var i = 1 + parseInt(key);
                    // $('#trip-time-confirm-' + i).html(str)
                    //     .attr('trip-id', trip_obj.trip_id)
                    //     .attr('travel_time_h', trip_obj.travel_time_h)
                    //     .attr('travel_time_m', trip_obj.travel_time_m);

                    // trip_id  3491
                    // time 03:10
                    // data 12.10.2019
                    // travel_time_h    3
                    // travel_time_m

                    trips_html += '<li class="reservation-drop__time-item"' +
                        ' trip-id="' + trip_obj.trip_id + '"' +
                        ' data-departure-date="'+ trip_obj.departure_date +'" ' +
                        'data-departure-time="'+ trip_obj.departure_time +'" ' +
                        'data-arrival-date="'+ trip_obj.arrival_date +'" ' +
                        'data-arrival-time="'+ trip_obj.arrival_time +'" ' +
                        'yandex-point-id="' + response.yandex_point_id + '" ' +
                        'yandex-point-lat="' + response.yandex_point_lat +'" ' +
                        'yandex-point-lon="' + response.yandex_point_long +'" ' +
                        'yandex-point-name="' + response.yandex_point_name + '"' +
                        'yandex-point-description="' + response.yandex_point_description + '"' +
                        '>' + (response.client_ext_data != trip_obj.data ? trip_obj.data + ' ' : '') + trip_obj.departure_time + '</li>';
                }

                var yandex_point_name = response.yandex_point_name;
                if(response.yandex_point_description != '') {
                    yandex_point_name += ', ' + response.yandex_point_description;
                }

                $('.reservation-drop--1').find('.reservation-drop__selected-address')
                    .text(yandex_point_name)
                    .attr('yandex-point-id', yandex_point_id);

                var time = $('#order-client-form').attr('time');

                var html =
                    '<div class="reservation-drop__time-paragraph">Указанное вами желаемое время посадки - <span class="reservation-drop__time-time">' + time + '</span>. На выбранной точке можно сесть в указанное время.</div>' +
                    '    <div class="reservation-drop__time-title">Выберите время посадки:</div>' +
                    '    <ul class="reservation-drop__time-list">' +
                    trips_html +
                    '    </ul>' +
                    '    <div class="reservation-drop__time-back-wrap">' +
                    '        <img src="/images_new/back-address.svg" alt="" class="reservation-drop__time-back-arrow">' +
                    '        <div class="reservation-drop__time-back-text"><span class="reservation-drop__time-back-trigger">Другой адрес?</span></div>' +
                    '    </div>';
                $('.reservation-drop--1').find('.reservation-drop__time').html(html);

                // if(has_elems == true) {
                //     $('#select-trip-list').show();
                //     $('#map-text').html("<br />Выберите время посадки на указанной точке:");
                // }else {
                //     $('#select-trip-list').hide();
                //     $('#map-text').html("<br />На выбранной точке к сожалению нельзя сесть. Выберите пожалуйста другую точку.");
                // }


                response_function(response);
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


function addressToStep1(parent) {
    $(".reservation-drop-offer").removeClass("d-n");
    $(".reservation-drop__search").removeClass("d-n");
    $(".reservation-drop__selected").removeClass("d-b");
    $(".reservation-drop__time").removeClass("d-b");
}

// клик на выпадающем в поиске одном из элементов
function addressToStep2(parent) {
    $(".reservation-drop-offer").addClass("d-n");
    $(".reservation-drop__search").addClass("d-n");
    $(".reservation-drop__selected").addClass("d-b");
    $(".reservation-drop__time").addClass("d-b");
    $(".reservation-drop__map").removeClass("d-b");
}




// выбор точки посадки на всплывающей карте
$(document).on('click', '#ya-map-from .btn-select-placemark', function() {

    var index = $(this).attr('placemark-index');
    var placemark = map_from.geoObjects.get(index);
    var balloonContent = placemark.properties.get('balloonContent');
    var yandex_point_id = parseIdFromTemplate(balloonContent);
    var access_code = $('#order-client-form').attr('client-ext-code');

    loadTripTimes(access_code, yandex_point_id, function(ajax_response) {
        //console.log('ajax_response:'); console.log(ajax_response);
        addressToStep2();
    });
});
$(document).on('click', '#ya-map-from2 .btn-select-placemark', function() {

    var index = $(this).attr('placemark-index');
    var placemark = map_from2.geoObjects.get(index);
    var balloonContent = placemark.properties.get('balloonContent');
    var yandex_point_id = parseIdFromTemplate(balloonContent);
    var access_code = $('#order-client-form').attr('client-ext-code');

    loadTripTimes(access_code, yandex_point_id, function(ajax_response) {
        //console.log('ajax_response:'); console.log(ajax_response);
        $('.reservation-drop__selected-showmap-trigger').click(); // закрываем открытую карту
        addressToStep2();
    });
});
$(document).on('click', '#ya-map-from-static .btn-select-placemark', function() {

    var index = $(this).attr('placemark-index');
    var placemark = map_from_static.geoObjects.get(index);
    var balloonContent = placemark.properties.get('balloonContent');
    var yandex_point_from_id = parseIdFromTemplate(balloonContent);
    // var yandex_point_from_name = parseNameFromTemplate(balloonContent);
    var access_code = $('#order-client-form').attr('client-ext-code');

    // loadTripTimes(access_code, yandex_point_id, function(ajax_response) {
    //     //console.log('ajax_response:'); console.log(ajax_response);
    //     $('.reservation-drop__selected-showmap-trigger').click(); // закрываем открытую карту
    //     addressToStep2();
    // });

    // закрываем текущую открытую карту
    $('#city-from-block .reservation-step-line-showmap').click();

    // всплытие формы с открытой картой с наведением на выбранную ранее точку откуда
    openSelectPointFromModal(function() {
        loadTripTimes(access_code, yandex_point_from_id, function(ajax_response) {
            addressToStep2();
        });
    });

});

// выбор точки высадки на карте
$(document).on('click', '.container-drop--2 .btn-select-placemark', function(event) {

    // alert('точка высадки');
    var index = $(this).attr('placemark-index');
    var placemark = map_to.geoObjects.get(index);
    var balloonContent = placemark.properties.get('balloonContent');
    var yandex_point_to_id = parseIdFromTemplate(balloonContent);
    var yandex_point_to_name = parseNameFromTemplate(balloonContent);

    var coordinates = placemark.geometry.getCoordinates();
    var lat = coordinates[0];
    var long = coordinates[1];
    // alert('lat='+lat+' long='+long);


    // закрытие текущей формы
    $('.reservation-drop--2').find('.reservation-drop__content').html('');
    $('.reservation-drop--2').hide();
    $(".main-overlay").remove();

    $('input[name="ClientExt[yandex_point_to_id]"]')
        .val(yandex_point_to_id)
        .attr('lat', lat)
        .attr('lon', long)
        //.attr('point-name', yandex_point_to_name)
        .attr('point-index', index);
    $('.reservation-step-line-dest-address').html(yandex_point_to_name);
    toggleSubmitBut1();

    //$(".reservation-drop--2").removeClass("d-b");
    $(".reservation-step-line-content-top-left--empty2").addClass("d-n");
    $(".reservation-step-line-content-top-left--ready2").addClass("d-b");
    $(".reservation-step-line-selecte--2").addClass("d-n");
});


function openSelectPointFromModal(response_function) {

    var access_code = $('#order-client-form').attr('client-ext-code');
    var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();

    $.ajax({
        url: '/client-ext/get-select-point-from-form?c=' + access_code + '&yandex_point_from_id=' + yandex_point_from_id,
        type: 'post',
        data: {},
        success: function (html) {

            $("body").append('<div class="main-overlay"></div>');
            $(".main-overlay").click(function(event) {
                $('.reservation-drop--1').hide();
                $(".main-overlay").remove();
            });

            $('.reservation-drop--1').find('.reservation-drop__content').html(html);
            $('.reservation-drop--1').show();

            if( typeof response_function != 'undefined' ){
                response_function();
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

function openSelectPointToModal(response_function) {

    var access_code = $('#order-client-form').attr('client-ext-code');
    $.ajax({
        url: '/client-ext/get-select-point-to-form?c=' + access_code,
        type: 'post',
        data: {},
        success: function (html) {

            $("body").append('<div class="main-overlay"></div>');
            $(".main-overlay").click(function(event) {
                $('.reservation-drop--2').hide();
                $(".main-overlay").remove();
            });

            $('.reservation-drop--2').find('.reservation-drop__content').html(html);
            $('.reservation-drop--2').show();

            loadMap('map_to', 'ya-map-to', 0, function () {
                if( typeof response_function != 'undefined' ){
                    response_function();
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
                handlingAjaxError(data, textStatus, jqXHR);
            }
        }
    });
}


$(document).on('click', '#open-select-point-from', function(e) {

    openSelectPointFromModal();

});

// выбор популярной точки в форме "Адрес и время посадки"
$(document).on('click', '.select-point-from', function() {

    var index = $(this).attr('placemark-index');
    var yandex_point_from_id = $(this).attr('data-id');
    var yandex_point_from_name = $(this).attr('data-name');
    var lat = $(this).attr('lat');
    var long = $(this).attr('lon');

    // // этот блок временно отключен
    // var coordinates = [lat, long];
    // map_from.setCenter(coordinates, 16, {duration: 500});

    $('input[name="ClientExt[yandex_point_from_id]"]')
        .val(yandex_point_from_id)
        .attr('lat', lat)
        .attr('lon', long)
        //.attr('point-name', yandex_point_from_name)
        .attr('point-index', index);
    $('.reservation-step-line-dest-address').html(yandex_point_from_name);
    toggleSubmitBut1();

    //$(".reservation-drop--2").removeClass("d-b");
    $(".reservation-step-line-content-top-left--empty1").addClass("d-n");
    $(".reservation-step-line-content-top-left--ready1").addClass("d-b");
    $(".reservation-step-line-selecte--1").addClass("d-n");

    var access_code = $('#order-client-form').attr('client-ext-code');
    loadTripTimes(access_code, yandex_point_from_id, function(ajax_response) {
        //console.log('ajax_response:'); console.log(ajax_response);

        addressToStep2();
    });
});


$(document).on('click', '#open-select-point-to', function(e) {

    openSelectPointToModal();

});

$(document).on('click', '.select-point-to', function() {

    var yandex_point_to_id = $(this).attr('data-id');
    var yandex_point_to_name = $(this).attr('data-name');
    var lat = $(this).attr('lat');
    var long = $(this).attr('lon');
    var coordinates = [lat, long];
    map_to.setCenter(coordinates, 16, {duration: 500});

    $('input[name="ClientExt[yandex_point_to_id]"]')
        .val(yandex_point_to_id)
        .attr('lat', lat)
        .attr('lon', long)
        //.attr('point-name', yandex_point_to_name);
    $('.reservation-step-line-dest-address').html(yandex_point_to_name);
    toggleSubmitBut1();

    //$(".reservation-drop--2").removeClass("d-b");
    $(".reservation-step-line-content-top-left--empty2").addClass("d-n");
    $(".reservation-step-line-content-top-left--ready2").addClass("d-b");
    $(".reservation-step-line-selecte--2").addClass("d-n");

    if( $('input[name="ClientExt[trip_id]"]').val() != '' ){
        $('.reservation-average').removeClass("d-n");
        $('.reservation-average').addClass("d-b");
    }

    setTimeout(function(){
        $('.reservation-drop--2').hide();
        $(".main-overlay").remove();
    }, 3000);
});



// ???????
$(document).on('click', '.reservation-popup__item', function(event) {

    var value = $(event.currentTarget).find(".reservation-popup__item-text").text();
    $(event.currentTarget).closest(".reservation-drop__search").find(".reservation-drop__search-input").removeClass("reservation-drop__search-input--active");
    $(event.currentTarget).closest(".reservation-drop__search").find(".reservation-drop__search-input").val(value);
    $(event.currentTarget).closest(".reservation-popup-search").removeClass("d-b");

    // в $(".reservation-drop__time") загружаем html для выбора времени на точках
    // и потом вызовем addressToStep2()
    //addressToStep2();

    // var access_code = $('#order-client-form').attr('client-ext-code');
    //
    //
    // loadTripTimes(access_code, yandex_point_id, function(ajax_response) {
    //     console.log('ajax_response:'); console.log(ajax_response);
    // });
});


$(document).on('click', '.reservation-drop-offer__cover', function () {
    $(this).next('.reservation-drop-offer__list').toggleClass("d-b");
    $(this).find('.reservation-drop-offer__cover-arrow').toggleClass('arrow--rotated');
});
$(document).on('click', '.reservation-drop__time-back-trigger', function () {

    addressToStep1();

});

// выбор "синей" точки супер-предложения
$(document).on('click', '.reservation-drop-offer__item', function () {

    var access_code = $('#order-client-form').attr('client-ext-code');
    var yandex_point_id = $(this).attr('yandex-point-id');

    // потом нужно вызвать addressToStep2
    loadTripTimes(access_code, yandex_point_id, function(ajax_response) {
        //console.log('ajax_response:'); console.log(ajax_response);
        addressToStep2();
    });
});



// закрытие формы "Адрес и время посадки"
$(document).on('click', '.reservation-drop__topline-cancel', function () {

    // map_to.destructor();
    $('.reservation-drop').find('.reservation-drop__content').html('');
    $('.reservation-drop').hide();
    $(".main-overlay").remove();
});


$(document).ready(function() {
    $(".reservation-drop__map").addClass("d-b");
});

// label 'использовать мою геопозицию'
$(document).on('click', '.reservation-drop__search-geo span', function() {
    // $(".reservation-drop__map").toggleClass("d-b");

    // показ (с наведением на текущую позицию) или скрытие карты
    if($(".reservation-drop__map").hasClass('d-b')) {
        //$(".reservation-drop__map").removeClass("d-b");

        // карта остается открытой, наводим на текущую позицию пользователя
        ymaps.geolocation.get({
            // Выставляем опцию для определения положения по ip    provider: 'yandex',
            // Карта автоматически отцентрируется по положению пользователя.
            mapStateAutoApply: true
        }).then(function (result) {
            // map.geoObjects.add(result.geoObjects);
            var coordinates = result.geoObjects.get(0).geometry.getCoordinates();
            map_from.setCenter(coordinates, 16, {duration: 500});
        });

    }else {

        loadMap('map_from', 'ya-map-from', 1, function () {
            // тут нужно наводить на свое местоположение

            ymaps.geolocation.get({
                // Выставляем опцию для определения положения по ip    provider: 'yandex',
                // Карта автоматически отцентрируется по положению пользователя.
                mapStateAutoApply: true
            }).then(function (result) {
                var coordinates = result.geoObjects.get(0).geometry.getCoordinates();
                map_from.setCenter(coordinates, 16, {duration: 500});
            });
        });
    }
    $(".reservation-drop__map").toggleClass("d-b");
});

// в форме выбора точки посадке в "окне" выбора времени посадки (рейса) нажатие на "на карте"
$(document).on('click', ".reservation-drop__selected-showmap-trigger", function () {
    // $(".reservation-drop__selected-map").toggleClass("d-b");

    //var $elem = $(this).closest(".reservation-drop__selected-map");
    var $elem = $(".reservation-drop__selected-map");
    if($elem.hasClass('d-b')) { // закрытие карты

        $elem.removeClass('d-b');

    }else { // отображаем карту

        $elem.addClass('d-b');


        // if($('#ya-map-from2').html() == '') { // всегда html этой карты пуст оказывается
        loadMap('map_from2', 'ya-map-from2',1, function () {

            var $elem2 = $('.reservation-drop--1').find('.reservation-drop__selected-address');
            var yandex_point_from_id = $elem2.attr('yandex-point-id');
            //var yandex_point_from_name = $elem2.text();


            var select_point_placemark_params = {
                //index: yandex_point_from_index,
                //point_text: yandex_point_from_name,
                point_id: yandex_point_from_id,
                //is_editing: true,
                //create_new_point: true,
                can_change_params: false,
                //critical_point: yandex_point.critical_point,
                //alias: yandex_point.alias,
                draggable: false,
                is_allowed_edit: false,
                point_focusing_scale: 16
            };
            selectPointPlacemark(map_from2, select_point_placemark_params);
        });
    }
});

// выбор одного из 3-х времен рейса
$(document).on('click', '.reservation-drop__time-item', function() {

    $(this).addClass('selected');
    var trip_id = $(this).attr('trip-id');
    var yandex_point_description = $(this).attr('yandex-point-description');
    $('input[name="ClientExt[trip_id]"]').val(trip_id);

    var yandex_point_id = $(this).attr('yandex-point-id');
    var yandex_point_name = $(this).attr('yandex-point-name');
    var yandex_point_lat = $(this).attr('yandex-point-lat');
    var yandex_point_lon = $(this).attr('yandex-point-lon');

    $('input[name="ClientExt[yandex_point_from_id]"]')
        .val(yandex_point_id)
        .attr('lat', yandex_point_lat)
        .attr('lon', yandex_point_lon)
        //.attr('point-name', yandex_point_name)
    ;
    toggleSubmitBut1();
    updatePrice1();

    if(yandex_point_description != '') {
        yandex_point_name += ', ' + yandex_point_description;
    }

    $('#city-from-block').find('.reservation-step-line-address-wrap').html('<div class = "reservation-step-line-address">'+ yandex_point_name +'</div><div class="reservation-step-line-change">Изменить адрес посадки</div>');

    $('.reservation-step-line_departure .reservation-step-line-time').text( $(this).attr('data-departure-time') );
    $('.reservation-step-line_departure .reservation-step-line-date').text( $(this).attr('data-departure-date') );
    $('.reservation-step-line_arrival .reservation-step-line-time').text( '~ '+ $(this).attr('data-arrival-time') );
    $('.reservation-step-line_arrival .reservation-step-line-date').text( $(this).attr('data-arrival-date') );

    if( $('input[name="ClientExt[yandex_point_to_id]"]').val() != '' ){
        $('.reservation-average').removeClass("d-n");
        $('.reservation-average').addClass("d-b");
    }

    setTimeout(function(){

        // закрытие текущей формы
        $('.reservation-drop--1').find('.reservation-drop__content').html('');
        $('.reservation-drop--1').hide();

        $(".reservation-step-line-content-top-left--empty1").addClass("d-n");
        $(".reservation-step-line-content-top-left--ready1").addClass("d-b");
        $(".reservation-step-line-selecte--1").addClass("d-n");
        $(".main-overlay").remove();

    }, 1000);

    // закрываю/удаляю текущую форму
    // $('#city-from').hide();

    // внутри reservation-step-line-content - их 2:
    //    - остается видимым reservation-step-line-content-top
    //      - внутри .reservation-step-line-content-top-left--empty1 прячется
    //      - дальше .reservation-step-line-content-top-left--ready1 заполняется данными и становяться видимыми и класс d-b появляется
    //          - внутри reservation-step-line-wrap
});


// поиск в точке откуда в адресной строке
$(document).on('keyup', '#search-place-from', function(e) {

    var search = $.trim($(this).val());
    if(search.length > 3) {

        var $search_obj = $(this);
        var city_id = $('#city-from').attr('city-id');
        if(city_id == 1) { // Казань
            var city_long = 49.11;
            var city_lat = 55.79;
            var city_name = "Казань";
        }else if(city_id == 2) {
            var city_long = 52.3;
            var city_lat = 54.9;
            var city_name = "Альметьевск";
        }

        // смотри функцию function openMap(selected_yandex_point_id) в pages.js


        var url = 'https://suggest-maps.yandex.ru/suggest-geo?' +
            '&v=7' +
            '&search_type=all' +
            '&part=Республика Татарстан, ' + city_name + ", " + search +
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
                // console.log('results:'); console.log(response.results);

                if(response.results.length > 0) {

                    html = '<ul class="main-list">';
                    var lis = [];
                    var first_lis = []; // для мини-сортировки - строки в которых используется название города попадают в первый список
                    for(var i = 0; i < response.results.length; i++) {

                        var result = response.results[i];

                        var str = '<li lat="' + result.lat + '" lon="' + result.lon + '">' + result.name + '</li>';
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
    }
});





// в выпадающей списке строки поиска по адресам - показывает карту и наводит на выбранный адрес
$(document).on('click', '#search-from-block[city-extended-external-use="1"] .search-result-block li', function() {

    var str = $(this).text();
    var lat = $(this).attr('lat');
    var lon = $(this).attr('lon');

    // если карта открыта
    if($(".reservation-drop__map").hasClass('d-b')) {

        $('#search-place-from').val(str);
        $('#search-place-from').next('.search-result-block').html('').hide();

        var coordinates = [lat, lon];
        map_from.setCenter(coordinates, 16, {duration: 500});

    }else {

        $(".reservation-drop__map").addClass("d-b");
        $('.reservation-drop__content').css("padding-bottom", "80px");


        loadMap('map_from', 'ya-map-from', 1, function () {

            $('#search-place-from').val(str);
            $('#search-place-from').next('.search-result-block').html('').hide();

            var coordinates = [lat, lon];
            map_from.setCenter(coordinates, 16, {duration: 500});
        });
    }


    return false;
});

// в выпадающей списке - выбор яндекс-точки посадки
$(document).on('click', '#search-from-block[city-extended-external-use="0"] .main-list li', function () {

    var access_code = $('#order-client-form').attr('client-ext-code');
    var yandex_point_id = $(this).val();

    // var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();

    // потом нужно вызвать addressToStep2
    loadTripTimes(access_code, yandex_point_id, function(ajax_response) {
        //console.log('ajax_response:'); console.log(ajax_response);
        addressToStep2();
    });
});


// в выпадающей списке - выбор яндекс-точки высадки
$(document).on('click', '#search-to-block li', function() {

    var yandex_point_to_id = $(this).val();
    var yandex_point_to_name = $(this).text();

    //var index = $(this).attr('placemark-index');
    //var placemark = map_to.geoObjects.get(index);
    //var balloonContent = placemark.properties.get('balloonContent');
    //var yandex_point_to_id = parseIdFromTemplate(balloonContent);
    //var yandex_point_to_name = parseNameFromTemplate(balloonContent);

    //var coordinates = placemark.geometry.getCoordinates();
    //var lat = coordinates[0];
    //var long = coordinates[1];


    // закрытие текущей формы
    $('.reservation-drop--2').find('.reservation-drop__content').html('');
    $('.reservation-drop--2').hide();
    $(".main-overlay").remove();


    $('input[name="ClientExt[yandex_point_to_id]"]')
        .val(yandex_point_to_id)
        //.attr('lat', lat)
        //.attr('lon', long)
        //.attr('point-index', index)
    ;
    $('.reservation-step-line-dest-address').html(yandex_point_to_name);
    toggleSubmitBut1();

    $(".reservation-step-line-content-top-left--empty2").addClass("d-n");
    $(".reservation-step-line-content-top-left--ready2").addClass("d-b");
    $(".reservation-step-line-selecte--2").addClass("d-n");
});




// поиск по адресам: щелчек на строке в выпадающем списке результатов поиска для точки куда
/*
$(document).on('click', '#search-to-block .search-result-block li', function() {

    var str = $(this).text();
    var lat = $(this).attr('lat');
    var lon = $(this).attr('lon');


    // если карта открыта
    // if($(".reservation-drop__map").hasClass('d-b')) {
    //
    //     $('#search-place-from').val(str);
    //     $('#search-place-from').next('.search-result-block').html('').hide();
    //
    //     var coordinates = [lat, lon];
    //     map_to.setCenter(coordinates, 16, {duration: 500});
    //
    // }else {
    //
    //     $(".reservation-drop__map").addClass("d-b");
    //     $('.reservation-drop__content').css("padding-bottom", "80px");
    //
    //     loadMapToForm(function() {
    //
    //         alert('2');
    //         $('#search-place-from').val(str);
    //         $('#search-place-from').next('.search-result-block').html('').hide();
    //
    //         var coordinates = [lat, lon];
    //         map_to.setCenter(coordinates, 16, {duration: 500});
    //     });
    // }

    $('#search-place-to').val(str);
    $('#search-place-to').next('.search-result-block').html('').hide();

    if(map_to != null) {
        var coordinates = [lat, lon];
        map_to.setCenter(coordinates, 16, {duration: 500});
    }

    return false;
});
*/


function createPlacemark(map, params) {

    // console.log('site.js createPlacemark');

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
        // is_allowed_edit: getIsAllowedEditParam(),
        is_allowed_edit: false,
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
    }else {
        map.geoObjects.add(placemark);
    }


    return placemark;
}


function getPlacemarketTemplate(params) {

    // console.log('getPlacemarketTemplate');

    if(params['point_text'] == undefined) {
        params['point_text'] = '';
    }
    if(params['point_description'] == undefined) {
        params['point_description'] = '';
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

    // if(params['point_description'] != '') {
    //     console.log('point_description=' + params['point_description']);
    // }


    if(params['can_change_params'] == true) {
        params['is_editing'] = true;
    }


    if(params['is_allowed_edit'] == false) {

        //console.log('params:'); console.log(params);

        var content =
            '<div class="placemark-balloon-content" index="' + params['index'] + '" yandex-point-id="' + params['point_id'] + '">';
        content +=
            '<span class="critical-point" style="display: none;">' + (params['critical_point'] == true ? "1" : "0") + '</span>' +
            '<span class="alias" style="display: none;">' + params['alias'] + '</span>' +
            '<input class="input-placemark" style="display: none;" type="text" value="' + params['point_text'] + '" />' +
            '<span class="span-placemark not-edit"> ' + params['point_text'] + '</span>' +
            '<br /><span class="placemark-description"> ' + params['point_description'] + '</span>' +
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


$(document).on('click', '#reservation-item__checkbox-1', function() {

    var reservation_item_checked = $(this).is(':checked');
    if(reservation_item_checked == true) {
        $('#clientext-time_air_train_arrival').removeAttr('disabled').focus();
    }else {
        $('#clientext-time_air_train_arrival').attr('disabled', true);
    }
});


$(document).on('click', '#reservation-item__checkbox-2', function() {

    var reservation_item_checked = $(this).is(':checked');
    if(reservation_item_checked == true) {
        $('.reservation-item__input-luggage').removeAttr('disabled');
    }else {
        $('.reservation-item__input-luggage').attr('disabled', true);

        $('input[name="ClientExt[suitcase_count]"]').val(0);
        $('input[name="ClientExt[bag_count]"]').val(0);

        var message = "Чемоданы - " + 0 + ", ручная кл. - " + 0;
        $(".reservation-item__input-luggage").val(message);

        $(".reservation-popup-luggage .reservation-popup__item").first().find(".reservation-popup__counter-num").text("0");
        $(".reservation-popup-luggage .reservation-popup__item").last().find(".reservation-popup__counter-num").text("0");
    }
});

$(document).on('click', '#reservation-item__checkbox-3', function() {

    var reservation_item_checked = $(this).is(':checked');
    if(reservation_item_checked == true) {
        $('.reservation-item_wishes textarea').removeAttr('disabled').focus();
    }else {
        $('.reservation-item_wishes textarea').attr('disabled', true);
    }
});

$(document).on('click', '.reservation-item__input-luggage', function(event) {
    $(".reservation-popup-luggage").addClass("d-b");

    if (!($(event.currentTarget).hasClass("reservation-item__input-luggage--active"))) {
        addOverlay($(".reservation-popup-luggage"), "reservation-item__input-luggage--active");
    }
    $(event.currentTarget).addClass("reservation-item__input-luggage--active");
});


// Counters - багаж
$(".reservation-popup-luggage .reservation-popup__counter-minus, .reservation-popup-luggage .reservation-popup__counter-plus").click(function() {
    setTimeout(function() {
        var suitcaseNum = $(".reservation-popup-luggage .reservation-popup__item").first().find(".reservation-popup__counter-num").text();
        var bagNum = $(".reservation-popup-luggage .reservation-popup__item").last().find(".reservation-popup__counter-num").text();
        var message = "Чемоданы - " + suitcaseNum + ", ручная кл. - " + bagNum;
        $('input[name="ClientExt[suitcase_count]"]').val(suitcaseNum);
        $('input[name="ClientExt[bag_count]"]').val(bagNum);
        $(".reservation-item__input-luggage").val(message);
    }, 0);
});



// этот код используется для открывающихся мини-форм заполнения багажа, и заполнения кол-ва мест студенов/детей и т.п.
$(".reservation-popup__counter-plus").click(function (event) {

    var counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
    counter++;
    $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);

    var field_type = $(this).attr('field-type');
    if(field_type == 'student') {
        $('input[name="ClientExt[student_count]"]').val(counter);
    }else if(field_type == 'child') {
        $('input[name="ClientExt[child_count]"]').val(counter);
    }else if(field_type == 'adult') {
    }else if(field_type == 'suitcase') {
        $('input[name="ClientExt[suitcase_count]"]').val(counter);
    }else if(field_type == 'bag') {
        $('input[name="ClientExt[bag_count]"]').val(counter);
    }

    if(field_type == 'student' || field_type == 'child' || field_type == 'adult') {
        var calcCounter = parseInt($('input[name="ClientExt[places_count]"]').val());
        calcCounter++;
        $(".reservation-calc__counter-num").text(calcCounter);
        $('input[name="ClientExt[places_count]"]').val(calcCounter);

        updatePrice1();
    }

    toggleSubmitBut1();
    toggleSubmitBut2();
});

$(".reservation-popup__counter-minus").click(function (event) {

    var counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
    if (counter > 0) {
        counter--;
        $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);

        var field_type = $(this).attr('field-type');
        if(field_type == 'student') {
            $('input[name="ClientExt[student_count]"]').val(counter);
        }else if(field_type == 'child') {
            $('input[name="ClientExt[child_count]"]').val(counter);
        }else if(field_type == 'adult') {
        }else if(field_type == 'suitcase') {
            $('input[name="ClientExt[suitcase_count]"]').val(counter);
        }else if(field_type == 'bag') {
            $('input[name="ClientExt[bag_count]"]').val(counter);
        }

        if(field_type == 'student' || field_type == 'child' || field_type == 'adult') {
            var calcCounter = parseInt($('input[name="ClientExt[places_count]"]').val());
            calcCounter--;
            $(".reservation-calc__counter-num").text(calcCounter);
            $('input[name="ClientExt[places_count]"]').val(calcCounter);

            updatePrice1();
        }
    }

    toggleSubmitBut1();
    toggleSubmitBut2();
});



// кол-во мест (студентов, детей и т.п.)  .reservation-calc
var calcCounter = $(".reservation-calc__counter-num").text();

$(".reservation-calc__counter-plus, .reservation-calc__counter-minus").click(function (event) {
    var counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();

    $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);

    $(".reservation-popup-calc").addClass("d-b");
    addOverlay($(".reservation-popup-calc"));
});



function updatePrice1() {

    var access_code = $('#order-client-form').attr('client-ext-code');
    var trip_id = $('input[name="ClientExt[trip_id]"]').val();
    var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
    var places_count = $('input[name="ClientExt[places_count]"]').val();

    var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
    var student_count = $('input[name="ClientExt[student_count]"]').val();
    var child_count = $('input[name="ClientExt[child_count]"]').val();
    var is_not_places = 0;

    // actionAjaxGetPrice($c, $trip_id, $yandex_point_from_id, $yandex_point_to_id = 0, $places_count, $student_count = 0, $child_count = 0, $is_not_places = 0)

    $.ajax({
        url: '/client-ext/ajax-get-price?c='+access_code+'&trip_id='+trip_id+'&yandex_point_from_id='+yandex_point_from_id+'&yandex_point_to_id='+yandex_point_to_id + '&places_count='+places_count + '&student_count=' + student_count + '&child_count=' + child_count + '&is_not_places=' + is_not_places,
        type: 'post',
        data: {},
        beforeSend: function () {},
        success: function (response) {
            //$('#client-ext-unprepayment-price').html(response.unprepayment_price + ' &#8399;');
            //$('#client-ext-prepayment-price').html(response.prepayment_price + ' &#8399;');

            $('.reservation-calc__price').text(response.price);
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
}


// активация/деактивация кнопки отправки данных формы 1
function toggleSubmitBut1() {

    if($('.reservation-undertitle--1').length == 0) {
        return false;
    }

    var trip_id = $('input[name="ClientExt[trip_id]"]').val();
    var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
    var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
    //var bag_count = $('input[name="ClientExt[bag_count]"]').val();
    //var suitcase_count = $('input[name="ClientExt[suitcase_count]"]').val();
    var places_count = $('input[name="ClientExt[places_count]"]').val();
    //console.log('trip_id='+trip_id+' yandex_point_from_id='+yandex_point_from_id+' yandex_point_to_id='+yandex_point_to_id+' places_count='+places_count);

    if(trip_id != '' && yandex_point_from_id != '' && yandex_point_to_id != '' && places_count > 0) {
        $('#submit-create-order-step-1').removeClass('reservation-calc__button--disabled');
    }else {
        if($('#submit-create-order-step-1').hasClass('.reservation-calc__button--disabled') == false) {
            $('#submit-create-order-step-1').addClass('reservation-calc__button--disabled');
        }
    }
}


// блокируем не нужную отправку формы
$(document).on('submit', '#order-client-form', function () {
    return false;
});

// отправка данных формы 1
$(document).on('click', '#submit-create-order-step-1', function() {

    if($(this).hasClass('reservation-calc__button--disabled') == true) {
        return false;
    }


    var ClientExt = {
        //city_from_id: $('input[name="ClientExt[city_from_id]"]').val(),
        //city_to_id: $('input[name="ClientExt[city_to_id]"]').val(),
        //data: $('input[name="ClientExt[data]"]').val(),
        //time: $('input[name="ClientExt[time]"]').val(),

        trip_id: $('input[name="ClientExt[trip_id]"]').val(),
        yandex_point_from_id: $('input[name="ClientExt[yandex_point_from_id]"]').val(),
        yandex_point_to_id: $('input[name="ClientExt[yandex_point_to_id]"]').val(),

        time_air_train_arrival: $('input[name="ClientExt[time_air_train_arrival]"]').val(),

        bag_count: $('input[name="ClientExt[bag_count]"]').val(),
        suitcase_count: $('input[name="ClientExt[suitcase_count]"]').val(),

        places_count: parseInt($('input[name="ClientExt[places_count]"]').val()),
        child_count: $('input[name="ClientExt[child_count]"]').val(),
        student_count: $('input[name="ClientExt[student_count]"]').val()
    };

    var ClientExtChilds = [];
    $('*[name="age"]').each(function() { // self_baby_chair

        var age = $(this).find('.children_complete').text();

        if(age == 'Меньше года') {
            age = '<1';
        }else if(age == 'От 1 до 2 лет') {
            age = '1-2';
        }else if(age == 'От 3 до 6 лет') {
            age = '3-6';
        }else if(age == 'От 7 до 10 лет') {
            age = '7-10';
        }

        var self_baby_chair = $(this).parents('.children_wrap').find('button[name="self_baby_chair"]').hasClass('check_active');

        var ClientExtChild = {
            age: age,
            self_baby_chair: self_baby_chair
        }

        ClientExtChilds[ClientExtChilds.length] = ClientExtChild;
    });

    var post = {
        ClientExt: ClientExt,
        ClientExtChild: ClientExtChilds
    };
    // console.log('post:'); console.log(post);

    var access_code = $('#order-client-form').attr('client-ext-code');

    $.ajax({
        url: '/site/create-order?c=' + access_code,
        type: 'post',
        data: {
            ClientExt: ClientExt,
            ClientExtChild: ClientExtChilds
        },
        success: function (response) {

            // console.log(response);
            if (response.success === true) {

                location.href = response.redirect_url;

            }else {

                var errors = response.errors;
                alert('errors');
                // if(errors.city_from_id !== void 0) {
                //     $('#city_from_id_error').text(errors.city_from_id.join('. '));
                // }
                // if(errors.city_to_id !== void 0) {
                //     $('#city_to_id_error').text(errors.city_to_id.join('. '));
                // }
                // if(errors.data !== void 0) {
                //     $('#data_error').text(errors.data.join('. '));
                // }
                // if(errors.time !== void 0) {
                //     $('#time_error').text(errors.time.join('. '));
                // }
                // if(errors.places_count !== void 0) {
                //     $('#places_count_error').text(errors.places_count.join('. '));
                // }
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


// ---------- функционал для формы-2 -------------

$(document).on('keyup', 'input[name="ClientExt[fio]"]', function(e) {

    var fio = $(this).val();
    fio = fio.replace(/^\s+/g, '');
    if(fio.length > 0) {
        var arr = fio.split(" ");
        for(var i = 0; i < arr.length; i++) {
            if(arr[i][0] != undefined) {
                arr[i] = (arr[i][0]).toUpperCase() + arr[i].substr(1);
            }
        }
        fio = arr.join(" ");

        $(this).val(fio);
    }
});

var has_fio_error = false;
$(document).on('blur', 'input[name="ClientExt[fio]"]', function(e) {

    if(has_fio_error == false) {

        var fio = $(this).val();
        fio = fio.replace(/^\s+/g, '');
        if (fio.length == 0) {
            has_fio_error = true;
            $('#fio').blur();
            alert('Заполните Имя Фамилию');
        } else {
            var arr = fio.split(" ");
            if (arr.length < 2) {
                alert('Заполните имя и фамилию');
                $('#fio').blur();
                has_fio_error = true;
            }
        }
    }else {
        has_fio_error = false;
    }

    toggleSubmitBut2();

    return true;
});

$(document).ready(function() {
    toggleSubmitBut1();
    toggleSubmitBut2();
});


$(document).on('blur', 'input[name="ClientExt[phone]"]', function() {

    var phone = $.trim($(this).val());
    phone = phone.replace(/\*/g,'');
    if(phone[13] == '-') {
        phone = phone.substr(0, 13) + phone.substr(14);
    }


    if(phone.length === 15) {

        $.ajax({
            url: '/user/ajax-check-phone?phone=' + phone,
            type: 'post',
            data: {},
            beforeSend: function () {
            },
            success: function (response) {
                if(response.user_is_exist == true) {
                    alert('С таким телефоном пользователь уже зарегистрирован. Авторизуйтесь пожалуйста для дальнейшего оформления заказа.');
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
                } else {
                    alert('Ошибка');
                }
            }
        });
    }

    toggleSubmitBut2();
});


$(document).on('blur', 'input[name="ClientExt[email]"]', function() {

    var email = $.trim($(this).val());

    if(email.length > 3 && email.indexOf('@') > -1) {
        $.ajax({
            url: '/user/ajax-check-email?email=' + email,
            type: 'post',
            data: {},
            beforeSend: function () {
            },
            success: function (response) {
                if (response.user_is_exist == true) {
                    alert('С такой почтой пользователь уже зарегистрирован. Авторизуйтесь пожалуйста для дальнейшего оформления заказа.');
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
                } else {
                    alert('Ошибка');
                }
            }
        });
    }

    toggleSubmitBut2();
});


// активация/деактивация кнопки отправки данных формы 2
function toggleSubmitBut2() {

    if($('.reservation-undertitle--2').length == 0) {
        return false;
    }

    var phone = $('input[name="ClientExt[phone]"]').val();
    phone = phone.replace(/\*/g,'');
    if(phone[13] == '-') {
        phone = phone.substr(0, 13) + phone.substr(14);
    }
    var fio = $.trim($('input[name="ClientExt[fio]"]').val());
    var email = $.trim($('input[name="ClientExt[email]"]').val());
    var gender = $.trim($('input[name="ClientExt[gen]"]').val());
    var places_count = $('input[name="ClientExt[places_count]"]').val();

    // console.log('phone='+phone+' fio='+fio+' email='+email+' gender='+gender+' places_count='+places_count);

    if(phone.length >= 15 && fio != "" && email != "" && gender != "" && places_count > 0) {
        $('#submit-create-order-step-2').removeClass('reservation-calc__button--disabled');
    }else {
        if($('#submit-create-order-step-2').hasClass('.reservation-calc__button--disabled') == false) {
            $('#submit-create-order-step-2').addClass('reservation-calc__button--disabled');
        }
    }
}


$(document).on('click', '#submit-create-order-step-2', function() {

    if($(this).hasClass('reservation-calc__button--disabled') == true) {
        return false;
    }


    var phone = $('input[name="ClientExt[phone]"]').val();
    phone = phone.replace(/\*/g,'');
    if(phone[13] == '-') {
        phone = phone.substr(0, 13) + phone.substr(14);
    }
    if(phone.length < 15) {
        alert('Введите телефон');
        return false;
    }

    var fio = $.trim($('input[name="ClientExt[fio]"]').val());
    if(fio == "") {
        alert('Введите ваше имя');
        return false;
    }

    var email = $.trim($('input[name="ClientExt[email]"]').val());
    if(email == "") {
        alert('Введите вашу почту');
        return false;
    }

    var gen = $.trim($('input[name="ClientExt[gen]"]').val());
    if(gen != "female" && gen != "male") {
        alert('Выберите пол');
        return false;
    }


    var ClientExt = {

        phone: phone,
        fio: fio,
        email: email,
        gen: gen,

        places_count: parseInt($('input[name="ClientExt[places_count]"]').val()),
        child_count: $('input[name="ClientExt[child_count]"]').val(),
        student_count: $('input[name="ClientExt[student_count]"]').val()
    };

    var ClientExtChilds = [];
    $('*[name="age"]').each(function() { // self_baby_chair

        var age = $(this).find('.children_complete').text();

        if(age == 'Меньше года') {
            age = '<1';
        }else if(age == 'От 1 до 2 лет') {
            age = '1-2';
        }else if(age == 'От 3 до 6 лет') {
            age = '3-6';
        }else if(age == 'От 7 до 10 лет') {
            age = '7-10';
        }

        var self_baby_chair = $(this).parents('.children_wrap').find('button[name="self_baby_chair"]').hasClass('check_active');

        var ClientExtChild = {
            age: age,
            self_baby_chair: self_baby_chair
        }

        ClientExtChilds[ClientExtChilds.length] = ClientExtChild;
    });

    var post = {
        ClientExt: ClientExt,
        ClientExtChild: ClientExtChilds
    };

    var access_code = $('#order-client-form').attr('client-ext-code');

    $.ajax({
        url: '/site/create-order-step2?c=' + access_code,
        type: 'post',
        data: {
            ClientExt: ClientExt,
            ClientExtChild: ClientExtChilds
        },
        success: function (response) {

            if (response.success === true) {
                location.href = response.redirect_url;
            }else {

                var errors = response.errors;
                alert(errors);
                // if(errors.city_from_id !== void 0) {
                //     $('#city_from_id_error').text(errors.city_from_id.join('. '));
                // }
                // if(errors.city_to_id !== void 0) {
                //     $('#city_to_id_error').text(errors.city_to_id.join('. '));
                // }
                // if(errors.data !== void 0) {
                //     $('#data_error').text(errors.data.join('. '));
                // }
                // if(errors.time !== void 0) {
                //     $('#time_error').text(errors.time.join('. '));
                // }
                // if(errors.places_count !== void 0) {
                //     $('#places_count_error').text(errors.places_count.join('. '));
                // }
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


// нажатие на уже выбранный адрес точки откуда - открывает заново карту
$(document).on('click', "#city-from-block .reservation-step-line-change", function() {

    // закрываем статичную карту если открыта
    if( $('.reservation-step-line_departure .reservation-step-line-map').hasClass('d-b') ) {
        $('.reservation-step-line_departure .reservation-step-line-showmap').click(); // сворачиваем карту
    }


    var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();

    // всплытие формы с открытой картой с наведением на выбранную ранее точку откуда
    openSelectPointFromModal(function() {

        $(".reservation-drop__map").addClass("d-b");
        $('.reservation-drop__content').css("padding-bottom", "80px");

        loadMap('map_from', 'ya-map-from', 1, function () {

            // var coordinates = [yandex_point_from_lat, yandex_point_from_lon];
            // if(map_from == null) {
            //     alert('map_from = null');
            // }
            // map_from.setCenter(coordinates, 16, {duration: 500});

            if(map_from == null) {

                alert('map_from = null');

            }else {

                var select_point_placemark_params = {
                    //index: yandex_point_from_index,
                    //point_text: yandex_point_from_name,
                    point_id: yandex_point_from_id,
                    //is_editing: true,
                    //create_new_point: true,
                    can_change_params: false,
                    //critical_point: yandex_point.critical_point,
                    //alias: yandex_point.alias,
                    draggable: false,
                    is_allowed_edit: false,
                    point_focusing_scale: 16
                };
                selectPointPlacemark(map_from, select_point_placemark_params);
            }
        });
    });
});

$(document).on('click', "#city-from-block .reservation-step-line-showmap", function(event) {

    var $elem = $(this).closest(".reservation-step-line-content").find(".reservation-step-line-map");
    if($elem.hasClass('d-b')) { // закрытие карты
        $elem.removeClass('d-b');
    }else { // отображаем карту
        $elem.addClass('d-b');

        if($('#ya-map-from-static').html() == '') {

            loadMap('map_from_static', 'ya-map-from-static',1, function () {

                var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
                var select_point_placemark_params = {
                    point_id: yandex_point_from_id,
                    can_change_params: false,
                    draggable: false,
                    is_allowed_edit: false,
                    point_focusing_scale: 16
                };
                selectPointPlacemark(map_from_static, select_point_placemark_params);
            });

        }else {

            var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
            var select_point_placemark_params = {
                point_id: yandex_point_from_id,
                can_change_params: false,
                draggable: false,
                is_allowed_edit: false,
                point_focusing_scale: 16
            };
            selectPointPlacemark(map_from_static, select_point_placemark_params);
        }
    }
});

$(document).on('click', "#city-to-block .reservation-step-line-showmap", function(event) {

    var $elem = $(this).closest(".reservation-step-line-content").find(".reservation-step-line-map");
    if($elem.hasClass('d-b')) { // закрытие карты
        $elem.removeClass('d-b');
    }else { // отображаем карту
        $elem.addClass('d-b');

        if($('#ya-map-to-static').html() == '') {

            loadMap('map_to_static', 'ya-map-to-static',0, function () {

                var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
                // alert('yandex_point_to_id='+yandex_point_to_id);

                var select_point_placemark_params = {
                    point_id: yandex_point_to_id,
                    can_change_params: false,
                    draggable: false,
                    is_allowed_edit: false,
                    point_focusing_scale: 16
                };
                selectPointPlacemark(map_to_static, select_point_placemark_params);
            });

        }else {

            // alert('Устанавливаем точку...3');

            var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
            var select_point_placemark_params = {
                point_id: yandex_point_to_id,
                can_change_params: false,
                draggable: false,
                is_allowed_edit: false,
                point_focusing_scale: 16
            };
            selectPointPlacemark(map_to_static, select_point_placemark_params);
        }
    }
});


// нажатие на уже выбранный адрес точки куда - открывает заново карту
$(document).on('click', "#city-to-block .reservation-step-line-change2", function() {


    // закрываем статичную карту если открыта
    if( $('.reservation-step-line_arrival .reservation-step-line-map').hasClass('d-b') ) {
        $('.reservation-step-line_arrival .reservation-step-line-showmap').click(); // сворачиваем карту
    }


    var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
    //var yandex_point_to_lat = $('input[name="ClientExt[yandex_point_to_id]"]').attr('lat');
    //var yandex_point_to_lon = $('input[name="ClientExt[yandex_point_to_id]"]').attr('lon');
    openSelectPointToModal(function() {

        // var coordinates = [yandex_point_to_lat, yandex_point_to_lon];
        // map_to.setCenter(coordinates, 16, {duration: 500});

        if(map_to == null) {
            alert('map_to = null');
        }else {

            //alert('наводим на точку yandex_point_to_id='+yandex_point_to_id);
            var select_point_placemark_params = {
                //index: yandex_point_from_index,
                //point_text: yandex_point_from_name,
                point_id: yandex_point_to_id,
                //is_editing: true,
                //create_new_point: true,
                can_change_params: false,
                //critical_point: yandex_point.critical_point,
                //alias: yandex_point.alias,
                draggable: false,
                is_allowed_edit: false,
                point_focusing_scale: 16
            };
            var point_placemark = selectPointPlacemark(map_to, select_point_placemark_params);
            var balloonContent = point_placemark.properties.get('balloonContent');
            var yandex_point_to_name = parseNameFromTemplate(balloonContent);

            selectWidgetInsertValue($('input[name="search_yandex_point_to_id"]').parents('.sw-element'), yandex_point_to_id, yandex_point_to_name);
        }
    });
});


// поиск в точке откуда в адресной строке
$(document).on('keyup', '#search-place-to', function(e) {

    var search = $.trim($(this).val());
    if(search.length > 1) {

        var $search_obj = $(this);
        var city_id = $('#city-to').attr('city-id');
        if(city_id == 1) { // Казань
            var city_long = 49.11;
            var city_lat = 55.79;
            var city_name = "Казань";
        }else if(city_id == 2) {
            var city_long = 52.3;
            var city_lat = 54.9;
            var city_name = "Альметьевск";
        }


        var url = 'https://suggest-maps.yandex.ru/suggest-geo?' +
            '&v=7' +
            '&search_type=all' +
            '&part=Республика Татарстан, ' + city_name + ", " + search +
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
                if(response.results.length > 0) {

                    html = '<ul class="main-list">';
                    var lis = [];
                    var first_lis = []; // для мини-сортировки - строки в которых используется название города попадают в первый список
                    for(var i = 0; i < response.results.length; i++) {
                        var result = response.results[i];
                        var str = '<li lat="' + result.lat + '" lon="' + result.lon + '">' + result.name + '</li>';
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
    }
});


// выбор пола
$(document).on('click', '.gen_select', function (event) {
    event.preventDefault();
    event.stopPropagation();

    $('.select_gen_wrap').hide();
    $(this).toggleClass('fix_down');

    if ($(this).hasClass('fix_down')) {
        $(this).find('.select_gen_wrap').slideDown(100);
    } else {
        $('.select_gen').removeClass('fix_down');
    }
});

$(document).on('click', '.select_gen__item', function (event) {
    event.preventDefault();
    event.stopPropagation();

    var gen_id = $(this).attr('data-val');
    var gen_value = $(this).attr('data-gen');
    $('*[name="ClientExt[gen]"]').val(gen_id);
    $('#reservation-gen').val(gen_value);

    $(this).parents('.welcome__col').find('.select_gen_wrap').slideUp(100);
    $('.gen_select').removeClass('fix_down');

    toggleSubmitBut2();
});

$(document).on('keydown', '#reservation-gen', function() {
    return false;
});

//Reservation tabs
$(".reservation-tab--second").click(function(event) {
    $(".reservation-tab--first").removeClass("reservation-tab--active");
    $(".reservation-tab--second").addClass("reservation-tab--active");
    $(".reservation-content").addClass("d-n");
    $(".reservation-services").addClass("d-b");
});

$(".reservation-tab--first").click(function(event) {
    $(".reservation-tab--second").removeClass("reservation-tab--active");
    $(".reservation-tab--first").addClass("reservation-tab--active");
    $(".reservation-content").removeClass("d-n");
    $(".reservation-services").removeClass("d-b");
});