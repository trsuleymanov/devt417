

//Address steps
var isCompletedAddress = false;
var isCompletedDest = false;

var geolocation = null;
var map_from = null;
var map_from2 = null;
var map_from_static = null;
var map_to = null;
var point_placemark = null;
var map_scale = 15; // масшаб карты при открытии карты
var point_focusing_scale = 17; // масштаб фокусировки выбранной точки
var all_points_show_scale = 12;
var time_to_close_map = 3000;

// возвращается объект карты - placemark (т.е. точка)
function getPlacemarkById(map_name, point_id) {

    var searched_placemark = null;

    this[map_name].geoObjects.each(function (placemark, i) {
        if(point_id == placemark.properties.get('point_id')) {
            searched_placemark = placemark;
            return;
        }
    });

    return searched_placemark;
}

// возвращаается html для балуна (балун - это "статичное" окошко - открывается при клике на точке)
function getBalloonContent(point_id, point_name, point_description, is_selected) {


    if(is_selected == true) {

        var content =
            '<div class="placemark-balloon-content" point-id="' + point_id + '">' +
            '<b>' + point_name + '</b>' +
            '<br />' +
            point_description +
            '<br />' +
            ' (выбрано)' +
            '</div>';
    }else {
        var content =
            '<div class="placemark-balloon-content" point-id="' + point_id + '">' +
            '<b>' + point_name + '</b>' +
            '<br />' +
            point_description +
            '<br />' +
            '<button class="btn-select-placemark content-btn">Выбрать</button>' +
            '</div>';
    }

    return content;
}

// возвращается html для всплывающей подсказки над точкой
function getHintContent(point_name, point_description, is_selected) {

    var hintContent = '<b>' + point_name + '</b>';
    if(point_description != '') {
        hintContent += '<br />' + point_description;
    }

    if(is_selected == true) {
        hintContent += ' (точка выбрана)';
    }

    return hintContent;
}

// создание точки
function createPlacemark(map_name, params) {


    if(params['point_id'] == undefined) {
        alert('отстутсвует id точки');
        return false;
    }
    if(params['point_name'] == undefined) {
        alert('отстутсвует имя точки');
        return false;
    }
    if(params['point_description'] == undefined) {
        params['point_description'] = '';
    }
    if(params['type_map'] != 'from' && params['type_map'] != 'to') {
        alert('Тип карты не определен');
        return false;
    }
    if(params['point_lat'] == undefined) {
        alert('отстутсвуют координаты точки');
        return false;
    }
    if(params['point_long'] == undefined) {
        alert('отстутсвуют координаты точки');
        return false;
    }



    var placemark = new ymaps.Placemark([params['point_lat'], params['point_long']], {

        // устанавливаем "внутреннее содержимое точки"
        hintContent: getHintContent(
            params['point_name'],
            params['point_description'],
            false
        ),
        // balloonContentHeader: balloonContentHeader,
        balloonContent: getBalloonContent(
            params['point_id'],
            params['point_name'],
            params['point_description'],
            false
        ),
        point_id: params['point_id'],
        point_name: params['point_name'],
        point_description: params['point_description'],
        is_selected: false,
        is_highlighted: false,
        type_map: params['type_map']

    }, {
        // устанавливаем вид поинта на карте
        visible: false,
        iconLayout: 'default#image', // ему нельзя цвет установить
        //iconColor: '#1E98FF',
        iconImageSize: [24, 24], // не работает когда НЕТ предустановленного iconLayout='default#image'
    });


    // устанавливаем события на точке
    placemark.events.add('mouseenter', function (event) {

        if(placemark.properties.get('is_highlighted') == false) {

            placemark.options.unset('iconOffset');
            placemark.options.unset('iconSize');
            placemark.options.unset('iconLayout');
            placemark.options.unset('iconColor');
            placemark.options.unset('iconShape');

            if (params['type_map'] == 'from') {

                placemark.options.set({
                    preset: "islands#violetStretchyIcon", // ему нельзя размер установить
                });

            } else if (params['type_map'] == 'to') {

                placemark.options.set({
                    preset: "islands#orangeStretchyIcon", // ему нельзя размер установить
                    // iconLayout: 'default#image', // ему нельзя цвет установить
                    //preset: 'islands#orangeIcon', // не меняется размер
                    //preset: 'islands#darkOrangeDotIcon',
                    //preset: 'islands#orangeCircleIcon',

                    //        iconLayout: 'islands#circleIcon',
                    //        iconLayout: 'default#image', // для default#image iconColor не меняется
                    //        iconColor: '#ffa500',
                    //iconSize: [8, 8],
                    //iconOffset: [0, 0],

                    // Определим интерактивную область над картинкой.
                    // iconShape: {
                    //     type: 'Circle',
                    //     coordinates: [0, 0],
                    //     radius: 8
                    // }
                    //iconImageHref: '/images/account/close_black.png', // картинка иконки
                    //iconImageSize: [24, 24], // размеры картинки
                    //iconImageOffset: [0, 0]
                });

            }

        }
    });
    placemark.events.add('mouseleave', function (event) {

        if(placemark.properties.get('is_highlighted') == false) {

            placemark.options.unset('iconOffset');
            placemark.options.unset('iconSize');
            placemark.options.unset('iconLayout');
            placemark.options.unset('iconColor');
            placemark.options.unset('iconShape');

            placemark.options.set({
                iconLayout: 'default#image', // ему нельзя цвет установить
                iconImageSize: [24, 24],
            });
        }
    });
    // placemark.events.add('balloonopen', function (event) {
    //
    //     if(placemark.properties.get('is_selected') == true) {
    //         // прячем кнопку "Выбрать" если она уже была выбрана
    //         alert('balloonopen');
    //     }
    // });
    placemark.events.add('balloonclose', function (event) {

        if(placemark.properties.get('is_highlighted') == false) {

            placemark.options.unset('iconOffset');
            placemark.options.unset('iconSize');
            placemark.options.unset('iconLayout');
            placemark.options.unset('iconColor');
            placemark.options.unset('iconShape');

            placemark.options.set({
                iconLayout: 'default#image', // ему нельзя цвет установить
                iconImageSize: [24, 24],
            });
        }
    });
    placemark.events.add('click', function (event) {

        // клик на точке делает точку выбранной
        //selectPlacemark(map_name, params['point_id']);

        // клик на точек делает ее выделенной (is_highlighted = true)
        highlightePlacemark(map_name, placemark);
    });

    if(this[map_name] == null) {
        console.log('map = null');
    }else {
        this[map_name].geoObjects.add(placemark);
    }


    return placemark;
}


