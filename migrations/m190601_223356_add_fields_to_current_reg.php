<?php

use yii\db\Migration;

/**
 * Class m190601_223356_add_fields_to_current_reg
 */
class m190601_223356_add_fields_to_current_reg extends Migration
{
    public function up()
    {
        $this->addColumn('current_reg', 'sms_code', $this->integer()->comment('Код подтверждения телефона пользователя')->after('registration_code'));
        $this->addColumn('current_reg', 'sended_sms_code_at', $this->integer()->comment('Время отправки кода')->after('sms_code'));
        $this->addColumn('current_reg', 'count_sended_sms', $this->integer()->defaultValue(0)->comment('Количество отправок кода')->after('sended_sms_code_at'));
        $this->addColumn('current_reg', 'is_confirmed_mobile_phone', $this->boolean()->defaultValue(0)->comment('Подтвержден мобильный телефон')->after('count_sended_sms'));
        $this->dropColumn('user', 'confirmed');
    }

    public function down()
    {
        $this->dropColumn('current_reg', 'is_confirmed_mobile_phone');
        $this->dropColumn('current_reg', 'count_sended_sms');
        $this->dropColumn('current_reg', 'sended_sms_code_at');
        $this->dropColumn('current_reg', 'sms_code');
        $this->addColumn('user', 'confirmed', $this->boolean()->defaultValue(false)->comment('Подтвержден')->after('attempt_date'));
    }
}
