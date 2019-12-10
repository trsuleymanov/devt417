

function updatePrice(places_count) {

    /*
    var client_ext_id = $('#order-client-form').attr('client-ext-id');
    var trip_id = $('input[name="ClientExt[trip_id]"]').val();

    var yandex_point_from_id = $('*[name="ClientExt[yandex_point_from_id]"]').val();

    $.ajax({
        url: '/client-ext/ajax-get-price?client_ext_id='+client_ext_id+'&trip_id='+trip_id+'&places_count='+places_count+'&yandex_point_from_id='+yandex_point_from_id,
        type: 'post',
        data: {},
        beforeSend: function () {},
        success: function (response) {
            $('#client-ext-unprepayment-price').html(response.unprepayment_price + ' &#8399;');
            $('#client-ext-prepayment-price').html(response.prepayment_price + ' &#8399;');
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
    });*/
}


$(document).on('click', '#plus-places-count', function () {
    var count = parseInt($('#places-count').text()) + 1;
    $('input[name="ClientExt[places_count]"]').val(count);
    $('#places-count').text(count);

    updatePrice(count);
});

$(document).on('click', '#minus-places-count', function () {
    var count = parseInt($('#places-count').text());

    if(count > 1) {
        count = count - 1;
        $('input[name="ClientExt[places_count]"]').val(count);
        $('#places-count').text(count);

        updatePrice(count);
    }
});


$(document).on('click', '.selecting-trip', function() {

    var trip_id = $(this).attr('trip-id');
    $('input[name="ClientExt[trip_id]"]').val(trip_id);

    var trip_time = $(this).find('.trip-time').text();
    var trip_data = $(this).find('.trip-data').text();
    $('#map-text').html('Время для посадки - ' + trip_data + " " + trip_time);

    var travel_time_h = $(this).attr('travel_time_h');
    var travel_time_m = $(this).attr('travel_time_m');

    $('#travel-h').text(travel_time_h);
    $('#travel-m').text(travel_time_m);
    $('#travel-text').show();


    $('#search-place-from').hide();
    $('#trip-time-confirm-1').html("").attr('trip-id', "");
    $('#trip-time-confirm-2').html("").attr('trip-id', "");
    $('#trip-time-confirm-3').html("").attr('trip-id', "");
    $('#select-trip-list').hide();
    $('#YMapsID').hide();

    // устанавливаем расчетное время в пути
    // t = trip_time -
});


$(document).on('click', '#plus-bag-count', function () {

    var count = parseInt($('#bag-count').text()) + 1;
    $('input[name="ClientExt[bag_count]"]').val(count);
    $('#bag-count').text(count);
});

$(document).on('click', '#minus-bag-count', function () {

    var count = parseInt($('#bag-count').text());
    if(count > 0) {
        count = count - 1;
        $('input[name="ClientExt[bag_count]"]').val(count);
        $('#bag-count').text(count);
    }
});

$(document).on('click', '#plus-suitcase-count', function () {

    var count = parseInt($('#suitcase-count').text()) + 1;
    $('input[name="ClientExt[suitcase_count]"]').val(count);
    $('#suitcase-count').text(count);
});

$(document).on('click', '#minus-suitcase-count', function () {

    var count = parseInt($('#suitcase-count').text());
    if(count > 0) {
        count = count - 1;
        $('input[name="ClientExt[suitcase_count]"]').val(count);
        $('#suitcase-count').text(count);
    }
});


