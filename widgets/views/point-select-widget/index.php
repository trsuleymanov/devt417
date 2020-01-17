<?php
use yii\helpers\Html;


// Параметры/настройки для виджета в js


// эти параметры переезжаются в html аттрибуты
$js = '
    var element_id = "'.$options['id'].'";

    if(psw_setting == void 0) {
        var psw_setting = [];
    }

    psw_setting[element_id] = {
        ajax_url: "'.$ajax['url'].'",
        element_id: element_id,
        psw_is_open: false
    };
';


if(isset($ajax['data'])) {
    $js .= 'psw_setting[element_id].ajax_data = '.$ajax['data'].';';
}
//if(isset($ajax['afterRequest'])) {
//    $js .= 'sw_setting[element_id].afterRequest = '.$afterRequest.';';
//}
if(!empty($afterRequest)) {
    $js .= 'psw_setting[element_id].afterRequest = '.$afterRequest.';';
}
if(!empty($afterChange)) {
    $js .= 'psw_setting[element_id].afterChange = '.$afterChange.';';
}
if(!empty($open_url)) {
    $js .= 'psw_setting[element_id].open_url = '.$open_url;
}
if(!empty($add_new_value_url)) {
    $js .= 'psw_setting[element_id].add_new_value_url = '.$add_new_value_url;
}


$this->registerJs($js, \yii\web\View::POS_END);

?>

<div class="reservation-drop__select-select psw-element"
     attribute-name = "<?= $name ?>" <?= (isset($options['disabled']) ? 'disabled="'.$options['disabled'].'" ' : '') ?>
     ajax_url = "<?= $ajax['url'] ?>"
     psw_is_open = "false"
    >
    <span class="psw-text">
        <?php if($using_delete_button == true) { ?>
            <span class="psw-delete glyphicon glyphicon-remove" <?= (empty($value) ? 'style="display: none;"' : '') ?>></span>
        <?php } ?>
        <?php if(!empty($open_url)) { ?>
            <span class="psw-open glyphicon glyphicon-eye-open" <?= (empty($value) ? 'style="display: none;"' : '') ?>></span>
        <?php } ?>
        <button class="psw-value">
            <?php
            if(!empty($initValueText)) {
                echo $initValueText;
            }else {
                if(!empty($value)) {
                    echo $value;
                }else {
                    if(isset($options['placeholder'])) {
                        echo '<span class="psw-placeholder">' . $options['placeholder'] . '</span>';
                    }
                }
            }
            ?>
        </button>
    </span>
    <?= Html::hiddenInput($name, $value, $options) ?>
</div>
<div class="psw-outer-block" attribute-name="<?= $name ?>" style="display: none;">
    <div class="psw-inner-block">
        <input type="text" class="psw-search">
        <div class="psw-select-block" style="display: none;">
            <!-- сюда можно засунуть preload-рисунок или что-то подобное -->
        </div>
    </div>
</div>