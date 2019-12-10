<?php
use app\models\ClientExt;
use yii\widgets\ActiveForm;

// $this->registerJsFile('js/main_page/check-order.js', ['depends'=>'app\assets\AppAsset']);

//$time_confirm = ClientExt::getYandexPointTimeConfirm($model->trip, $model->yandexPointFrom);

$aTripEndTime = explode(':', $model->trip->end_time);
$trip_end_time = 3600*intval($aTripEndTime[0]) + 60*intval($aTripEndTime[1]);
$travel_time = 2*$model->trip->date + $trip_end_time - $model->time_confirm + 10800;

?>
<?php
//$form = ActiveForm::begin([
//    'id' => 'order-client-form',
//    'options' => [
//        'client-ext-id' => $model->id,
//    ],
//    'enableClientScript' => false
//]);

//echo "m_time_confirm=".$model->time_confirm."<br />";
//echo " _time_confirm=".$time_confirm."<br />";
?>
<input name="random_field" type="hidden" value="1" />

<table style="width: 800px;">
    <tr><td>Рейс</td><td><?= ($model->direction_id == 1 ? 'Альметьевск-Казань' : 'Казань-Альметьевск') ?></td></tr>
    <tr><td>Отправление т/с</td><td><?= date('d.m.Y', $model->data) ?> в <?= $model->time ?> </td></tr>
    <tr><td>Из точки</td><td><?= $model->yandex_point_from_name ?></td></tr>
    <tr><td>В точку</td><td><?= $model->yandex_point_to_name ?></td></tr>
    <tr><td>Ваша посадка</td><td><?= date("d.m.Y H:i", $model->time_confirm) ?></td></tr>
    <tr><td>Расчетное время в пути</td><td><?= intval(date("H", $travel_time)) ?> ч <?= intval(date("i", $travel_time)) ?> мин</td></tr>

    <tr><td>Мест</td><td><?= $model->places_count ?> шт.</td></tr>
    <?php if($model->suitcase_count > 0) { ?>
        <tr><td>Больших чемоданов</td><td><?= $model->suitcase_count ?> шт.</td></tr>
    <?php } ?>
    <?php if($model->bag_count > 0) { ?>
        <tr><td>Ручной клади</td><td><?= $model->bag_count ?> шт.</td></tr>
    <?php } ?>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td>Контактная информация</td><td></td></tr>
    <tr><td>Имя</td><td><?= $model->fio ?></td></tr>
    <tr><td>Эл.почта</td><td><?= $model->email ?></td></tr>
    <tr><td>Телефон</td><td><?= $model->phone ?></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <?php /*
    <tr><td>Пассажиры</td><td></td></tr>
    <?php foreach($passengers as $passenger) { ?>
        <tr><td><?= $passenger->fio ?></td><td><?= Passenger::getDocumentTypes()[$passenger->document_type] ?>: <?= !empty($passenger->citizenship) ? $passenger->citizenship.' ' : '' ?><?= $passenger->series_number ?></td></tr>
    <?php }*/ ?>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr>
        <?php /*
        <td>К оплате</td>
        <td><?= $model->price ?> &#8399;</td>
        */ ?>
        <td>
            <button id="make-simple-payment-checkorderpage" client-ext-id="<?= $model->id ?>" class="payment-button"><span>Оплатить сейчас <?= $model->getCalculatePrice('prepayment') ?> &#8399; </span></button>
        </td>
        <td>
            <!--
            <button type="submit">Забронировать без оплаты</button>
            -->
            <button id="but_reservation">Забронировать без оплаты, и оплатить позже <?= $model->getCalculatePrice('unprepayment') ?> &#8399;</button>
        </td>
    </tr>
</table>
<?php // ActiveForm::end(); ?>