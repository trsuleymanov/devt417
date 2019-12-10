<?php

use app\models\Direction;
use app\models\Passenger;


$search_form_is_submitted = true;

//$direction = $trip->direction;
$direction = Direction::find()->where(['id' => $client_ext->direction])->one();
$city_from = $direction->cityFrom;
$city_to = $direction->cityTo;


$point_from = $city_from->name;
$point_to = $city_to->name;
$date = date('d-m-Y', $client_ext->data);

echo $this->render('/layouts/header', [
    'search_form_is_submitted' => $search_form_is_submitted,
    'point_from' => $point_from,
    'point_from_error' => '',
    'point_to' => $point_to,
    'point_to_error' => '',
    'date' => $date,
    'date_error' => ''
]) ?>
<div id="page-content">

    <table style="width: 800px;">
        <tr><td>Рейс</td><td><?= ($client_ext->direction == 1 ? 'Альметьевск-Казань' : 'Казань-Альметьевск') ?></td></tr>
        <tr><td>Отправление</td><td><?= date('d.m.Y', $client_ext->data) ?> в <?= $client_ext->time ?> </td></tr>
        <tr><td>Из точки</td><td><?= $client_ext->yandex_point_from_name ?></td></tr>
        <tr><td>В точку</td><td><?= $client_ext->yandex_point_to_name ?></td></tr>
        <tr><td>Мест</td><td><?= $client_ext->places_count ?> шт.</td></tr>
        <tr><td>&nbsp;</td><td></td></tr>
        <tr><td>Контактная информация</td><td></td></tr>
        <tr><td>Эл.почта</td><td><?= $client_ext->email ?></td></tr>
        <tr><td>Телефон</td><td><?= $client_ext->phone ?></td></tr>
        <tr><td>&nbsp;</td><td></td></tr>
        <tr><td>Пассажиры</td><td></td></tr>
        <?php foreach($passengers as $passenger) { ?>
            <tr><td><?= $passenger->fio ?></td><td><?= Passenger::getDocumentTypes()[$passenger->document_type] ?>: <?= !empty($passenger->citizenship) ? $passenger->citizenship.' ' : '' ?><?= $passenger->series_number ?></td></tr>
        <?php } ?>
        <tr><td>&nbsp;</td><td></td></tr>
        <tr>
            <td>К оплате</td>
            <td><?= $client_ext->price ?> &#8399;</td>
            <?php /*<td><input id="payment-summ" type="text" value="<?= $client_ext->price ?>" /></td> */ ?>
            <td><button id="make-simple-payment" client-ext-id="<?= $client_ext->id ?>" class="payment-button"><span>Оплатить</span></button></td>
        </tr>
    </table>

    <!--
    <div style="display: inline-block; width: 200px; height: 100px; border: 1px #EEEEEE solid; margin-left: 0px; ">
        <a href="#">Оплатить на сайте</a>
    </div>
    <div style="display: inline-block; width: 200px; height: 100px; border: 1px #EEEEEE solid; margin-left: 300px;">
        <a href="#">Зарезервировать и позже оплатить водителю</a>
    </div>
    -->
    <?php /*
    <br /><br />
    <table style="width: 750px;">
        <tr><td><a href="">Оплатить на сайте</a></td><td><a id="rezerv-client-ext" access-code="<?= $client_ext->access_code ?>" href="">Зарезервировать и позже оплатить водителю</a></td></tr>
    </table>*/ ?>
</div>

<?= $this->render('/layouts/footer') ?>