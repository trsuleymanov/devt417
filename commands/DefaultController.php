<?php

namespace app\commands;

use app\models\Call;
use app\models\ClientExt;
use app\models\CurrentReg;
use yii\console\Controller;
use Yii;



class DefaultController extends Controller
{
    /*
     * команда: php yii default/explode-clientext-fio
     */
    public function actionExplodeClientextFio()
    {
        $start = microtime(true);

        // 0.4 сек
        $sql = "SELECT id,fio FROM `client_ext`";
        $clientexts = Yii::$app->db->createCommand($sql)->queryAll(); // 198600 записей
        // echo "count_clientexts=".count($clientexts)."<br />";


        $aClientexts = [];
        foreach ($clientexts as $clientext) {
            if(!empty($clientext['fio'])) {
                $aClientexts[$clientext['id']] = $clientext['fio'];
            }
        }
        echo "count_aClientexts=".count($aClientexts)."<br />";
        // echo "время=".(microtime(true) - $start)."<br />";

        $i = 0;
        foreach ($aClientexts as $id => $fio) {

            $aNames = explode(' ', $fio);
            $last_name = $aNames[0];
            if(isset($aNames[1])) {
                $first_name = $aNames[1];
                if(isset($aNames[2])) {
                    $first_name .= ' '.$aNames[2];
                }
            }else {
                $first_name = '';
            }

            $sql = 'UPDATE `client_ext` SET last_name="'.$last_name.'", first_name="'.$first_name.'" WHERE id='.$id;
            Yii::$app->db->createCommand($sql)->execute();

            $i++;
            if($i/100 == intval($i/100)) {
                echo "обновлено $i записей \n";
            }
        }

        echo "время=".(microtime(true) - $start)."<br />";


        return true;
    }


    /*
     * команда: php yii default/explode-user-fio
     */
    public function actionExplodeUserFio()
    {
        $start = microtime(true);

        $sql = "SELECT id,fio FROM `user`";
        $users = Yii::$app->db->createCommand($sql)->queryAll(); // 64229 записей
        //echo "count_users=".count($users)."<br />";

        $aUsers = [];
        foreach ($users as $user) {
            if(!empty($user['fio'])) {
                $aUsers[$user['id']] = $user['fio'];
            }
        }
        //echo "count_users=".count($aUsers)."<br />"; // 0.11 сек - 64218 записей

        $i = 0;
        foreach ($aUsers as $id => $fio) {

            $aNames = explode(' ', $fio);
            $last_name = $aNames[0];
            if(isset($aNames[1])) {
                $first_name = $aNames[1];
                if(isset($aNames[2])) {
                    $first_name .= ' '.$aNames[2];
                }
            }else {
                $first_name = '';
            }

            $sql = 'UPDATE `user` SET last_name="'.$last_name.'", first_name="'.$first_name.'" WHERE id='.$id;
            Yii::$app->db->createCommand($sql)->execute();

            $i++;
            if($i/100 == intval($i/100)) {
                echo "обновлено $i записей \n";
            }
        }

        echo "время=".(microtime(true) - $start)."<br />";
    }


}