// Метод снимает выделение со всех точек кроме выбранной
function unhighlighteAllPlacemarks(map_name) {

    this[map_name].geoObjects.each(function (placemark, i) {
        if(placemark.properties.get('is_highlighted') == true && placemark.properties.get('is_selected') != true) {

            // устанавливаем "внутреннее содержимое точки"
            placemark.properties.set({
                is_selected: false,
                is_highlighted: false,
                hintContent: getHintContent(
                    placemark.properties.get('point_name'),
                    placemark.properties.get('point_description'),
                    false
                ),
                balloonContent: getBalloonContent(
                    placemark.properties.get('point_id'),
                    placemark.properties.get('point_name'),
                    placemark.properties.get('point_description'),
                    false
                ),
            });

            // устанавливаем вид поинта на карте
            placemark.options.unset('iconOffset');
            placemark.options.unset('iconSize');
            placemark.options.unset('iconLayout');
            placemark.options.unset('iconColor');
            placemark.options.unset('iconShape');

            placemark.options.set({
                iconLayout: 'default#image', // ему нельзя цвет установить
                //iconColor: '#1E98FF',
                iconImageSize: [24, 24], // не работает когда НЕТ предустановленного iconLayout='default#image'
            });
        }
    });
}

// Метод реализует выделение точки
function highlightePlacemark(map_name, placemark) {

    unhighlighteAllPlacemarks(map_name);

    placemark.properties.set('is_highlighted', true);

    // устанавливаем вид поинта на карте
    placemark.options.unset('iconImageOffset');
    placemark.options.unset('iconImageSize');
    placemark.options.unset('iconLayout');
    placemark.options.unset('iconShape');
    placemark.options.unset('iconColor');

    if(placemark.properties.get('type_map') == 'from') {
        placemark.options.set({
            preset: "islands#violetStretchyIcon",
        });
    }else if(placemark.properties.get('type_map') == 'to') {
        placemark.options.set({
            preset: "islands#orangeStretchyIcon",
        });
    }
}

