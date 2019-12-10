<?php

use yii\db\Migration;

/**
 * Class m180416_112902_add_code_account_fields_to_user_and_clientext
 */
class m180416_112902_add_code_account_fields_to_user_and_clientext extends Migration
{

    public function up()
    {
        $this->addColumn('user', 'code_for_friends', $this->string(6)->comment('Код "Приведи друга"')->unique()->after('restore_code'));
        $this->addColumn('user', 'friend_code', $this->string(6)->comment('Код переданный от друга')->after('code_for_friends'));
        $this->addColumn('user', 'account', $this->decimal(8, 2)->defaultValue(0)->comment('Код переданный от друга')->after('friend_code'));

        $this->addColumn('client_ext', 'friend_code', $this->string(6)->comment('Код переданный от друга')->after('transport_color'));
    }

    public function down()
    {
        $this->dropColumn('user', 'code_for_friends');
        $this->dropColumn('user', 'friend_code');
        $this->dropColumn('user', 'account');

        $this->dropColumn('client_ext', 'friend_code');
    }
}
