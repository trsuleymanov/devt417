<?php
//echo $point_from;
?>
<div id="header" class="<?= $search_form_is_submitted ? 'header-border' : '' ?>">
    <div class="header-top">

        <div class="logo-section">
            <a href="/">
                <img src="https://yastatic.net/q/logoaas/v1/Яндекс.svg" alt="logo">
                <span class="y-link y-link_theme_normal "><img src="https://yastatic.net/q/logoaas/v1/Автобусы.svg" alt="logo"></span>
            </a>
        </div>


        <?php if($search_form_is_submitted == false) { ?>
            <nav class="nav-section">
                <ul class="header-nav-list">
                    <li class="header-nav-item"><a target="blank" type="" class="y-link y-link_theme_normal header-nav-link" href="#">Авиабилеты</a></li>
                    <li class="header-nav-item"><a target="blank" type="" class="y-link y-link_theme_normal header-nav-link" href="#">Ж/д билеты</a></li>
                    <li class="header-nav-item"><a target="blank" type="" class="y-link y-link_theme_normal header-nav-link" href="#">Туры</a></li>
                    <li class="header-nav-item"><a target="blank" type="" class="y-link y-link_theme_normal header-nav-link" href="#">Отели</a></li>
                    <li class="header-nav-item"><a class="header-nav-link header-nav-link_active" href="#">Автобусы</a></li>
                </ul>
            </nav>
        <?php } ?>

        <form id="search-form" action="/" class="<?= ($search_form_is_submitted == false ? 'uncovered' : '') ?>" is-submitted="<?= $search_form_is_submitted ?>" >
            <div class="search-form-block">

                <div id="point-from" class="point-input">
                    <!--<span class="input_clear"></span>-->
                    <input type="text" value="<?= $point_from ?>" name="point-from" placeholder="Откуда" />
                    <div class="field-error" style="<?= !empty($point_from_error) ? 'display: block;' : '' ?>"><?= $point_from_error ?></div>
                </div>
                <button id="direction-switcher">
                    <img src="https://yastatic.net/q/bus/v0/static/desktop/media/icon_switch_24x24.728a9595.svg" />
                </button>
                <div id="point-to" class="point-input">
                    <input type="text" value="<?= $point_to ?>" name="point-to" placeholder="Куда" />
                    <div class="field-error" style="<?= !empty($point_to_error) ? 'display: block;' : '' ?>"><?= $point_to_error ?></div>
                </div>
                <div id="date" class="point-input date-input">
                    <input id="search-form-date" name="date" type="text" value="<?= $date ?>" />
                    <span id="search-form-date-img" class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    <div class="field-error" style="<?= !empty($date_error) ? 'display: block;' : '' ?>"><?= $date_error ?></div>
                </div>

            </div>
            <button class="search-button" type="submit"><span>Найти</span></button>
        </form>

        <div class="user-section">
            <?php if(Yii::$app->user->isGuest) { ?>
                <a id="open-login-form" href="#">Вход</a>
            <?php }else { ?>
                <!--<a id="open-change-password-form" href="#">Изменение пароля</a>-->
                <a href="/account/personal">Личный кабинет</a>
                &nbsp;&nbsp;&nbsp;
                <a href="/site/logout">Выход</a>
            <?php } ?>
        </div>
    </div>

    <div class="search-section">

    </div>

</div>
