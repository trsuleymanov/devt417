<?php
use yii\helpers\Html;

$this->title = 'Редактирование пользователя &laquo;' . $model->last_name.' '.$model->first_name . '&raquo;';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
