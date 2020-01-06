"use strict";

(function ($) {
  $(document).ready(function () {

    svg4everybody({});

    grecaptcha.ready(function() {
      grecaptcha.execute('6Lewg8wUAAAAABhM-tLlmiRNYSLdf17N87agjkmR', {action: 'homepage'}).then(function(token) {
        $('button:disabled').each(function(){
          $(this).attr('disabled', false);
        });
      });
    });


    if($('#inputphoneform-mobile_phone').hasClass('use_imask')) {
      var currencyMask = new IMask(
          document.getElementById('inputphoneform-mobile_phone'),
          {
            mask: /^[+]\d{0,13}$/,
            blocks: {
              num: {
                mask: Number,
                thousandsSeparator: ' '
              }
            }
          });
    }
  });
  $(document).on('click', '.services__read', function (event) {
    event.preventDefault();
    $(this).toggleClass('read_active').parents('.services').find('.list_hidden').slideToggle(300);
  });
  $(".nav a[href*='#']").mPageScroll2id({
    autoScrollSpeed: true,
    offset: 110,
    highlightClass: 'active_link',
    onStart: function onStart() {
      menu.iziModal('close');
    }
  });
  window.addEventListener('load', windowWidth, false);
  window.addEventListener('resize', windowWidth, false);
  window.addEventListener('orientationchange', windowWidth, false);

  function windowWidth() {
    window.addEventListener("scroll", windowScroll, false);
  }

  function windowScroll() {
    var wrapper = document.querySelector('.wrapper');

    if (this.scrollY > 5) {
      wrapper.classList.add('sticky');
    } else {
      wrapper.classList.remove('sticky');
    }
  }

  $('.iziModal').iziModal({
    width: 1200,
    group: true,
    loop: false,
    overlayColor: 'rgba(0,0,0,.9)'
  });

  var menu = $('.mobile_menu').iziModal({
    width: '100%',
    top: 0,
    loop: false,
    overlayColor: 'rgba(0,0,0,.9)',
    zindex: 9999
  }); // Modals init in Video Page

  $(document).on('click', '.video__link', function () {
    var way = $(this).attr('data-video');
    var title = $(this).attr('data-title');
    $("#modal-video").iziModal({
      headerColor: '#ffb100',
      title: title,
      iframe: true,
      iframeURL: way,
      fullscreen: true,
      closeOnEscape: true,
      closeButton: true,
      overlayColor: 'rgba(0,0,0,.9)',
      onClosed: function onClosed() {
        $('#modal-video').iziModal('destroy');
      }
    });
  });
  $('#picker-date').datepicker({
    autoClose: true,
    minDate: new Date(),
    onSelectDate: function() {
      var selected_date = $('#picker-date').val();
      //alert('date='+date);

      // получим сегодняшнюю дату
      var now = new Date();
      var today_day = now.getDate();
      if(today_day < 10) {
        today_day = '0' + today_day;
      }
      var today_month = now.getMonth() + 1;
      if(today_month < 10) {
        today_month = '0' + today_month;
      }
      var today_date = today_day + '.' + today_month + '.' + now.getFullYear();
      //alert('today_date='+today_date);

      // если выбран сегодняшний день, то установить автоматически время в поле "Время посадки"
      //   +1 час к текущему с округлением до 15 минут в нижнюю сторону; если любой другой - то 03:00
      if(selected_date == today_date) {

        var hours = now.getHours();
        var minutes = now.getMinutes();

        //alert('hours='+hours+' minutes='+minutes);

        if(hours < 23) {
          hours = hours + 1;
        }
        if(minutes < 15) {
          minutes = 0;
        }else if(minutes < 30) {
          minutes = 15;
        }else if(minutes < 45) {
          minutes = 30;
        } else {
          minutes = 45;
        }

        if(hours < 10) {
          hours = '0' + hours;
        }
        if(minutes < 10) {
          minutes = '0' + minutes;
        }

        var new_time = hours + ':' + minutes;
        $('#picker-time').val(new_time);

      }else {
        $('#picker-time').val('03:00');
      }

    },
  });

  // $(document).on('keyup', '#picker-date', function () {
  //   alert('keyup');
  // });
  // $(document).on('change', '#picker-date', function () {
  //   alert('ch');
  // });
  // $('#picker-date').change(function() {
  //   alert('ch');
  // });

  var datepicker_is_visible = false;
  // $(document).on('click', '#picker-time', function() {
  //   console.log('datepicker_is_visible=' + datepicker_is_visible);
  // });
  $('#picker-time').datepicker({
    timepicker: true,
    onlyTimepicker: true,
    minutesStep: 15
    // onShow: function() {
    //   //datepicker_is_visible = true;
    //   console.log('onShow');
    // },
    // onHide: function () {
    //   //datepicker_is_visible = false;
    // },
    // onSelect: function() {
    //   // console.log('onSelect');
    // }
  });
  $(document).on('click', '#btn-time', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('#picker-time').trigger('click');
  });


  var counter = 0;
  var peoples = $('#peoples input');

  $('.btn_next').on('click', function (e) {
    e.preventDefault();
    counter++;
    $(this).prev().val(parseInt($(this).prev().val()) + 1);
  });

  $('.btn_prev').on('click', function (e) {

    e.preventDefault();

    if ($(this).next().val() > 0) {
      counter--;
      $(this).next().val(parseInt($(this).next().val()) - 1);
    } else {
      return false;
    }
  });

  $('.num_package__btn').on('click', function () {
    if (counter < 2 || counter > 4) {
      peoples.val(counter + ' человек');
    } else {
      peoples.val(counter + ' человека');
    }
  });

  // пассажиры: взрослый, ребенок, студент +
  /*
  $(".index-page .reservation-popup__counter-plus").click(function (event) {

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

      if(calcCounter >=2 && calcCounter <= 4) {
        $('input[name="ClientExt[places_count]"]').val(calcCounter + ' человека');
      }else {
        $('input[name="ClientExt[places_count]"]').val(calcCounter + ' человек');
      }
    }
  });

  // пассажиры: взрослый, ребенок, студент -
  $(".index-page .reservation-popup__counter-minus").click(function (event) {

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

        if(calcCounter >=2 && calcCounter <= 4) {
          $('input[name="ClientExt[places_count]"]').val(calcCounter + ' человека');
        }else {
          $('input[name="ClientExt[places_count]"]').val(calcCounter + ' человек');
        }
      }
    }

  });
*/


  $('.children_append .btn_next').on('click', function () {
    renderChildren();
  });
  $('.children_append .btn_prev').on('click', function () {
    $(this).parents('.children_append').find('.children_wrap').last().remove();
  });
  $(document).on('click', '.children__title', function (event) {
    event.preventDefault();
    $(this).toggleClass('active_select');
    $(this).next().stop(true).slideToggle(200);
  });
  $(document).on('click', '.children__item', function (event) {
    event.preventDefault();
    $(this).parents('.children').find('.children__title span ').text($(this).text()).addClass('children_complete');
    $(this).parents('.children__list').slideUp(300);
    $(this).parents('.children').find('.active_select').removeClass('active_select');
  });
  var age;
  $(window).on('resize load orientationchange', function () {
    if ($(window).outerWidth() > 992) {
      age = 'Выберите возраст ребенка';
    } else {
      age = 'Возраст ребенка';
      $(document).on('click', '.city_select', function () {
        window.scrollTo({
          top: 110,
          behavior: "smooth"
        });
      });
    }
  });

  function renderChildren() {
    $('.children_append').append("<div class=\"children_wrap\">\n      <div class=\"children\">\n        <div class=\"children__placeholder\">\n          <button class=\"children__title text_14\" type=\"button\" name=\"age\" value=\"\"><span>".concat(age, "</span>\n            <svg class=\"icon icon-right-arrow children__icon\">\n              <use xlink:href=\"/images_new/svg-sprites/symbol/sprite.svg#right-arrow\"></use>\n            </svg>\n          </button>\n          <div class=\"children__list\">\n            <button class=\"children__item text_16\" type=\"button\" name=\"select\">\u041C\u0435\u043D\u044C\u0448\u0435 \u0433\u043E\u0434\u0430</button><br>\n            <button class=\"children__item text_16\" type=\"button\" name=\"select\">\u041E\u0442 1 \u0434\u043E 2 \u043B\u0435\u0442</button><br>\n            <button class=\"children__item text_16\" type=\"button\" name=\"select\">\u041E\u0442 3 \u0434\u043E 6 \u043B\u0435\u0442</button><br>\n            <button class=\"children__item text_16\" type=\"button\" name=\"select\">\u041E\u0442 7 \u0434\u043E 10 \u043B\u0435\u0442</button>\n          </div>\n        </div>\n        <div class=\"children__checkbox\">\n          <button class=\"children__btn\" type=\"button\" name=\"self_baby_chair\"></button>\n          <input type=\"checkbox\" name=\"self_baby_chair\" hidden><span class=\"text_14\">\n            \u0421\u0432\u043E\u0435 \u0434\u0435\u0442\u0441\u043A\u043E\u0435\n            \u043A\u0440\u0435\u0441\u043B\u043E</span>\n        </div>\n      </div>\n    </div>"));
  }

  $(document).on('click', '.children__btn', function (event) {
    event.preventDefault();
    $(this).toggleClass('check_active');
    if($(this).hasClass('check_active')) {
      $('input[name="User[rememberMe]"]').val(1);
    }else {
      $('input[name="User[rememberMe]"]').val(0);
    }
  });

  $(document).on('click', '*', function (event) {

    event.stopPropagation();

    if( $('.header__login').hasClass('click_fix') && !$(this).closest('.for_enter_wrap').length ){

      $('.header__login').removeClass('click_fix');
      $('.for_enter_wrap').hide();

    }

    if( $('#peoples').hasClass('slide_down') && !$(this).closest('.welcome__label__peoples').length ) {

      $('#peoples').removeClass('slide_down');
      $('.select').slideUp(100);
      // $(".reservation-popup-calc").removeClass("d-b");

    }

    if ($('.city_select').hasClass('fix_down') && !$(this).closest('.city_select').length ) {

      $('.select_city_wrap').slideUp(100).removeClass('fix_down');
    }

  });

  $(document).on('click', '.city_select', function (event) {
    event.preventDefault();
    event.stopPropagation();

    $('.header__login').removeClass('click_fix');
    $('.for_enter_wrap').slideUp(100);
    $('.select_city_wrap').hide();
    $('.welcome__form').find('.fix_down').removeClass('fix_down');
    $(this).toggleClass('fix_down');

    if ($(this).hasClass('fix_down')) {
      $('#peoples').removeClass('slide_down').next('.select').slideUp(1);
      //$('#peoples').removeClass('slide_down');
      //$(".reservation-popup-calc").removeClass("d-b");

      $(this).find('.select_city_wrap').slideDown(100);
    } else {
      $('.select_city').removeClass('fix_down');
    }
  });

  $(document).on('click', '.reservation-popup-calc', function() {
    return false;
  });

  $(document).on('click', '#peoples', function (event) {

    event.preventDefault();
    event.stopPropagation();

    $(this).toggleClass('slide_down');
    $('.city_select').removeClass('rotate_ping').find('.select_city_wrap').slideUp(1); // // это разве нужно?
    $('.for_enter_wrap').slideUp(100);   // это разве нужно?
    $('.header__login').removeClass('click_fix'); // это разве нужно?

    // открытие выпадающего меню вниз
    $('.select').slideToggle(100);

    // открытие выпадающего меню вверх
    //$(".reservation-popup-calc").addClass("d-b");

  });
  $(document).on('click', '.select', function (event) {
    event.preventDefault();
    event.stopPropagation();
  });

  $('.date_enter').on('click', function () {
    $('#peoples').removeClass('slide_down');
    $('.select').slideUp(100);
    // $(".reservation-popup-calc").removeClass("d-b");

    $('.city_select').removeClass('rotate_ping').find('.select_city_wrap').slideUp(1);
    $('.for_enter_wrap').slideUp(100);
  });


  $(document).on('click', '.guest .header__login', function (event) {
    event.preventDefault();
    event.stopPropagation();

    var to_show = false;
    if($('#modal_enter_phone').is(':visible') === true) {
      to_show = false;
    }else {
      to_show = true;
    }

    clearAndHideRegForms();

    if(to_show == true) {
      $(this).addClass('click_fix');
      $('#modal_enter_phone').fadeIn(100);
    }else {
      $(this).removeClass('click_fix');
      $('#modal_enter_phone').fadeOut(100);
    }

    // $(this).toggleClass('click_fix');
    // $('#modal_enter_phone').fadeToggle(100);

    $('#peoples').removeClass('slide_down').next('.select').slideUp(100);

    // $('#peoples').removeClass('slide_down');
    // $(".reservation-popup-calc").removeClass("d-b");

    $('.city_select').removeClass('rotate_ping').find('.select_city_wrap').slideUp(100);
  });

  $(document).on('click', '.user .header__login', function (event) {
    event.preventDefault();
    event.stopPropagation();

    var to_show = false;
    if($('.for_enter_wrap').is(':visible') === true) {
      to_show = false;
    }else {
      to_show = true;
    }

    if(to_show == true) {
      $(this).addClass('click_fix');
      $('.for_enter_wrap').fadeIn(100);
    }else {
      $(this).removeClass('click_fix');
      $('.for_enter_wrap').fadeOut(100);
    }

  });
  // $(document).on('click', 'header .test', function (event) {
  //   event.preventDefault();
  //   $('.modal_enter').hide();
  //   $('.modal_registration').fadeIn(100);
  // });
  // $(document).on('click', 'header .test-next', function (event) {
  //   event.preventDefault();
  //   $('.modal_registration').fadeOut(100);
  // });
})(jQuery);



