<?php

use app\components\Helper;
use yii\web\JsExpression;
use app\widgets\EditableTextWidget;

$this->registerCssFile('css/account/lk.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('js/account/account.js', ['depends'=>'app\assets\NewAppAsset']);

//$email = $user->email;
//$aEmails = explode('@', $user->email);
//if(strlen($aEmails[0]) >= 4) {
//    $aEmails[0] = substr($aEmails[0], 0, 2) . "**" . substr($aEmails[0], 4);
//}
//$aEmailsDot = explode('.', $aEmails[1]);
//if(strlen($aEmailsDot[0]) >= 4) {
//    $aEmailsDot[0] = "**". substr($aEmailsDot[0], 2);
//}
//$user->email = $aEmails[0]."@".$aEmailsDot[0].".".$aEmailsDot[1];
// echo 'email='.$user->email.'<br />';
?>

<div class="reservation__menu">
    <div class="reservation_menu__title">МОЙ ПРОФИЛЬ</div>
    <div class = "personal__block">
        <div class = "personal__row">
            <div class = "personal__block__title">
                Персональные данные
            </div>
            <div class = "personal__block__text">
                Необходимо ввести, как минимум, фамилию - чтобы водитель мог идентифицировать вас при посадке
            </div>
        </div>
        <div class = "personal__row">
            <div class = "personal__row__title">
                Фамилия
            </div>
            <div class = "personal__row__value_">
                <?php
                    echo EditableTextWidget::widget([
                        'name' => 'last_name',
                        'value' => $user->last_name,
                        'defaultValue' => '<span class="text-danger">Введите Фамилию</span>',
                        'onChange' => new JsExpression('function(id, etf_block, name, value) {
                            $.ajax({
                                url: "/account/personal/editable-user?id='.$user->id.'",
                                type: "post",
                                data: {
                                    hasEditable: 1,
                                    last_name: value
                                },
                                success: function (data) {
                                    if(data.message != "") {
                                        alert(data.message);
                                    }else {
                                        etf_block.hide();
                                        if(data.output == "") {
                                            $("#" + id).html("<span class=\"text-danger\">Введите Фамилию</span>").show();
                                        }else {
                                            $("#" + id).text(data.output).show();
                                        }
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
                        }')
                    ]);
                ?>
            </div>
        </div>
        <div class = "personal__row">
            <div class = "personal__row__title">
                Имя
            </div>
            <div class = "personal__row__value_">
                <?php
                echo EditableTextWidget::widget([
                    'name' => 'last_name',
                    'value' => $user->first_name,
                    'defaultValue' => '<span class="text-danger">Введите Имя</span>',
                    'onChange' => new JsExpression('function(id, etf_block, name, value) {
                            $.ajax({
                                url: "/account/personal/editable-user?id='.$user->id.'",
                                type: "post",
                                data: {
                                    hasEditable: 1,
                                    first_name: value
                                },
                                success: function (data) {
                                    if(data.message != "") {
                                        alert(data.message);
                                    }else {
                                        etf_block.hide();
                                        if(data.output == "") {
                                            $("#" + id).html("<span class=\"text-danger\">Введите Имя</span>").show();
                                        }else {
                                            $("#" + id).text(data.output).show();
                                        }
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
                        }')
                ]);
                ?>
            </div>
        </div>
        <div class = "personal__row personal__row__static">
            <div class = "personal__row__title">
                Телефон
            </div>
            <div class = "personal__row__value">
                <span id="phone"><?= Helper::convertDBToWebMobile($user->phone); ?> </span>
                <?php
//                echo \yii\widgets\MaskedInput::widget([
//                    'name' => 'phone',
//                    'value' => Helper::convertDBToWebMobile($user->phone),
//                    'mask' => '+7 (999) 999 99 99',
//                    'clientOptions' => [
//                        'placeholder' => '–',
//                    ],
//                    'options' => [
//                        'class' => 'etf-block etf-change',
//                        'for' => 'phone',
//                        'style' => 'display: none;',
//                        'user-id' => $user->id
//                    ]
//                ]);
                ?>
            </div>
        </div>
        <div class = "personal__row personal__row__password">
            <div class = "personal__row__title">
                Пароль
            </div>
            <div class = "personal__row__value">
                <?php
                    echo EditableTextWidget::widget([
                        'name' => 'password',
                        'value' => '',
                        //'defaultValue' => '<span class="text-danger">Введите пароль</span>',
                        'defaultValue' => '********',
                        'onChange' => new JsExpression('function(id, etf_block, name, value) {
                            $.ajax({
                                url: "/account/personal/editable-user?id='.$user->id.'",
                                type: "post",
                                data: {
                                    hasEditable: 1,
                                    password: value
                                },
                                success: function (data) {
                                    if(data.message != "") {
                                        alert(data.message);
                                        //$("div[field=\"password\"] .etf-but-cancel").click();
                                        var $etf_block = $("input[name=\"password\"]").parents(".etf-block");
                                        etfCancel($etf_block);
                                    }else {
                                        etf_block.hide();
                                        if(data.output == "") {
                                            $("#" + id).html("<span class=\"text-danger\">Введите пароль</span>").show();
                                        }else {
                                            $("#" + id).text(data.output).show();
                                        }
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
                        }')
                    ]);
                ?>
            </div>
        </div>
        <div class = "personal__row">
            <div class = "personal__row__title">
                Электронная почта
            </div>
            <div class = "personal__row__value">
                <?php
                echo EditableTextWidget::widget([
                    'name' => 'email',
                    'value' => Helper::setMaskToEmail($user->email),
                    'defaultValue' => '<span class="text-danger">Введите электронную почту</span>',
                    'onChange' => new JsExpression('function(id, etf_block, name, value) {
                        $.ajax({
                            url: "/account/personal/editable-user?id='.$user->id.'",
                            type: "post",
                            data: {
                                hasEditable: 1,
                                email: value
                            },
                            success: function (data) {
                                if(data.message != "") {
                                
                                    alert(data.message);
                                    
                                    var $obj = $("input[name=\"email\"]");
                                    var val = $obj.val();
                                    var $etf_block = $obj.parents(".etf-block");
                                    $etf_block.prev(".etw-element").text(val);
                                    etfCancel($etf_block);
                                    
                                }else {
                                    etf_block.hide();
                                    if(data.output == "") {
                                        $("#" + id).html("<span class=\"text-danger\">Введите электронную почту</span>").show();
                                    }else {
                                        $("#" + id).text(data.output).show();
                                    }
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
                    }')
                ]);
                ?>
                <?php /*
                <a class = "etw-element"><?= Helper::setMaskToEmail($user->email) ?></a>
                */ ?>
            </div>
        </div>
    </div>
    <div class="cashback__block">
        <div class="cashback__title">
            Кэш-бэк и скидки
        </div>
        <div class="cashback__info">
            <div class="cashback__row cashback__row__total">
                <div class="cashback__row__title">
                    Всего получено скидок:
                </div>
                <div class="cashback__row__value">
                    0.00<span>р.</span>
                </div>
            </div>
            <div class="cashback__row">
                <div class="cashback__row__title">
                    Остаток кэш-бека:
                </div>
                <div class="cashback__row__value">
                    0.00<span>р.</span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php /*
<div class="row">
    <div class="col-md-2">Кэш-бэк:</div>
    <div class="col-md-3">
        <?= $user->cashback; ?>
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-2">Эл. почта:</div>
    <div class="col-md-3">
        <?= $user->email; ?>
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-2">ФИО:</div>
    <div class="col-md-3">
        <?= EditableTextWidget::widget([
            'name' => 'fio',
            'value' => $user->fio,
            'defaultValue' => '<span class="text-danger">Введите имя</span>',
            'onChange' => new JsExpression('function(id, etf_block, name, value) {
                $.ajax({
                    url: "/account/personal/editable-user?id='.$user->id.'",
                    type: "post",
                    data: {
                        hasEditable: 1,
                        fio: value
                    },
                    success: function (data) {
                        if(data.message != "") {
                            alert(data.message);
                        }else {
                            etf_block.hide();
                            if(data.output == "") {
                                $("#" + id).html("<span class=\"text-danger\">Введите имя</span>").show();
                            }else {
                                $("#" + id).text(data.output).show();
                            }
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
            }')
        ]);
        ?>
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-2">Телефон:</div>
    <div class="col-md-3">
        <?= EditableTextWidget::widget([
            'name' => 'phone',
            'value' => $user->phone,
            'defaultValue' => '<span class="text-danger">Введите номер</span>',
            'onChange' => new JsExpression('function(id, etf_block, name, value) {
                $.ajax({
                    url: "/account/personal/editable-user?id='.$user->id.'",
                    type: "post",
                    data: {
                        hasEditable: 1,
                        phone: value
                    },
                    success: function (data) {
                        if(data.message != "") {
                            alert(data.message);
                        }else {
                            etf_block.hide();
                            if(data.output == "") {
                                $("#" + id).html("<span class=\"text-danger\">Введите номер</span>").show();
                            }else {
                                $("#" + id).text(data.output).show();
                            }
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
            }')
        ]);
        ?>
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-2">Пароль:</div>
    <div class="col-md-3" field="password">
        <?= EditableTextWidget::widget([
            'name' => 'password',
            'value' => '',
            //'defaultValue' => '<span class="text-danger">Введите пароль</span>',
            'defaultValue' => '********',
            'onChange' => new JsExpression('function(id, etf_block, name, value) {
                $.ajax({
                    url: "/account/personal/editable-user?id='.$user->id.'",
                    type: "post",
                    data: {
                        hasEditable: 1,
                        password: value
                    },
                    success: function (data) {
                        if(data.message != "") {
                            alert(data.message);
                            $("div[field=\"password\"] .etf-but-cancel").click();
                        }else {
                            etf_block.hide();
                            if(data.output == "") {
                                $("#" + id).html("<span class=\"text-danger\">Введите пароль</span>").show();
                            }else {
                                $("#" + id).text(data.output).show();
                            }
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
            }')
        ]);
        ?>
    </div>
</div>
 <?php /**/ ?>