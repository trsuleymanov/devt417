<?php

/* @var $this \yii\web\View */
/* @var $content string */


use app\assets\MainPageAsset;

MainPageAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->head() ?>
    <style type="text/css">
        #my-content {
            background: -webkit-gradient(linear,left bottom, left top,from(#fcbe37),to(#fda53a));
            background: linear-gradient(to top,#fcbe37 0%,#fda53a 100%);
            min-height: 100%;
            padding-top: 30px;
            padding-left: 20px;
        }
    </style>
    <title>Project Title</title>
</head>
<body>
<?php $this->beginBody() ?>

<div id="my-content">
    <?= $content ?>
</div>

<?php $this->endBody() ?>

<div id="default-modal" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md" style="width: 450px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <span class="modal-title">Заголовок...</span>
            </div>
            <div class="modal-body">
                <div id="modal-content">Загружаю...</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php $this->endPage() ?>