$(document).on('click', '.select_city__item', function (event) {
  event.preventDefault();
  event.stopPropagation();
  //$(this).parents('.welcome__col').find('.welcome__input').val($(this).attr('data-city'));

  if($(this).parents('.select_city_wrap').hasClass('city_out')) {
    var city = 'out';
  }else {
    var city = 'in';
  }

  var city_from_id = $(this).attr('data-val');
  if((city_from_id == 1 && city == 'out') || (city_from_id == 2 && city == 'in')) {
    $('*[name="ClientExt[city_from_id]"]').val(1);
    $('#city-from-text').val('Казань');
    $('*[name="ClientExt[city_to_id]"]').val(2);
    $('#city-to-text').val('Альметьевск');
  }else if((city_from_id == 2 && city == 'out') || (city_from_id == 1 && city == 'in')) {
    $('*[name="ClientExt[city_from_id]"]').val(2);
    $('#city-from-text').val('Альметьевск');
    $('*[name="ClientExt[city_to_id]"]').val(1);
    $('#city-to-text').val('Казань');
  }

  $(this).parents('.welcome__col').find('.select_city_wrap').slideUp(100);

  clearFormError();
});

$(document).on('click', '.btn_reverse', function() {

  console.log('btn_reverse');
  var city_from_id = $('*[name="ClientExt[city_from_id]"]').val();
  if(city_from_id == 1) {
    $('*[name="ClientExt[city_from_id]"]').val(2);
    $('#city-from-text').val('Альметьевск');
    $('*[name="ClientExt[city_to_id]"]').val(1);
    $('#city-to-text').val('Казань');
  }else if(city_from_id == 2) {
    $('*[name="ClientExt[city_from_id]"]').val(1);
    $('#city-from-text').val('Казань');
    $('*[name="ClientExt[city_to_id]"]').val(2);
    $('#city-to-text').val('Альметьевск');
  }

  clearFormError();
  return false;
});


