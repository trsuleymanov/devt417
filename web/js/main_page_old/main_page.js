/*
 * @author Timur Valiyev
 * @link https://webprowww.github.io
 */

"use strict";function _defineProperties(t,e){for(var a=0;a<e.length;a++){var i=e[a];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}function _createClass(t,e,a){return e&&_defineProperties(t.prototype,e),a&&_defineProperties(t,a),t}function _classCallCheck(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(function(){var a,t,e;$("*[data-mask]").each(function(){var t,e;return t=$(this),e=String(t.attr("data-mask")),t.inputmask({mask:e})}),e={format:"DD.MM.YYYY",separator:" - ",applyLabel:'<i class="icon-check"></i>',cancelLabel:'<i class="icon-times"></i>',daysOfWeek:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],monthNames:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],firstDay:1},$(".js-dpicker").each(function(){var t;return(t=$(this)).daterangepicker({autoUpdateInput:!1,singleDatePicker:!0,timePicker:!0,timePicker24Hour:!0,locale:e}),t.on("apply.daterangepicker",function(t,e){return $(this).val(e.startDate.format("DD.MM.YYYY - hh:mm")),!0}),t.on("cancel.daterangepicker",function(){return $(this).val(""),!0}),!0}),$(".js-form").on("submit",function(t){return t.preventDefault(),!1}),$(".js-scroll").on("click",function(t){var e,a,i;return t.preventDefault(),a=$(this).attr("href"),i=(e=$(a)).length?e.offset().top:0,$("html:not(:animated),body:not(:animated)").animate({scrollTop:i},800),!1}),t=function(){function i(t){var e,a;_classCallCheck(this,i),this.ready=this.ready.bind(this),this.stateChange=this.stateChange.bind(this),this.playVideo=this.playVideo.bind(this),this.stopVideo=this.stopVideo.bind(this),this.frame=t,e=$(this.frame),this.$parent=e.closest(".js-video"),this.$btn=this.$parent.find(".js-video-btn"),this.$overlay=this.$parent.find(".js-video-overlay"),a=e.attr("data-video"),this.ytPlayer=new YT.Player(this.frame,{height:"100%",width:"100%",videoId:a,playerVars:{controls:0,showinfo:0,modestbranding:1,wmode:"transparent",origin:window.location.hostname},events:{onReady:this.ready,onStateChange:this.stateChange}})}return _createClass(i,[{key:"ready",value:function(){return this.$overlay.on("click",this.stopVideo),this.$btn.on("click",this.playVideo)}},{key:"stateChange",value:function(t){if(0===t.data)return this.$parent.removeClass("playing")}},{key:"playVideo",value:function(t){return t.preventDefault(),t.stopPropagation(),this.$parent.addClass("playing"),this.ytPlayer.playVideo(),!1}},{key:"stopVideo",value:function(){return this.ytPlayer.pauseVideo(),this.$parent.removeClass("playing")}}]),i}(),window.onYouTubeIframeAPIReady=function(){return $("*[data-video]").each(function(){return new t(this)})},a=function(){function n(t,e){var a,i;_classCallCheck(this,n),this.imgOnLoad=this.imgOnLoad.bind(this),this.$el=t,this.imgUrl=e,i=new Image,(a=$(i)).one("load",this.imgOnLoad),a.attr("src",this.imgUrl)}return _createClass(n,[{key:"imgOnLoad",value:function(){return this.$el.addClass("loaded"),this.$el.css({"background-image":"url(".concat(this.imgUrl,")")})}}]),n}(),$("*[data-img]").each(function(){var t,e;return e=(t=$(this)).attr("data-img"),new a(t,e)}),$(".js-nav-toggle").on("click",function(t){var e,a;return t.preventDefault(),a=$(this),(e=$("".concat(a.attr("href")))).length&&(e.stop(),e.slideToggle()),!1})}).call(void 0);

$(document).on('change', '*[name="ClientExt[city_from_id]"]', function() {

    var city_from = $(this).val();
    if(city_from == 1) {
        $('*[name="ClientExt[city_to_id]"]').val(2);
        return false;
    }

    if(city_from == 2) {
        $('*[name="ClientExt[city_to_id]"]').val(1);
        return false;
    }
});

$(document).on('change', '*[name="ClientExt[city_to_id]"]', function() {

    var city_to = $(this).val();
    if(city_to == 1) {
        $('*[name="ClientExt[city_from_id]"]').val(2);
        return false;
    }

    if(city_to == 2) {
        $('*[name="ClientExt[city_from_id]"]').val(1);
        return false;
    }
});

// $(document).on('blur', '#clientext-username', function(e) {
//
//     // var username = $.trim($(this).val());
//     // var arr = username.split(" ");
//     // for(var i = 0; i < arr.length; i++) {
//     //     if(arr[i].length < 3) {
//     //         console.log('создаем ошибку');
//     //         var field_errors = []
//     //         field_errors[0] = "test";
//     //         $('#order-client-form').yiiActiveForm('updateAttribute', 'username', field_errors);
//     //         break;
//     //     }
//     // }
//
//     //$('#order-client-form').yiiActiveForm('updateAttribute', 'username', field_errors);
//
//     console.log('создаем ошибку');
//     $('#order-client-form').yiiActiveForm('updateAttribute', 'clientext-username', ["I have an error..."]);
// });