$(document).on('submit', '#order-client-form', function() {

    var yandex_point_from_id = $('input[name="ClientExt[yandex_point_from_id]"]').val();
    if(yandex_point_from_id == "") {
        alert('Выберите место посадки');
        return false;
    }

    var travel_h = $('#travel-h').text();
    if(travel_h == "") {
        alert('Выберите время посадки');
        return false;
    }

    var yandex_point_to_id = $('input[name="ClientExt[yandex_point_to_id]"]').val();
    if(yandex_point_to_id == "") {
        alert('Выберите пункт назначения');
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

    return true;
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
});




// в яндекс-карте щелчек на строке в выпадающем списке результатов поиска
$(document).on('click', '.search-result-block li', function() {

    if(map == null) {
        return false;
    }

    $('#YMapsID').show();

    var str = $(this).text();

    // console.log('str=' + str);
    var myGeocoder = ymaps.geocode(str);
    // console.log('myGeocoder:'); console.log(myGeocoder);

    myGeocoder.then(
        function (res) {

            var coordinates = res.geoObjects.get(0).geometry.getCoordinates();
            str = str.replace(', Республика Татарстан', '');
            $('#search-place-from').val(str);


            /*
            // создание точки - соответствующей выбранной в результатах поиска строке
            var index = map.geoObjects.getLength();
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
            // console.log('placemark:'); console.log(placemark);


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
            */

            // placemark.balloon.open();
            $('#default-modal .search-point').next('.search-result-block').html('').hide();
            $('.search-result-block').html('');

            $('#travel-h').text("");
            $('#travel-m').text("");
            $('#travel-text').hide();

            $('#trip-time-confirm-1').html("").attr('trip-id', "");
            $('#trip-time-confirm-2').html("").attr('trip-id', "");
            $('#trip-time-confirm-3').html("").attr('trip-id', "");
            $('#select-trip-list').hide();
            $('#map-text').html("<br />Выберите точку посадки откуда вас забрать:");

            // var coordinates = placemark.geometry.getCoordinates();
            map.setCenter(coordinates, 15, {duration: 500});

        },
        function (err) {
            alert('Ошибка');
        }
    );

    return false;
});


// Создает обработчик события window.onLoad
//YMaps.jQuery(function () {
$(document).ready(function () {

    ymaps.ready(function() {

        var city_id = $('#city-from').attr('city-id');
        if(city_id == 1 || city_id == 2) {
            $.ajax({
                url: '/city/ajax-get-city-yandex-points-data?city_id=' + city_id,
                type: 'post',
                data: {},
                success: function (response) {

                    if (response.city == null) {
                        alert('Город не определен');
                        return false;
                    }


                    ymaps.ready(function () {

                        map = new ymaps.Map("YMapsID", {
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


                        // Множество существующих точек
                        for (var key in response.yandex_points) {

                            var yandex_point = response.yandex_points[key];
                            var index = map.geoObjects.getLength();

                            var create_placemark_params = {
                                index: index,
                                point_text: yandex_point.name,
                                point_id: yandex_point.id,
                                point_lat: yandex_point.lat,
                                point_long: yandex_point.long,
                                is_editing: false,
                                create_new_point: false,
                                //to_select: false,
                                to_select: true,
                                can_change_params: true,
                                point_of_arrival: yandex_point.point_of_arrival,
                                super_tariff_used: yandex_point.super_tariff_used,
                                critical_point: yandex_point.critical_point,
                                alias: yandex_point.alias
                            };
                            var placemark = createPlacemark(create_placemark_params);
                        }
                    });
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



        /*
        if(city_id == 1) { // Казань

            var city_long = 49.11;
            var city_lat = 55.79;
            var city_name = "Казань";

            map = new ymaps.Map("YMapsID", {
                center: [// центр между Казанью и Альметьевском [55.49122774712018,50.517468278447666]
                    // 55.4912,
                    // 50.5174
                    city_lat,
                    city_long
                ],
                zoom: 12
            });

        }else if(city_id == 2) {

            var city_long = 52.3;
            var city_lat = 54.9;
            var city_name = "Альметьевск";

            map = new ymaps.Map("YMapsID", {
                center: [// центр между Казанью и Альметьевском [55.49122774712018,50.517468278447666]
                    // 55.4912,
                    // 50.5174
                    city_lat,
                    city_long
                ],
                zoom: 12
            });
        }*/

    });
});




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
            '&v=9' +
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
                //console.log('results:'); console.log(response.results);

                if(response.results.length > 0) {

                    html = '<ul class="main-list">';
                    var lis = [];
                    var first_lis = []; // для мини-сортировки - строки в которых используется название города попадают в первый список
                    for(var i = 0; i < response.results.length; i++) {

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

    }
});



$(document).on('keyup', '#fio', function(e) {

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

$(document).on('blur', '#fio', function(e) {

    var has_error = false;

    var fio = $(this).val();
    fio = fio.replace(/^\s+/g, '');
    if(fio.length == 0) {
        alert('Заполните Имя Фамилию');
        has_error = true;
    }else {
        var arr = fio.split(" ");
        if(arr.length < 2) {
            alert('Заполните имя и фамилию');
            has_error = true;
        }
    }

    return false;
});



function selectPointPlacemark(params) {

    // console.log('main_page.js selectPointPlacemark');

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
        // map.setCenter(coordinates, params['point_focusing_scale'], {
        //     duration: 500
        // });

        map.setCenter(coordinates, 15, {
            duration: 500
        });
    }

    return point_placemark;

}