function clearFormError() {
  // $('#city_from_id_error').text('');
  // $('#city_to_id_error').text('');
  // $('#data_error').text('');
  // $('#time_error').text('');
  // $('#places_count_error').text('');

  if($('#new-order .error').is(':visible')) {
    $('#new-order .error').text('').hide();
  }
}


$(document).on('click', 'body', function() {
  clearFormError();
});


$(document).on('click', '#submit-order-form', function() {

  var ClientExt = {
    city_from_id: $('input[name="ClientExt[city_from_id]"]').val(),
    city_to_id: $('input[name="ClientExt[city_to_id]"]').val(),
    data: $('input[name="ClientExt[data]"]').val(),
    time: $('input[name="ClientExt[time]"]').val(),
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

    // ClientExtChilds.add({
    //   age: age,
    //   self_baby_chair: self_baby_chair
    // });
  });

  var post = {
    ClientExt: ClientExt,
    ClientExtChild: ClientExtChilds
  };
  // console.log('post:'); console.log(post);

  $.ajax({
    url: '/site/index',
    type: 'post',
    data: {
      ClientExt: ClientExt,
      ClientExtChild: ClientExtChilds
    },
    success: function (response) {

      if (response.success === true) {

        location.href = response.redirect_url;

      }else {

          // var errors = response.errors;
          // if(errors.city_from_id !== void 0) {
          //   $('#city_from_id_error').text(errors.city_from_id.join('. '));
          // }
          // if(errors.city_to_id !== void 0) {
          //   $('#city_to_id_error').text(errors.city_to_id.join('. '));
          // }
          // if(errors.data !== void 0) {
          //   $('#data_error').text(errors.data.join('. '));
          // }
          // if(errors.time !== void 0) {
          //   $('#time_error').text(errors.time.join('. '));
          // }
          // if(errors.places_count !== void 0) {
          //   $('#places_count_error').text(errors.places_count.join('. '));
          // }

        var errors = [];
        for(var field in response.errors) {
          var field_errors = response.errors[field];
          for(var key in field_errors) {
            errors[errors.length] = field_errors[key];
          }
        }

        var str_errors = errors.join(' ');
        $('#new-order .error').text(str_errors).show();
        setTimeout(function(){
          $('#new-order .error').text('').hide();
        }, 3000);

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


$(document).on('click', '.modal_global__logout', function() {
  //alert('Выход');

  $.ajax({
    url: '/site/ajax-logout',
    type: 'post',
    data: {},
    success: function (response) {
      location.reload();
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


// $(document).on('change', 'input[name="ClientExt[data]"]', function() {
//
//   //alert($(this).val());
//   alert('val=');
// });






// ----------------- Страница /site/create-order?c=... --------------------

/*
function updatePrice(places_count) {

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
  });
}
*/

/*
$(document).on('click', '#plus-places-count', function () {
  var count = parseInt($('#places-count').text()) + 1;
  $('input[name="ClientExt[places_count]"]').val(count);
  $('#places-count').text(count);

  updatePrice(count);
});
 */

/*
$(document).on('click', '#minus-places-count', function () {
  var count = parseInt($('#places-count').text());

  if(count > 1) {
    count = count - 1;
    $('input[name="ClientExt[places_count]"]').val(count);
    $('#places-count').text(count);

    updatePrice(count);
  }
});
*/

/*
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
*/

/*
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
*/


/*
$(document).on('submit', '#order-client-form', function() {
*/

/*
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
*/

/*
$(document).on('blur', 'input[name="ClientExt[phone]"]', function() {
*/


/*
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
*/

/*
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


  });
});
*/


/*
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
*/

/*
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

*/
/*
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

}*/