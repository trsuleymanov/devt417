

$(document).ready(function()
{
    // Панель управления
    $('.main-header').on('click', '.sidebar-toggle', function(){
        var $status;
        if($('body').hasClass('sidebar-collapse')){
            $status = 0;
        }else{
            $status = 1;
        }
        $.ajax({
            url: '/admin/setting/main-menu-status',
            type: 'POST',
            data: {
                'status': $status
            },
            error: function(){
                console.log('Внутренняя ошибка сервера');
            }
        });
    });
});