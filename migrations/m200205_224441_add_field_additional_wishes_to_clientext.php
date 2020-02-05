<?php

use yii\db\Migration;

/**
 * Class m200205_224441_add_field_additional_wishes_to_clientext
 */
class m200205_224441_add_field_additional_wishes_to_clientext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'additional_wishes', $this->string(255)->comment('Дополнительные пожелания')->after('yandex_point_to_long'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'additional_wishes');
    }
}
