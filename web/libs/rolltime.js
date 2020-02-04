(function($) {
  "use strict";

  $.fn.Rolltime = function(options) {

    var trigger = $(this), hours, minutes, hourScroll, minScroll, activeHour, activeMin;

    var settings = $.extend({
      lang: {
        title: 'Время посадки',
        confirm: 'Ок',
        hour: ' ч',
        min: ' мин',
      },
      step: 1,
      value: ''
    }, options);

    var parseTime = function(value){

      var tmp = value.split(':');
      hours = prepareTime(tmp[0]);
      minutes = Math.ceil( tmp[1] / settings.step ) * settings.step;

    }

    var prepareTime = function(value){

      if(value < 10) value = '0'+ value;
      return value;

    }

    return this.each(function(){

      if( settings.value == '' ){

        var now = new Date();
        hours = now.getHours();
        minutes = Math.ceil( now.getMinutes() / settings.step ) * settings.step;

      } else {

        parseTime(settings.value);

      }

      trigger.on('click', function(){

        var html = '<div class = "rolltime-container"><div class="rolltime-mask"></div><div class="rolltime-panel"><header>' + settings.lang.title + '<span class="rolltime-confirm">' + settings.lang.confirm + '</span></header><section class="rolldate-content"><div class="rolltime-dim mask-top"></div><div class="rolltime-dim mask-bottom"></div><div class = "rolltime-wrapper"><div id = "rolldate-hour"><ul class="wheel-scroll">';

          for (var h = 0; h <= 23; h++) {

            var value = prepareTime(h);
            if(hours == h){
              activeHour = h;
            }

            html += '<li class="wheel-item" data-index="' + h + '">' + value + settings.lang.hour + '</li>';

          }

        html += '</ul></div><div id = "rolldate-min"><ul class="wheel-scroll">';

          for (var m = 0; m <= 59; m += settings.step) {

            var counter = m / settings.step;
            var value = prepareTime(m);

            if(minutes == m){
              activeMin = counter;
            }

            html += '<li class="wheel-item" data-index="' + counter + '">' + value + settings.lang.min + '</li>';

          }

        html += '</ul></div></div></section></div></div>';
        $('body').append(html);

        hourScroll = new BScroll('#rolldate-hour', {
            wheel: {
                selectedIndex: activeHour
            }
        });

        minScroll = new BScroll('#rolldate-min', {
            wheel: {
                selectedIndex: activeMin
            }
        });

      });

      trigger.on('change', function(){

        parseTime( trigger.val() );

      });

      $(document).on('click', '.rolltime-confirm', function(){

        hours = $('#rolldate-hour li[data-index="'+ hourScroll.getSelectedIndex() +'"]').text().replace(/\D/g, '');
        minutes = $('#rolldate-min li[data-index="'+ minScroll.getSelectedIndex() +'"]').text().replace(/\D/g, '');
        trigger.val(hours +':'+ minutes);
        $('.rolltime-mask').trigger('click');

      });

      $(document).on('click', '.rolltime-mask', function(){

        $('.rolltime-container').remove();

      });

    });

  }

})(jQuery);