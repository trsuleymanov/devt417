<?php

namespace app\modules\account;

use yii\base\Module;

class Account extends Module
{
    public $controllerNamespace = 'app\modules\account\controllers';

    public function init()
    {
        parent::init();
        $this->layout = 'main';
    }
}