// Метод реализует выбор точки
function selectPlacemark(map_name, point_id) {


    unselectAllPlacemarks(map_name); // убрали флаг is_selected=true и поменяли вид подсказки и окошка "статичного"
    unhighlighteAllPlacemarks(map_name); // убрали выделение is_highlighted=true и поменяли внешний вид точки

    var placemark = getPlacemarkById(map_name, point_id);

    // устанавливаем "внутреннее содержимое точки"
    placemark.properties.set({
        is_selected: true,
        is_highlighted: true,
        hintContent: getHintContent(
            placemark.properties.get('point_name'),
            placemark.properties.get('point_description'),
            true
        ),
        balloonContent: getBalloonContent(
            placemark.properties.get('point_id'),
            placemark.properties.get('point_name'),
            placemark.properties.get('point_description'),
            true
        ),
    });



    // // устанавливаем вид поинта на карте
    // placemark.options.unset('iconImageOffset');
    // placemark.options.unset('iconImageSize');
    // placemark.options.unset('iconLayout');
    // placemark.options.unset('iconShape');
    // placemark.options.unset('iconColor');
    //
    // if(placemark.properties.get('type_map') == 'from') {
    //     placemark.options.set({
    //         preset: "islands#violetStretchyIcon",
    //     });
    // }else if(placemark.properties.get('type_map') == 'to') {
    //     placemark.options.set({
    //         preset: "islands#orangeStretchyIcon",
    //     });
    // }

    highlightePlacemark(map_name, placemark);

    return placemark;
}

// метод снимает выделение со всех выделенных точек (хотя такая может быть только одна)
function unselectAllPlacemarks(map_name) {

    this[map_name].geoObjects.each(function (placemark, i) {
        if(placemark.properties.get('is_selected') == true) {

            // устанавливаем "внутреннее содержимое точки"
            placemark.properties.set({
                is_selected: false,
                is_highlighted: false,
                hintContent: getHintContent(
                    placemark.properties.get('point_name'),
                    placemark.properties.get('point_description'),
                    false
                ),
                balloonContent: getBalloonContent(
                    placemark.properties.get('point_id'),
                    placemark.properties.get('point_name'),
                    placemark.properties.get('point_description'),
                    false
                ),
            });

            // устанавливаем вид поинта на карте
            // placemark.options.unset('iconOffset');
            // placemark.options.unset('iconSize');
            // placemark.options.unset('iconLayout');
            // placemark.options.unset('iconColor');
            // placemark.options.unset('iconShape');
            //
            // placemark.options.set({
            //     iconLayout: 'default#image', // ему нельзя цвет установить
            //     //iconColor: '#1E98FF',
            //     iconImageSize: [24, 24], // не работает когда НЕТ предустановленного iconLayout='default#image'
            // });
        }
    });
}



function addOverlay($popup, triggerActiveClass) {
    $("body").append('<div class="popup-overlay"></div>');
    $(".popup-overlay").click(function(event) {
        $("." + triggerActiveClass).removeClass(triggerActiveClass);
        $popup.removeClass("d-b");
        $(event.currentTarget).remove();
    });
}



// отображение/скрытие точек в зависимости от зума карты
function showHidePlacemarks(map_name, current_map_zoom, all_points_show_scale) {

    // console.log('пограничный scale=' + all_points_show_scale + ' current_map_zoom=' + current_map_zoom);

    if(this[map_name] != null) {
        if (current_map_zoom < all_points_show_scale) { // прячу все точки кроме выбранной точки
            this[map_name].geoObjects.each(function (placemark, i) {
                if (placemark.properties.get('is_selected') == false) {
                    placemark.options.set('visible', false);
                }
            })
        } else { // отображаю все точки кроме выбранной
            this[map_name].geoObjects.each(function (placemark, i) {
                if (placemark.properties.get('is_selected') == false) {
                    placemark.options.set('visible', true);
                }
            })
        }
    }
}


