<?php

namespace app\commands;

use app\models\City;
use app\models\Push;
use app\models\Trip;
use app\models\YandexPayment;
use app\models\YandexPoint;
use Yii;
use app\models\ClientExt;
use app\models\User;
use yii\base\ErrorException;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\ForbiddenHttpException;

/**
 *  Консольные скрипты (обычно для вызова кроном) для обработки заказов или чего-то что касается напрямую заказов
 */
class ClientextController extends Controller
{

    /*
     * Платежи зависшие в статусе waiting_for_capture проводяться
     *
     * php yii clientext/capture-payments
     */
    public function actionCapturePayments()
    {
        $yandex_payments = YandexPayment::find()
            ->where(['status' => 'waiting_for_capture'])
            // 10 секунд пропускаем так как этот платеж может обрабатываться запросом из приложения
            ->andWhere(['<=', 'waiting_for_capture_at', time() - 10])
            ->orderBy(['id' => SORT_ASC])
            ->limit(10) // больше 5 не стоит, иначе скрипт может 2 раза обрабатывать один и тот же платеж
            ->all();
        if(count($yandex_payments) > 0) {
            $i = 0;
            foreach($yandex_payments as $yandex_payment) {
                $yandex_payment->capturePayment();
                $i++;
            }
            echo "готово. Обработано $i платежей \n";
        }else {
            echo "платежей для проводки нет \n";
        }
    }


    /*
     * Незаконченные заказы созданные более 30 минут назад отменяются автоматически
     *
     * php yii clientext/cancel-not-ready-orders
     */
    public function actionCancelNotReadyOrders()
    {
        $not_ready_orders = ClientExt::find()
            ->where(['status' => ''])
            ->andWhere(['>', 'created_at', time() - 1800])
            ->all();

        $i = 0;
        if(count($not_ready_orders) > 0) {
            foreach ($not_ready_orders as $order) {
                $order->setStatus('canceled_not_ready_order_auto');
                $i++;
            }
        }

        echo "отменено $i заказов\n";
    }
}
