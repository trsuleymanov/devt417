<?php

use yii\db\Migration;

/**
 * Class m181014_165641_add_phone_email_to_client_ext
 */
class m181014_165641_add_phone_email_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'phone', $this->string(20)->comment('Телефон')->after('user_id'));
        $this->addColumn('client_ext', 'email', $this->string(50)->comment('Электронная почта')->after('phone'));
        $this->addColumn('client_ext', 'is_mobile', $this->boolean()->defaultValue(0)->comment('Заявка создана в приложении')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'is_mobile');
        $this->dropColumn('client_ext', 'email');
        $this->dropColumn('client_ext', 'phone');
    }
}
