<?php
namespace app\widgets;

use Yii;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\web\View;
use yii\base\ErrorException;
use yii\web\UnprocessableEntityHttpException;

/*
 * Элемент формы с выпадающим списком и поиском для выбора яндекс-точки при создании заказа на шаге1 для
 * модальных окон "Адрес и время посадки" и "Пункт назначения".
 */
class PointSelectWidget extends InputWidget
{
    /*
     * Текстовое значение отображаемое в поле (если оно не передано, то отображается значение текущего аттрибута формы)
     */
    public $initValueText = ''; // не обязательный параметр

    /*
     * Содержит параметры для формирования ajax-запроса
     * Может содержать в себе параметры:
     * - url - путь запроса на сервер - обязательный параметр
     * - data - список передаваемых параметров в ajax-запросе на сервер  - не обязательный параметр
     */
    public $ajax = [];  // обязательный параметр

    public $open_url = ''; // js-код функции возвращающей url для открытия окна при нажатии на глаз

    public $afterRequest;
    public $afterChange = '';// js-код функции вызываемой автоматически после изменения значения в виджете

    public $add_new_value_url = ''; // js-код функции возвращающей url для создания нового значения с уже вставленными в урл параметрами (в том числе с новым значением)



    public $using_delete_button = true;


    public function run()
    {
        if(!isset($this->ajax['url'])) {
            throw new UnprocessableEntityHttpException('В SelectWidget не передан параметр [ajax][url]');
        }

        if ($this->hasModel()) { // нужно передавать и model и attribute чтобы условие выполнилось
            $this->name = empty($this->options['name']) ? Html::getInputName($this->model, $this->attribute) : $this->options['name'];
            if(empty($this->value)) {
                $this->value = Html::getAttributeValue($this->model, $this->attribute);
            }
        }

        //$this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        $this->options['id'] = $this->getId(); // уникальный id, и не ебет

        return $this->render('point-select-widget/index', [
            'name' => $this->name,
            'value' => $this->value,
            'options' => $this->options,
            'initValueText' => $this->initValueText,

            'ajax' => $this->ajax,
            'open_url' => $this->open_url,
            'afterRequest' => $this->afterRequest,
            'afterChange' => $this->afterChange,
            'add_new_value_url' => $this->add_new_value_url,

            'using_delete_button' => $this->using_delete_button
        ]);
    }
}