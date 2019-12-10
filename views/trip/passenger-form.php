<?php
use app\models\Passenger;
use yii\helpers\Html;


?>
<div class="passenger-form">
    <?php /*
    <div class="passenger-form-head">
        <div class="passenger-form-price-select">
            <div class="y-select y-select_theme_normal passenger-form-tarif">
                <?php
//                echo Html::activeDropDownList(
//                    $passenger,
//                    'tariff_type',
//                    Passenger::getTariffTypes(),
//                    ['class' => "form-control"]
//                )
                ?>
                <select id="passenger-tariff_type" class="form-control" name="Passenger[tariff_type]">
                    <?php
                    $aTariffsPrices = Passenger::getTariffsPrices();
                    foreach(Passenger::getTariffTypes() as $key => $name) { ?>
                        <option value="<?= $key ?>" price="<?= $aTariffsPrices[$key] ?>" ><?= $name ?></option>
                    <?php } ?>
                </select>
            </div> – <span class="passenger-form-price"><?= Passenger::getTariffsPrices()['standart'] ?> &#8399;</span>
        </div>
        <i class="passenger-form-remove" style="display: none;"></i>
    </div>
    */ ?>
    <div class="passenger-form-head">
        <div class="passenger-form-price-select">
            <div class="y-select y-select_theme_normal passenger-form-tarif">Цена за место</div> – <span class="passenger-form-price">450 &#8399;</span>
        </div>
        <i class="passenger-form-remove" style="display: none;"></i>
    </div>

    <div class="passenger-form-row">
        <div class="passenger-form-field passenger-form-fio">
            <div class="form-input">
                <label class="form-input-label" for="fio-0">ФИО</label>
                <div class="y-input y-input_theme_normal y-input_size_m y-input_width_ y-input_empty">
                    <?php echo Html::activeTextInput($passenger, 'fio', ['class' => "form-control"]) ?>
                </div>
                <!--<span class="form-input-error-msg">Укажите фамилию, имя и отчество.</span>-->
            </div>
        </div>
        <div class="passenger-form-field passenger-form-genderTypeName">
            <div class="form-input">
                <label class="form-input-label">Пол</label>
                <div aria-invalid="false" class="y-select y-select_theme_normal" style="width: 116px;">
                    <?php echo Html::activeDropDownList(
                        $passenger,
                        'gender',
                        Passenger::getGenders(),
                        ['class' => "form-control"]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="passenger-form-row">
        <div class="passenger-form-field passenger-form-birthDate">
            <div class="form-input">
                <label class="form-input-label" for="birthDate-0">Дата рождения</label>
                <div class="y-input y-input_theme_normal y-input_size_m y-input_width_ y-input_empty ">
                    <?php echo Html::activeTextInput(
                        $passenger,
                        'date_of_birth',
                        ['class' => "form-control", 'placeholder' => 'дд.мм.гггг']
                    ) ?>
                </div>
                <!--<span class="form-input-error-msg">Неверная дата</span>-->
            </div>
        </div>
        <div class="passenger-form-field passenger-form-docTypeName">
            <div class="form-input ">
                <label class="form-input-label">Документ</label>
                <div class="y-select y-select_theme_normal" style="width: 269px;">
                    <?php
//                    echo Html::activeDropDownList(
//                        $passenger,
//                        'document_type',
//                        Passenger::getDocumentTypes(),
//                        ['class' => "form-control"]
//                    );
                    ?>
                    <select id="passenger-document_type" class="form-control" name="Passenger[document_type]">
                        <?php foreach(Passenger::getDocumentTypes() as $key => $value) { ?>
                            <option value="<?= $key ?>" series_number_placeholder="<?= Passenger::getDocumentTypesPlaceholders()[$key] ?>" ><?= $value ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="passenger-form-field passenger-form-citizenship" style="display: none;">
            <div class="form-input">
                <label class="form-input-label">Гражданство (страна)</label>
                <div class="y-input y-input_theme_normal y-input_size_m y-input_empty">
                    <?php echo Html::activeTextInput($passenger, 'citizenship', ['class' => "form-control"]) ?>
                </div>
                <!--<span class="form-input-error-msg">Некорректный номер документа</span>-->
            </div>
        </div>

        <div class="passenger-form-field passenger-form-docValue">
            <div class="form-input">
                <label class="form-input-label">Серия и номер документа</label>
                <div class="y-input y-input_theme_normal y-input_size_m y-input_width_ y-input_empty">
                    <?php echo Html::activeTextInput($passenger, 'series_number', ['class' => "form-control", 'placeholder' => Passenger::getDocumentTypesPlaceholders()['passport']]) ?>
                </div>
                <!--<span class="form-input-error-msg">Некорректный номер документа</span>-->
            </div>
        </div>
    </div>
</div>

