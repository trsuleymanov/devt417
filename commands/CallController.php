<?php

namespace app\commands;

use app\models\Call;
use app\models\CurrentReg;
use yii\console\Controller;
use Yii;



class CallController extends Controller
{
    /*
     * команда: php yii call/close-reg-call-forwardin
     */
    public function actionCloseRegCallForwardin()
    {
        // устанавливаем тестово 3 минуты - время от начала регистрации до закрытия переадресации
        $close_reg_interval = 180;

        $regs = CurrentReg::find()
            //->where(['is_confirmed_mobile_phone' => 0])
            ->where(['>', 'input_mobile_at', 0])
            ->andWhere(['<', 'input_mobile_at', time() - $close_reg_interval])
            ->all();
        // echo "regs:<pre>"; print_r($regs); echo "</pre>";

        if(count($regs) > 0) {
            foreach ($regs as $reg) {
                if(!empty($reg->mobile_phone)) {
                    if(Call::deleteCallForwarding($reg->mobile_phone)) {
                        $reg->setField('input_mobile_at', NULL);
                    }
                }
            }
        }

        // отправляем сигнал в браузеры с новым количеством пропущенных звонков
        // Call::sentToBrawsersMissedCallsCount();

        return true;
    }

}
