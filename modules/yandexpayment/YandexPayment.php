<?php

namespace app\modules\yandexpayment;

use yii\base\Module;

class YandexPayment extends Module
{
    public $controllerNamespace = 'app\modules\yandexpayment\controllers';

    public function init()
    {
        parent::init();
        $this->layout = 'main';
    }
}