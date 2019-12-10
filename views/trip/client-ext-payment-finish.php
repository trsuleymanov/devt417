<?php


$search_form_is_submitted = true;

$direction = $trip->direction;
$city_from = $direction->cityFrom;
$city_to = $direction->cityTo;


$point_from = $city_from->name;
$point_to = $city_to->name;
$date = date('d-m-Y', $trip->date);

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
    <h2>Спасибо за заказ.</h2>
</div>

<?= $this->render('/layouts/footer') ?>