// это аналог функции openMapWithPointFrom()
function loadMap(map_name, map_id, is_from, return_function) {

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
                        zoom: map_scale,
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
                        showHidePlacemarks(map_name, event.get('newZoom'), all_points_show_scale);
                    });

                    // Множество существующих точек
                    for (var key in response.yandex_points) { // только базовые точки в списке

                        var yandex_point = response.yandex_points[key];

                        // var index = this[map_name].geoObjects.getLength();
                        var create_placemark_params = {
                            point_name: yandex_point.name,
                            point_description: yandex_point.description,
                            point_id: yandex_point.id,
                            point_lat: yandex_point.lat,
                            point_long: yandex_point.long,
                            type_map: (is_from == 1 ? 'from' : 'to')
                        };
                        var placemark = createPlacemark(map_name, create_placemark_params);
                    }

                    showHidePlacemarks(map_name, map_scale, all_points_show_scale);

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
                // $('.reservation-drop--1').hide();
                // $(".main-overlay").remove();
                closeFormFrom();
            });

            $('.reservation-drop--1').find('.reservation-drop__content').html(html);
            $('.reservation-drop--1').show();


            // $('.reservation-drop--1').click(function() {
            //     alert('sf');
            //     $('#search-from-block').find('.search-result-block').html('').hide();
            // });


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

// $(document).on('click', '.reservation-drop--1', function() {
//     alert('sf');
// });


