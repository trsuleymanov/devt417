<?
    $this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);
?>

<div class="container">
    <h3 class="finishOrder__title title_30">Заказ оформлен</h3>
    <?php if($model->but_checkout == 'payment') { ?>
        <?php if($model->is_paid == true) { ?>
            Ваш заказ на сумму <?= $model->price ?> успешно оплачен!<br /><br />
        <?php }else { ?>
            Ваш заказ не был оплачен!<br /><br />
        <?php } ?>
    <?php }else { ?>
        Вы забронировали заказ. Оплатить вы можете во время поездки или на сайте в <a href="/account/personal">личном кабинете</a>.<br /><br />
    <?php } ?>
</div>