

$(document).on('click', '.etw-element', function()
{
    if($(this).attr('disabled') != 'disabled') {

        var id = $(this).attr('id');
        $(this).hide();
        $('.etf-block[for="' + id + '"]').show();

        if(typeof etw_setting !== "undefined" && etw_setting[id] != undefined) {
            if (etw_setting[id].mask != undefined) {
                $('.etf-block[for="' + id + '"]').find('.etf-input input').mask(etw_setting[id].mask);
            }
        }

        $('.etf-block[for="' + id + '"]').find('.etf-input input').focus();
    }

    return false;
});

$(document).on('keyup', '.etf-change[for="phone"]', function (e) {

    if(e.keyCode == 13) {

        var $obj = $(this);
        var user_id = $(this).attr('user-id');
        var value = $(this).val();

        $.ajax({
           url: "/account/personal/editable-user?id=" + user_id,
           type: "post",
           data: {
               hasEditable: 1,
               phone: value
           },
           success: function (data) {
               if(data.message != "") {
                   alert(data.message);
               }else {
                   $obj.hide();
                   $('#phone').text(value).show();
               }
           },
           error: function (data, textStatus, jqXHR) {
               if (textStatus == "error") {
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

    }else if(e.keyCode == 27) {
        $(this).hide();
        $('#phone').show();
    }
});

$(document).on('click', '.etf-clear-x', function() {

    //console.log('.etf-clear-x click');
    $(this).prev('input').val('').focus();

    return false;
});

function etfCancel($etf_block) {

    var id = $etf_block.attr('for');
    $etf_block.hide();
    var $my_elem = $etf_block.parent().find('#' + id);
    $my_elem.show();
    var value = $my_elem.text();
    $etf_block.find('.etf-input input').val(value);
}

$(document).on('click', '.etf-but-cancel', function() {

    //console.log('.etf-but-cancel click');
    var $etf_block = $(this).parents('.etf-block');
    etfCancel($etf_block);

    return false;
});


$(document).on('click', '.etf-but-accept', function() {

    //console.log('.etf-but-accept click');

    var etf_block = $(this).parents('.etf-block');
    var input_elem = etf_block.find('.etf-input input');
    var new_value = input_elem.val();
    var name = input_elem.attr('name');
    var id = etf_block.attr('for');

    if(etw_setting[id].onChange != undefined) {
        etw_setting[id].onChange(id, etf_block, name, new_value);
    }else {
        etf_block.hide();
        $('#' + id).html(new_value).show();
    }
    return false;
});

//$(document).on('click', '.etf-block .etf-input input', function(e) {
//    console.log('.etf-block .etf-input input click');
//    //$(this).focus();
//});

$(document).on('focus', '.etf-block .etf-input input', function(e) {
    //console.log('.etf-block .etf-input input focus');

    return false;
});

$(document).on('blur', '.etf-block .etf-input input', function(e) {
    console.log('.etf-block .etf-input input blur');
});

$(document).on('keyup', '.etf-block .etf-input input', function(e) {

    //console.log('.etf-block .etf-input input keyup');

    if(e.keyCode == 13) {
        var etf_block = $(this).parents('.etf-block');
        var id = etf_block.attr('for');
        var new_value = $(this).val();
        var name = $(this).attr('name');

        if(etw_setting[id].onChange != undefined) {
            etw_setting[id].onChange(id, etf_block, name, new_value);
        }else {
            etf_block.hide();
            $('#' + id).html(new_value).show();
        }
        return false;
    }
});

$(document).on('keyup', '.etf-input', function(e) {

    if(e.keyCode == 13) {

        var etf_block = $(this).parents('.etf-block');
        var new_value = etf_block.find('.etf-input input').val();
        var id = etf_block.attr('for');
        etf_block.hide();
        $('#' + id).text(new_value).show();

        return false;

    }else if(e.keyCode == 27) {

        var etf_block = $(this).parents('.etf-block');
        etf_block.hide();
        var id = etf_block.attr('for');
        $('#' + id).show();
    }
});