function openSelectPointToModal(response_function) {

    var access_code = $('#order-client-form').attr('client-ext-code');
    $.ajax({
        url: '/client-ext/get-select-point-to-form?c=' + access_code,
        type: 'post',
        data: {},
        success: function (html) {

            $("body").append('<div class="main-overlay"></div>');
            $(".main-overlay").click(function(event) {
                // $('.reservation-drop--2').hide();
                // $(".main-overlay").remove();
                closeFormTo();
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


function setPointTo(yandex_point_to_id, yandex_point_to_name) {

    $('input[name="ClientExt[yandex_point_to_id]"]').val(yandex_point_to_id);
    $('.reservation-step-line-dest-address').html(yandex_point_to_name);

    // в форме заказа внешний вид пункта назначения становиться установленным, а не пустым
    $(".reservation-step-line-content-top-left--empty2").addClass("d-n");
    $(".reservation-step-line-content-top-left--ready2").addClass("d-b");
    $(".reservation-step-line-selecte--2").addClass("d-n");

    toggleSubmitBut1(); // в форме заказа внешний вид кнопки "Продолжить" обновляем
}


// функция показывает карту, на ней выбранную точку, затем через 2 секунды открывается окно
//  для выбора времени (выбором рейса)
function showMapFromAndOpenTripTimes(yandex_point_from_id) {

    if($(".reservation-drop__map").hasClass('d-b') == false) {

        loadMap('map_from', 'ya-map-from', 1, function () {
            $(".reservation-drop__map").addClass("d-b");

            var placemark = selectPlacemark('map_from', yandex_point_from_id);
            var coordinates = placemark.geometry.getCoordinates();
            map_from.setCenter(coordinates, point_focusing_scale, {duration: 500});

            setTimeout(function () {
                placemark.balloon.open();
            }, 500);


            // var scroll_height = $("#ya-map-from").offset().top + $("#ya-map-from").height()/2 - $("html").scrollTop();
            // var scroll_height = $("#ya-map-from").offset().top - $("html").scrollTop();
            // $("html").animate({
            //     scrollTop: scroll_height
            // }, 1000);

            // через time_to_close_map секунд закрываем карту и открываем окно с выбором времени (выбором рейса)
            setTimeout(function() {

                var access_code = $('#order-client-form').attr('client-ext-code');
                loadTripTimes(access_code, yandex_point_from_id, function(ajax_response) {
                    addressToStep2();
                });

            }, time_to_close_map);

        });

    }else {

        var placemark = selectPlacemark('map_from', yandex_point_from_id);
        var coordinates = placemark.geometry.getCoordinates();
        map_from.setCenter(coordinates, point_focusing_scale, {duration: 500});

        setTimeout(function () {
            placemark.balloon.open();
        }, 500);

        // var scroll_height = $("#ya-map-from").offset().top + $("#ya-map-from").height()/2 - $("html").scrollTop();
        // var scroll_height = $("#ya-map-from").offset().top - $("html").scrollTop();
        // $("html, body").animate({
        //     scrollTop: scroll_height
        // }, 1000);

        // через time_to_close_map секунд закрываем карту и открываем окно с выбором времени (выбором рейса)
        setTimeout(function() {

            var access_code = $('#order-client-form').attr('client-ext-code');
            loadTripTimes(access_code, yandex_point_from_id, function(ajax_response) {
                addressToStep2();
            });

        }, time_to_close_map);

    }
}

// устанавливается на странице для точки посадки значение, также устанавливаются
//  напротив городов - время отправки и приблизительное время прибытие, и устанавливается рассчетное время в пути
function setPointFromWithTripTimes(point_from_id, point_from_name, point_from_description, trip_id, departure_time, departure_date, arrival_time, arrival_date) {

    $('input[name="ClientExt[trip_id]"]').val(trip_id);
    $('input[name="ClientExt[yandex_point_from_id]"]').val(point_from_id);


    if(point_from_description != '') {
        point_from_name += ', ' + point_from_description;
    }


    $('#city-from-block')
        .find('.reservation-step-line-address-wrap')
        .html('<div class = "reservation-step-line-address">'+ point_from_name +'</div><div class="reservation-step-line-change">Изменить адрес посадки</div>');

    $(".reservation-step-line-content-top-left--empty1").addClass("d-n");
    $(".reservation-step-line-content-top-left--ready1").addClass("d-b");
    $(".reservation-step-line-selecte--1").addClass("d-n");


    // напротив городов - время посадки и время прибытия
    $('.reservation-step-line_departure .reservation-step-line-time').text( departure_time );
    $('.reservation-step-line_departure .reservation-step-line-date').text( departure_date );
    $('.reservation-step-line_arrival .reservation-step-line-time').text( '~ '+ arrival_time );
    $('.reservation-step-line_arrival .reservation-step-line-date').text( arrival_date );


    // рассчетное время в пути отображается
    //if( $('input[name="ClientExt[yandex_point_to_id]"]').val() != '' ){
        $('.reservation-average').removeClass("d-n");
        $('.reservation-average').addClass("d-b");
    //}


    toggleSubmitBut1(); // в форме заказа внешний вид кнопки "Продолжить" обновляем
    updatePrice1();
}


function closeFormFrom() {

    $('.reservation-drop--1').find('.reservation-drop__content').html('');
    $('.reservation-drop--1').hide();
    $(".main-overlay").remove();
}

function closeFormTo() {

    $('.reservation-drop--2').find('.reservation-drop__content').html('');
    $('.reservation-drop--2').hide();
    $(".main-overlay").remove();
}


function closeMap(map_name) {

    if (map_name == 'map_to') {

        // закрытия этой карты не должно быть, так как закрывается форма

    }else if(map_name == 'map_to_static') {

        // сворачиваем карту
        $('.reservation-step-line_arrival .reservation-step-line-showmap').click();

    }else if(map_name == 'map_from') {

        // закрытия этой карты не должно быть, так как закрывается форма

    }else if(map_name == 'map_from2') {

        $(".reservation-drop__selected-map").removeClass('d-b');

    }else if(map_name == 'map_from_static') {

        $(".reservation-step-line-content").find(".reservation-step-line-map").removeClass('d-b');
    }
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




// +
// выбор точки посадки на всплывающей карте
$(document).on('click', '#ya-map-from .btn-select-placemark', function() {

    var yandex_point_from_id = $(this).parents('.placemark-balloon-content').attr('point-id');
    showMapFromAndOpenTripTimes(yandex_point_from_id);
});
// +
// выбор точки посадки на карте открытой внутри "окна" выбора времени рейса
$(document).on('click', '#ya-map-from2 .btn-select-placemark', function() {

    var yandex_point_from_id = $(this).parents('.placemark-balloon-content').attr('point-id');

    var placemark = selectPlacemark('map_from2', yandex_point_from_id);
    var coordinates = placemark.geometry.getCoordinates();
    map_from2.setCenter(coordinates, point_focusing_scale, {duration: 500});

    // через time_to_close_map секунд закрываем карту и открываем окно с выбором времени (выбором рейса)
    setTimeout(function() {

        var access_code = $('#order-client-form').attr('client-ext-code');
        loadTripTimes(access_code, yandex_point_from_id, function(ajax_response) {
            addressToStep2();
            closeMap('map_from2');
        });

    }, time_to_close_map - 500); // здесь на 0.5 сек уменьшаю так как данные по времени рейсов еще грузяться с сервера

});
// +
// выбор точки посадки на "статичной" карте открытой на странице с формой заказа
$(document).on('click', '#ya-map-from-static .btn-select-placemark', function() {

    var yandex_point_from_id = $(this).parents('.placemark-balloon-content').attr('point-id');

    var placemark = selectPlacemark('map_from_static', yandex_point_from_id);
    var coordinates = placemark.geometry.getCoordinates();
    map_from_static.setCenter(coordinates, point_focusing_scale, {duration: 500});

    setTimeout(function() {
        placemark.balloon.close();
    }, 500);


    // нужно открыть окно для выбора времени рейса
    openSelectPointFromModal(function() {
        var access_code = $('#order-client-form').attr('client-ext-code');
        loadTripTimes(access_code, yandex_point_from_id, function(ajax_response) {
            addressToStep2();
        });
    });
});


// +
$(document).on('click', '#ya-map-to .btn-select-placemark', function() {

    var yandex_point_to_id = $(this).parents('.placemark-balloon-content').attr('point-id');

    var placemark = selectPlacemark('map_to', yandex_point_to_id);
    var coordinates = placemark.geometry.getCoordinates();
    map_to.setCenter(coordinates, point_focusing_scale, {duration: 500});

    setTimeout(function() {
        placemark.balloon.close();
    }, 500);

    var yandex_point_to_name = placemark.properties.get('point_name');

    // через time_to_close_map секунд закрываем карту (закрываем форму)
    setTimeout(function() {
        setPointTo(yandex_point_to_id, yandex_point_to_name);
        closeFormTo();

    }, time_to_close_map);

});

// +
$(document).on('click', '#ya-map-to-static .btn-select-placemark', function() {

    var yandex_point_to_id = $(this).parents('.placemark-balloon-content').attr('point-id');

    var placemark = selectPlacemark('map_to_static', yandex_point_to_id);
    var coordinates = placemark.geometry.getCoordinates();
    map_to.setCenter(coordinates, point_focusing_scale, {duration: 500});

    setTimeout(function() {
        placemark.balloon.close();
    }, 500);

    var yandex_point_to_name = placemark.properties.get('point_name');

    // через time_to_close_map секунд закрываем карту (сворачиваем карту)
    setTimeout(function() {

        setPointTo(yandex_point_to_id, yandex_point_to_name)
        closeMap('map_to_static');

    }, time_to_close_map);
});




$(document).on('click', '#open-select-point-from', function(e) {
    openSelectPointFromModal();
});

// +
// выбор популярной точки в форме "Адрес и время посадки"
$(document).on('click', '.select-point-from', function() {

    var yandex_point_from_id = $(this).attr('data-id');
    showMapFromAndOpenTripTimes(yandex_point_from_id);
});

// клик в пустом поле пункта назначения в форме заказа открывает форму выбора пункта назначения
$(document).on('click', '#open-select-point-to', function(e) {
    openSelectPointToModal();
});

// +
$(document).on('click', '.select-point-to', function() {

    var yandex_point_to_id = $(this).attr('data-id');

    var placemark = selectPlacemark('map_to', yandex_point_to_id);
    var coordinates = placemark.geometry.getCoordinates();
    map_to.setCenter(coordinates, point_focusing_scale, {duration: 500});

    setTimeout(function () {
        placemark.balloon.open();
    }, 500);

    var yandex_point_to_name = placemark.properties.get('point_name');

    // через time_to_close_map секунд закрываем карту
    setTimeout(function() {

        setPointTo(yandex_point_to_id, yandex_point_to_name)
        closeFormTo();

    }, time_to_close_map);
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

// +
// выбор "синей" точки супер-предложения
$(document).on('click', '.reservation-drop-offer__item', function () {

    var yandex_point_from_id = $(this).attr('yandex-point-id');
    showMapFromAndOpenTripTimes(yandex_point_from_id);
});



// закрытие формы "Адрес и время посадки"
$(document).on('click', '.reservation-drop--1 .reservation-drop__topline-cancel', function () {
    closeFormFrom();
});

// закрытие формы Пункт назначения
$(document).on('click', '.reservation-drop--2 .reservation-drop__topline-cancel', function () {
    closeFormTo();
});



$(document).ready(function() {
    $(".reservation-drop__map").addClass("d-b");
});

// +
// label 'использовать мою геопозицию'
$(document).on('click', '.reservation-drop__search-geo span', function() {

    // показ (с наведением на текущую позицию) или скрытие карты
    if($(".reservation-drop__map").hasClass('d-b')) {

        // карта остается открытой, наводим на текущую позицию пользователя
        ymaps.geolocation.get({
            mapStateAutoApply: true
        }).then(function (result) {
            var coordinates = result.geoObjects.get(0).geometry.getCoordinates();
            map_from.setCenter(coordinates, map_scale, {duration: 500});
        });

    }else {

        loadMap('map_from', 'ya-map-from', 1, function () {

            ymaps.geolocation.get({
                mapStateAutoApply: true
            }).then(function (result) {
                var coordinates = result.geoObjects.get(0).geometry.getCoordinates();
                map_from.setCenter(coordinates, map_scale, {duration: 500});
            });
        });
    }
    $(".reservation-drop__map").toggleClass("d-b");
});


// +
// в форме выбора точки посадке в "окне" выбора времени посадки (рейса) нажатие на "на карте"
$(document).on('click', ".reservation-drop__selected-showmap-trigger", function () {

    var $elem = $(".reservation-drop__selected-map");
    if($elem.hasClass('d-b')) { // закрытие карты
        $elem.removeClass('d-b');
    }else { // отображаем карту
        $elem.addClass('d-b');
        loadMap('map_from2', 'ya-map-from2',1, function () {

            var $elem2 = $('.reservation-drop--1').find('.reservation-drop__selected-address');
            var yandex_point_from_id = $elem2.attr('yandex-point-id');
            var placemark = selectPlacemark('map_from2', yandex_point_from_id);
            var coordinates = placemark.geometry.getCoordinates();
            map_from2.setCenter(coordinates, point_focusing_scale, {duration: 500});
        });
    }
});

// +
// выбор одного из 3-х времен рейса
$(document).on('click', '.reservation-drop__time-item', function() {

    var $this = $(this);
    var timeItemAnimate = setInterval(function(){
        $this.toggleClass('selected');
    }, 300);

    var yandex_point_id = $(this).attr('yandex-point-id');
    var yandex_point_name = $(this).attr('yandex-point-name');
    var yandex_point_description = $(this).attr('yandex-point-description');
    var trip_id = $(this).attr('trip-id');

    var departure_time = $(this).attr('data-departure-time');
    var departure_date = $(this).attr('data-departure-date');
    var arrival_time = $(this).attr('data-arrival-time');
    var arrival_date = $(this).attr('data-arrival-date');

    setPointFromWithTripTimes(
        yandex_point_id, yandex_point_name, yandex_point_description,
        trip_id,
        departure_time, departure_date, arrival_time, arrival_date
    );


    setTimeout(function(){

        closeFormFrom();
        closeMap('map_from_static'); // может быть открыта
        clearInterval(timeItemAnimate);
    }, 2000);
});


// поиск в точке откуда в адресной строке
$(document).on('focus', '#search-place-from', function(e) {
    $('.reservation-drop-offer__list').removeClass('d-b');
});

// +
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



// +
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
        map_from.setCenter(coordinates, point_focusing_scale, {duration: 500});

    }else {

        $(".reservation-drop__map").addClass("d-b");
        $('.reservation-drop__content').css("padding-bottom", "80px");


        loadMap('map_from', 'ya-map-from', 1, function () {

            $('#search-place-from').val(str);
            $('#search-place-from').next('.search-result-block').html('').hide();

            var coordinates = [lat, lon];
            map_from.setCenter(coordinates, point_focusing_scale, {duration: 500});
        });
    }


    return false;
});




// +
// в выпадающей списке - выбор яндекс-точки посадки
$(document).on('click', '#search-from-block[city-extended-external-use="0"] .main-list li', function () {

    var yandex_point_from_id = $(this).val();
    showMapFromAndOpenTripTimes(yandex_point_from_id);
});


// +
// в выпадающей списке - выбор яндекс-точки высадки
$(document).on('click', '#search-to-block li', function() {

    var yandex_point_to_id = $(this).val();

    var placemark = selectPlacemark('map_to', yandex_point_to_id);
    var coordinates = placemark.geometry.getCoordinates();
    map_to.setCenter(coordinates, point_focusing_scale, {duration: 500});

    setTimeout(function () {
        placemark.balloon.open();
    }, 500);

    var yandex_point_to_name = placemark.properties.get('point_name');

    // через time_to_close_map секунд закрываем карту
    setTimeout(function() {

        setPointTo(yandex_point_to_id, yandex_point_to_name);
        closeFormTo();

    }, time_to_close_map);
});




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
                for (var field in errors) {
                    alert(errors[field]);
                }

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

// +
// нажатие "на карте" в точке посадки
$(document).on('click', "#city-from-block .reservation-step-line-showmap", function(event) {

    var $elem = $(this).closest(".reservation-step-line-content").find(".reservation-step-line-map");
    if($elem.hasClass('d-b')) { // закрытие карты
        $elem.removeClass('d-b');
    }else { // отображаем карту
        $elem.addClass('d-b');

        if($('#ya-map-from-static').html() == '') {

            loadMap('map_from_static', 'ya-map-from-static',1, function () {

                var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
                var placemark = selectPlacemark('map_from_static', yandex_point_from_id);
                var coordinates = placemark.geometry.getCoordinates();
                map_from_static.setCenter(coordinates, point_focusing_scale, {duration: 500});
            });

        }else {

            var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
            var placemark = selectPlacemark('map_from_static', yandex_point_from_id);
            var coordinates = placemark.geometry.getCoordinates();
            map_from_static.setCenter(coordinates, point_focusing_scale, {duration: 500});
        }
    }
});


// ---------- функционал для формы-2 ------------- - присутствует неработающий устаревший код связанный с картами


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
    var last_name = $.trim($('input[name="ClientExt[last_name]"]').val());
    var first_name = $.trim($('input[name="ClientExt[first_name]"]').val());
    var email = $.trim($('input[name="ClientExt[email]"]').val());
    // var gender = $.trim($('input[name="ClientExt[gen]"]').val());
    var places_count = $('input[name="ClientExt[places_count]"]').val();

    // console.log('phone='+phone+' fio='+fio+' email='+email+' gender='+gender+' places_count='+places_count);

    if(phone.length >= 15 && last_name != "" && first_name != "" && email != "" && places_count > 0) {
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
        alert('Заполните телефон');
        return false;
    }

    var last_name = $.trim($('input[name="ClientExt[last_name]"]').val());
    if(last_name == "") {
        alert('Заполните фамилию');
        return false;
    }

    var first_name = $.trim($('input[name="ClientExt[first_name]"]').val());
    if(first_name == "") {
        alert('Заполните имя');
        return false;
    }

    var email = $.trim($('input[name="ClientExt[email]"]').val());
    if(email == "") {
        alert('Заполните электронную почту');
        return false;
    }

    // var gen = $.trim($('input[name="ClientExt[gen]"]').val());
    // if(gen != "female" && gen != "male") {
    //     alert('Выберите пол');
    //     return false;
    // }


    var ClientExt = {

        phone: phone,
        last_name: last_name,
        first_name: first_name,
        email: email,

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
                for (var field in errors) {
                    alert(errors[field]);
                }

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

// +
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

            var placemark = selectPlacemark('map_from', yandex_point_from_id);
            var coordinates = placemark.geometry.getCoordinates();
            map_from.setCenter(coordinates, point_focusing_scale, {duration: 500});

        });
    });
});




// +
$(document).on('click', "#city-to-block .reservation-step-line-showmap", function(event) {

    var $elem = $(this).closest(".reservation-step-line-content").find(".reservation-step-line-map");
    if($elem.hasClass('d-b')) { // закрытие карты
        $elem.removeClass('d-b');
    }else { // отображаем карту
        $elem.addClass('d-b');

        if($('#ya-map-to-static').html() == '') {

            loadMap('map_to_static', 'ya-map-to-static',0, function () {

                var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
                var placemark = selectPlacemark('map_to_static', yandex_point_to_id);
                var coordinates = placemark.geometry.getCoordinates();
                map_to_static.setCenter(coordinates, point_focusing_scale, {duration: 500});
            });

        }else {

            var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
            var placemark = selectPlacemark('map_to_static', yandex_point_to_id);
            var coordinates = placemark.geometry.getCoordinates();
            map_to_static.setCenter(coordinates, point_focusing_scale, {duration: 500});
        }
    }
});


// нажатие на уже выбранный адрес точки куда - открывает заново карту
$(document).on('click', "#city-to-block .reservation-step-line-change2", function() {


    closeMap('map_from_static');

    var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
    openSelectPointToModal(function() {

        var placemark = selectPlacemark('map_to', yandex_point_to_id);

        var coordinates = placemark.geometry.getCoordinates();
        map_to.setCenter(coordinates, point_focusing_scale, {duration: 500});

        var yandex_point_to_name = placemark.properties.get('point_name');
        selectWidgetInsertValue($('input[name="search_yandex_point_to_id"]').parents('.sw-element'), yandex_point_to_id, yandex_point_to_name);
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