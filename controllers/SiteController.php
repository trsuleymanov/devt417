<?php

namespace app\controllers;

use app\models\Call;
use app\models\ChangePasswordForm;
use app\models\ClientExt;
use app\models\ClientExtChild;
use app\models\CurrentReg;
use app\models\InputPhoneForm;
use app\models\RegistrationForm;
use app\models\RestorePasswordForm;
use app\models\Setting;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\LoginForm;
use app\models\User;

class SiteController extends Controller
{
    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
*/
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ClientExt();
        $model->scenario = 'first_form';

        $user = Yii::$app->user->identity;
        if($user != null) {
            $model->user_id = $user->getId();
        }


        $post = Yii::$app->request->post();

        if(count($post) > 0) {

            Yii::$app->response->format = 'json';
            if ($model->load($post) && $model->validate() && $model->save()) {

                if (isset($post['ClientExtChild'])) {
                    foreach ($post['ClientExtChild'] as $postClientExtChild) {
                        $clientext_child = new ClientExtChild();
                        $clientext_child->clientext_id = $model->id;
                        if (in_array($postClientExtChild['age'], ['<1', '1-2', '3-6', '7-10'])) {
                            $clientext_child->age = $postClientExtChild['age'];
                        }
                        $clientext_child->self_baby_chair = ($postClientExtChild['self_baby_chair'] == "true" ? true : false);
                        if (!$clientext_child->save(false)) {
                            throw new ForbiddenHttpException('Не удалось сохранить данные о ребенке');
                        }
                    }
                }

                $model->access_code = $model->generateAccessCode();
                $model->setField('access_code', $model->access_code);

                if ($model->city_from_id == 1 && $model->city_to_id == 2) {
                    $model->direction_id = 2;
                } elseif ($model->city_from_id == 2 && $model->city_to_id == 1) {
                    $model->direction_id = 1;
                }
                $model->setField('direction_id', $model->direction_id);

                //return $this->redirect('/site/create-order?c='.$model->access_code); // возникают проблемы в js с обработкой
                return [
                    'success' => true,
                    'redirect_url' => '/site/create-order?c=' . $model->access_code
                ];

            }else {

                return [
                    'errors' => $model->getErrors()
                ];
            }

        } else {

            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @param $c
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionCreateOrder($c)
    {
        // Yii::$app->controller->layout = 'main_page2';

        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $user = Yii::$app->user->identity;
        if($user != null && empty($model->user_id)) {
            $model->user_id = $user->getId();
        }

        $model->scenario = 'second_form';
        $post = Yii::$app->request->post();

        if(count($post) > 0) {

            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {

                //echo "post:<pre>"; print_r(Yii::$app->request->post()); echo "</pre>";
                //return $this->redirect('/site/check-order?c='.$model->access_code);
                //return $this->redirect('/site/create-order-step2?c='.$model->access_code);

                Yii::$app->response->format = 'json';
                return [
                    'success' => true,
                    'redirect_url' => '/site/create-order-step2?c='.$model->access_code
                ];

            } else {

                Yii::$app->response->format = 'json';

                return [
                    'success' => false,
                    'errors' => $model->getErrors()
                ];
            }


        }else {
            $client_ext_childs = [];
            if($model->child_count > 0) {
                $client_ext_childs = ClientExtChild::find()->where(['clientext_id' => $model->id])->all();
            }

            return $this->render('create-order', [
                'model' => $model,
                'client_ext_childs' => $client_ext_childs
            ]);
        }
    }

    public function actionCreateOrderStep2($c)
    {
        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $user = Yii::$app->user->identity;
        if($user != null && empty($model->user_id)) {
            $model->user_id = $user->getId();
        }

        $model->scenario = 'third_form';

        $post = Yii::$app->request->post();
        if(count($post) > 0) {

            if ($model->load($post) && $model->validate() && $model->save()) {

                Yii::$app->response->format = 'json';
                return [
                    'success' => true,
                    'redirect_url' => '/site/check-order?c='.$model->access_code
                ];
            }else {
                Yii::$app->response->format = 'json';

                return [
                    'success' => false,
                    'errors' => $model->getErrors()
                ];
            }

        }else {
            if(Yii::$app->user->identity != null) {
                $model->user_id = Yii::$app->user->identity->id;
                $model->phone = Yii::$app->user->identity->phone;
                $model->email = Yii::$app->user->identity->email;
                $model->fio = Yii::$app->user->identity->fio;
            }

            $client_ext_childs = [];
            if($model->child_count > 0) {
                $client_ext_childs = ClientExtChild::find()->where(['clientext_id' => $model->id])->all();
            }

            return $this->render('create-order-step-2', [
                'model' => $model,
                'client_ext_childs' => $client_ext_childs
            ]);
        }
    }


    /**
     * @param $c
     * @throws ForbiddenHttpException
     */
    public function actionCheckOrder($c)
    {
        // Yii::$app->controller->layout = 'main_page2';

        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $user = Yii::$app->user->identity;
        if($user != null && empty($model->user_id)) {
            $model->user_id = $user->getId();
        }

        if (count(Yii::$app->request->post()) > 0) {
            // return $this->redirect('/site/finish-order?c='.$model->access_code);

            Yii::$app->response->format = 'json';
            return [
                'success' => true,
                'redirect_url' => '/site/finish-order?c='.$model->access_code
            ];

        }else {
            return $this->render('check-order', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $client_ext_id
     * @param $type_button
     * @throws ForbiddenHttpException
     */
    public function actionAjaxSaveButCheckout($c, $type_button) {

        Yii::$app->response->format = 'json';

        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }


        if(Yii::$app->user->identity != null) {
            if(empty($model->user_id)) {
                $model->setField('user_id', Yii::$app->user->identity->id);
            }
        }


        if($type_button == "payment") {

            $model->price = $model->getCalculatePrice('prepayment');
            $model->setField('price', $model->price);

            $model->setField('but_checkout', 'payment');
            // здесь статус created заказ получит после успешной оплаты

        }else { // $type_button = reservation,

            if(Yii::$app->user->identity == null) {
                return [
                    'success' => false,
                    'action' => 'need_auth'
                ];
            }

            $model->price = $model->getCalculatePrice('unprepayment');
            $model->setField('price', $model->price);

            $model->setField('but_checkout', 'reservation');
            //$model->setField('status', 'created');
            $model->setField('status', 'created_with_time_confirm');
        }

        return [
            'success' => true
        ];
    }


    /**
     * @param $c
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionFinishOrder($c) {

        // Yii::$app->controller->layout = 'main_page2';

        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        if(empty($model->status)) {
            // $model->setField('status', 'created');
            $model->setField('status', 'created_with_time_confirm');
        }


        return $this->render('finish-order', [
            'model' => $model,
        ]);
    }


    public function actionTest() {

//        Yii::$app->controller->layout = false;

//        $password = '123456';
//        $model = User::find()->where(['id' => 1])->one();
//        if($model->validatePassword($password)) {
//            echo "совпадение";
//        }else {
//            echo "не совпадение";
//        }

//        echo date("d.m.Y", 1570741200).'<br />';
//        echo date("d.m.Y", 1569272400).'<br />';
//        echo date("d.m.Y", 1571000400).'<br />';
//        $registration_code = 'qqq';
//
//        return $this->render('email-test', [
//            'registration_url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/confirm-registration/?registration_code='.$registration_code,
//            'site' => $_SERVER['HTTP_HOST'],
//            'email' => 'vlad.shetinin@gmail.com',
//            'phone' => '+7(966) 112-80-06',
//
//        ]);

//        $db_mobile_phone = '+7-903-562-1779';
//
//        //Call::makeCallForwarding($db_mobile_phone);
//        Call::deleteCallForwarding($db_mobile_phone);

        echo 'siteUrl='.Yii::$app->params['siteUrl'];
    }

    public function actionTest2() {

//        $message = Yii::$app->mailer->compose();
//        $message->attach('/images/417.gif');

//        Yii::$app->mailer->compose('registration_code', [
//            'registration_url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/confirm-registration/',
//            'site' => $_SERVER['HTTP_HOST']
//        ])
//            ->setFrom(\Yii::$app->params['callbackEmail'])
//            ->setBcc(\Yii::$app->params['fromEmail'])
//            //->setTo('vlad.shetinin@gmail.com')
//            ->setTo('nara-dress@yandex.ru')
//            ->setSubject('Регистрационный код')
//            //->setTextBody('Текст сообщения')
//            //->setHtmlBody('<b>текст сообщения в формате HTML</b>')
//            ->send();


        $message = Yii::$app->mailer->compose();
        $message->setFrom(\Yii::$app->params['callbackEmail']);
        $message->setTo('nara-dress@yandex.ru');
        $message->setSubject('Регистрационный код');
        $message->setHtmlBody(Yii::$app->mailer->render('registration_code', [
            'registration_url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/confirm-registration/',
            'site' => $_SERVER['HTTP_HOST'],
            'img' => $message->embed('http://tobus-client.ru/images/417.gif'),
            'email' => 'vlad.shetinin@gmail.com',
            'phone' => '+7(966) 112-80-06',
        ]));

        return $message->send();


        return true;
    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->rememberMe = 1;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAjaxLogout()
    {
        Yii::$app->response->format = 'json';

        Yii::$app->user->logout();

        return [
            'success' => true
        ];
    }



    // возвращается форма ввода телефона при входе или регистрации
    public function actionAjaxGetLoginForm($c = 0, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $settings = Setting::find()->where(['id' => 1])->one();

        $model = new InputPhoneForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->mobile_phone = InputPhoneForm::convertWebToDBMobile($model->mobile_phone);

            $user = User::find()->where(['phone' => $model->mobile_phone])->one();
            if( is_null($user) ):

                // пользователь не зарегистрирован
                $next_step = 'confirm_phone';
                $current_reg = CurrentReg::find()->where(['mobile_phone' => $model->mobile_phone])->one();
                if($current_reg == null) {

                    $current_reg = new CurrentReg();
                    $current_reg->mobile_phone = $model->mobile_phone;
                    $current_reg->access_code = $current_reg->generateAccessCode();

                    if(!$current_reg->save(false)) {
                        throw new ForbiddenHttpException('Не удалось сохранить регистрацию');
                    }

                } else {

                    if( $current_reg->is_confirmed_mobile_phone ):
                        $next_step = 'registration';
                    endif;

                    if(empty($current_reg->access_code)) {
                        $current_reg->access_code = $current_reg->generateAccessCode();
                        $current_reg->setField('access_code', $current_reg->access_code);
                    }

                }

                return [
                    'success' => true,
                    'next_step' => $next_step,
                    'user_phone' => $model->mobile_phone,
                    'access_code' => $current_reg->access_code
                ];

            else:

                // открывать форму2 "Введите пароль".
                return [
                    'success' => true,
                    'next_step' => 'insert_password',
                    'user_phone' => $model->mobile_phone
                ];

            endif;

            // return [
            //     'success' => false,
            //     'inputphoneform_errors' => $current_reg
            // ];

            // // если ли такой пользователь и верифицирован ли email, если такой есть открывать форму2 "Введите пароль".
            // // если такого пользователя нет или у пользователя не верифицирован email, то открывается форма3 "Отправка смс с кодом для регистрации"
            // $user = User::find()->where(['phone' => $model->mobile_phone])->one();
            // if($user) {

            //     // принудительно отменяем подтверждение телефона - для тестов
            //     // $user->setField('phone_is_confirmed', false);

            //     // проверяем подтвержден ли телефон
            //     // if( !$user->phone_is_confirmed ):

            //         // открывать форму2 "Введите пароль".
            //         $next_step = 'insert_password';

            //     // else:

            //         // открываем форму call-авторизации
            //         // $next_step = 'confirm_phone';

            //     // endif;

            //     return [
            //         'success' => true,
            //         'next_step' => $next_step,
            //         'user_phone' => $model->mobile_phone
            //     ];

            // } else {

            //     // открывается форма3 "Отправка смс с кодом для регистрации"
            //     $next_step = 'registration';
            //     $current_reg = CurrentReg::find()->where(['mobile_phone' => $model->mobile_phone])->one();
            //     if($current_reg == null) {
            //         $current_reg = new CurrentReg();
            //         $current_reg->mobile_phone = $model->mobile_phone;
            //         $current_reg->access_code = $current_reg->generateAccessCode();

            //         if(!$current_reg->save(false)) {
            //             throw new ForbiddenHttpException('Не удалось сохранить регистрацию');
            //         }
            //     }else {
            //         if(empty($current_reg->access_code)) {
            //             $current_reg->access_code = $current_reg->generateAccessCode();
            //             $current_reg->setField('access_code', $current_reg->access_code);
            //         }
            //     }

            //     //$current_reg->generateAndSendSmsCode();

            //     // if(Call::makeCallForwarding($current_reg->mobile_phone)) { // теперь будет подверждение юзера по звонку на номер
            //     //     $current_reg->input_mobile_at = time();
            //     //     $current_reg->setField('input_mobile_at', $current_reg->input_mobile_at);
            //     // }

            //     return [
            //         'success' => true,
            //         'next_step' => $next_step,
            //         'access_code' => $current_reg->access_code,
            //     ];
            // }


        }else {

            return [
                'success' => false,
                'inputphoneform_errors' => $model->validate() ? '' : $model->getErrors(),
            ];

        }

    }

    // открывается форма ввода пароля при входе на сайте
    public function actionAjaxGetInsertPasswordForm($phone, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $model = User::find()->where(['phone' => '+'. trim($phone)])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Пользователь не найден');
        }


        $post = Yii::$app->request->post();
        if(count($post) > 0) {

            $model->scenario = 'login';

            // не пропускай rememberMe через модель, неправильно работает
            if ($model->load($post) && $model->validate()) {

                Yii::$app->user->login($model, $post['User']['rememberMe'] == true ? 31536000 : 0);

                return [
                    'success' => true,
                ];

            }else {
                return [
                    'success' => false,
                    'errors' => $model->validate() ? '' : $model->getErrors(),
                ];
            }

        }else {

            if($is_mobile == 0) {
                return [
                    'success' => true,
                    'html' => $this->renderAjax('step2-input-password', [
                        'model' => $model,
                    ])
                ];
            } else {
                return [
                    'success' => true,
                    'html' => $this->renderAjax('step2-input-password-mobile', [
                        'model' => $model,
                    ])
                ];
            }
        }
    }

    public function actionAjaxGetConfirmPhoneForm($user_phone, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $number = str_replace('-', '', $user_phone);
        $number = substr($number, -10);
        $reg_number = '9674660000';
        $reg_number_pretty = '+7 (967) 466-00-00';
        $reg_time_limit = 60;

        if($is_mobile == 0) {
            return [
                'success' => true,
                'html' => $this->renderAjax('step3-confirm-phone', [
                    'reg_number' => $reg_number,
                    'reg_number_pretty' => $reg_number_pretty
                ]),
                'number' => $number,
                'reg_number' => $reg_number,
                'reg_time_limit' => $reg_time_limit
            ];
        } else {
            return [
                'success' => true,
                'html' => $this->renderAjax('step3-confirm-phone-mobile', [
                    'reg_number' => $reg_number,
                    'reg_number_pretty' => $reg_number_pretty
                ]),
                'number' => $number,
                'reg_number' => $reg_number,
                'reg_time_limit' => $reg_time_limit
            ];
        }

    }


    // возвращается форма для ввода кода полученного в смс
    public function actionAjaxGetInputCodeForm($c, $client_ext_id, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $model = CurrentReg::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Регистрация не найдена');
        }

        $client_ext = null;
        if($client_ext_id > 0) {
            $client_ext = ClientExt::find()->where(['id' => intval($client_ext_id)])->one();
            if($client_ext == null) {
                throw new ForbiddenHttpException('Заказ не найден');
            }
        }

        if($is_mobile == 0) {
            return [
                'success' => true,
                'html' => $this->renderAjax('step3-input-code', [
                    'model' => $model,
                    'client_ext' => $client_ext
                ])
            ];
        }else {
            return [
                'success' => true,
                'html' => $this->renderAjax('step3-input-code-mobile', [
                    'model' => $model,
                    'client_ext' => $client_ext
                ])
            ];
        }
    }

//    public function actionAjaxGetRegistrationForm($c) {
//
//        Yii::$app->response->format = 'json';
//
//        $model = CurrentReg::find()->where(['access_code' => $c])->one();
//        if($model == null) {
//            throw new ForbiddenHttpException('Регистрация не найдена');
//        }
//
//        return [
//            'success' => true,
//            'html' => $this->renderAjax('step3-input-code.php', [
//                'model' => $model,
//            ])
//        ];
//    }


    // возвращается форма для ввода электронной почты и пароля при регистрации
    public function actionAjaxGetInputEmailPasswordForm($c, $client_ext_id, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $model = CurrentReg::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Регистрация не найдена');
        }

        $client_ext = null;
        if($client_ext_id > 0) {
            $client_ext = ClientExt::find()->where(['id' => intval($client_ext_id)])->one();
            if($client_ext == null) {
                throw new ForbiddenHttpException('Заказ не найден');
            }
        }



        if(count($_POST) > 0) {

            $model->scenario = 'end_registration';
            if ($model->load(Yii::$app->request->post())
                && $model->validate()
                && $model->generateRegistrationCode()
                && $model->sendRegistrationCode()
                && $model->save(false)) {

                if(empty($model->fio) && $client_ext != null) {
                    $model->setField('fio', $client_ext->fio);
                }

                // - создается пользователь или для найденного по телефону пользователю устанавливаются email и пароль
                // - и на почту должна быть отправлена ссылка для подтверждения
                // - пользователь должен быть автоматически авторизован на сайте
                $user = User::find()->where(['phone' => $model->mobile_phone])->one();
                if($user != null) {
                    $user->email = $model->email;
                    $user->setPassword($model->password);
                    if(empty($user->fio) && $client_ext != null) {
                        $user->fio = $client_ext->fio;
                    }
                    if(!$user->save(false)) {
                        throw new ForbiddenHttpException('Не удалось сохранить пользователя');
                    }

                }else {
                    $user = new User();
                    $user->phone = $model->mobile_phone;
                    $user->email = $model->email;
                    $user->setPassword($model->password);
                    if(empty($user->fio) && $client_ext != null) {
                        $user->fio = $client_ext->fio;
                    }
                    if(!$user->save(false)) {
                        throw new ForbiddenHttpException('Не удалось сохранить пользователя');
                    }
                }

                Yii::$app->user->login($user, 31536000);


                return [
                    'success' => true,
                ];

            }else {
                return [
                    'success' => false,
                    'errors' => $model->validate() ? '' : $model->getErrors(),
                ];
            }

        }else {


            if($client_ext != null && empty($model->email)) {
                $model->email = $client_ext->email;
            }

            if($is_mobile == 0) {
                return [
                    'success' => true,
                    'html' => $this->renderAjax('step4-input-email-password', [
                        'model' => $model,
                        'client_ext' => $client_ext
                    ])
                ];
            }else {
                return [
                    'success' => true,
                    'html' => $this->renderAjax('step4-input-email-password-mobile', [
                        'model' => $model,
                        'client_ext' => $client_ext,
                        'reg_code' => $c
                    ])
                ];
            }
        }
    }

    // запрос на повторую отправку кода в смс
    public function actionAjaxResendCode($c, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $model = CurrentReg::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Регистрация не найдена');
        }

        $model->generateAndSendSmsCode();

        return [
            'success' => true
        ];
    }

    // проверка кода переданного в смс
    public function actionAjaxCheckCode($c, $sms_code, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $model = CurrentReg::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Регистрация не найдена');
        }

        if($model->sms_code == trim(htmlspecialchars($sms_code))) {

            $model->setField('is_confirmed_mobile_phone', true);

            return [
                'success' => true,
            ];
        }else {
            return [
                'success' => false,
                'error' => 'Код не верен',
                'available_sms_count' => (CurrentReg::$max_sms_count - $model->count_sended_sms)
            ];
        }
    }


    public function actionAjaxGetRestorePasswordForm($phone, $is_mobile = 0) {

        Yii::$app->response->format = 'json';

        $phone = trim($phone);
        if(substr($phone, 0, 1) != '+') {
            $phone = '+' . $phone;
        }

        $user = User::find()->where(['phone' => $phone])->one();
        if($user == null) {
            throw new ForbiddenHttpException('Пользователь не найден');
        }

        // отправляем на почту ссылку для доступа на сайт
        if($user->generateRestoreCode() && $user->save(false) && $user->sendRestoreCode()) {
            //return; // + stasus 200 by default

            if($is_mobile == 0) {
                return [
                    'success' => true,
                    'html' => $this->renderAjax('restore-password-message')
                ];
            }else {
                return [
                    'success' => true,
                    'html' => $this->renderAjax('restore-password-message-mobile', [
                        'phone' => $phone,
                    ])
                ];
            }

        }else {
            throw new ErrorException('Не удалось сгенерировать и отправить код восстановления доступа');
        }
    }



/*
    public function actionAjaxGetStartRegistrationForm()
    {
        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        if(count($post) > 0)
        {
//            $user = User::find()->where(['phone' => $post['mobile_phone']])->one();
//            if($user != null) {
//                throw new ForbiddenHttpException('Пользователь с таким телефоном уже был зарегистрирован');
//            }

            $current_reg = CurrentReg::find()
                ->where(['mobile_phone' => $post['mobile_phone']])
                ->one();
//            if($current_reg != null) {
//                throw new ForbiddenHttpException('Запрос на регистрацию с такой почтой или телефоном уже отправлен');
//            }
            if($current_reg == null) {
                $current_reg = new CurrentReg();
                $current_reg->mobile_phone = $post['mobile_phone'];
            }

            $current_reg->scenario = 'start_registration';
            if (
                $current_reg->validate()
                && $current_reg->save()
            ) {
                // ищем этот email среди существующих пользователей, и
                // если найден пользователь, то отправляется СМС с 4-х значным кодом
                $user = User::find()->where(['phone' => $current_reg->mobile_phone])->one();
                if($user == null) {
                    return [
                        'success' => true,
                        'html' => $this->renderAjax('end-registration.php', [
                            'model' => $current_reg,
                        ])
                    ];
                }else {

                    if($current_reg->count_sended_sms >= 3) {

                        if(time() - $current_reg->sended_sms_code_at < 3600) {
                            $current_reg->setField('sms_code', ''); // удаляется код чтобы повторно программно не подбирался код
                            $show_error = 'Нельзя запрашивать смс с кодом доступа более 3-х раз подряд. Запросить новый код можно будет '.date('d.m.Y H:i', $current_reg->sended_sms_code_at + 3600);
                            return [
                                'success' => true,
                                'html' => $this->renderAjax('check-registration-code.php', [
                                    'model' => $current_reg,
                                    'show_error' => $show_error
                                ])
                            ];
                        }else {
                            $current_reg->count_sended_sms = 0;
                            $current_reg->setField('count_sended_sms', 0);
                        }
                    }

                    $current_reg->generateAndSendSmsCode();

//                    $current_reg->sms_code = CurrentReg::generateCode();
//                    $to = str_replace('+7', '', $current_reg->mobile_phone);
//                    $to = str_replace('-', '', $to);
//                    $text = 'Проверочный код: '.$current_reg->sms_code;
//                    Sms::send($to, $text);

//                    $current_reg->sended_sms_code_at = time();
//                    $current_reg->count_sended_sms = intval($current_reg->count_sended_sms) + 1;
//                    $current_reg->scenario = 'send_sms_code';
//                    if(!$current_reg->save(false)) {
//                        throw new ForbiddenHttpException('Не удалось отправить смс с проверочным кодом');
//                    }

                    return [
                        'success' => true,
                        'html' => $this->renderAjax('check-registration-code.php', [
                            'model' => $current_reg,
                        ])
                    ];
                }

            }else {

                return [
                    'success' => false,
                    'currentreg_errors' => $current_reg->validate() ? '' : $current_reg->getErrors(),
                    'current_reg' => $current_reg
                ];
            }

        }else {

            $current_reg = new CurrentReg();

            return [
                'success' => true,
                'html' => $this->renderAjax('start-registration.php', [
                    'model' => $current_reg,
                ])
            ];
        }
    }


    public function actionAjaxSendSmsWithCode() {

        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        $current_reg = CurrentReg::find()
            ->where(['mobile_phone' => $post['mobile_phone']])
            ->one();
        if($current_reg == null) {
            throw new ForbiddenHttpException('Запрос на регистрацию с таким телефоном не найден');
        }

        $current_reg->generateAndSendSmsCode();

        return [
            'success' => true
        ];
    }


    public function actionAjaxCheckRegistrationCode()
    {
        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        if(count($post) > 0)
        {
            $current_reg = CurrentReg::find()->where(['mobile_phone' => $post['mobile_phone']])->one();
            if($current_reg == null) {
                throw new ForbiddenHttpException('Запрос на регистрацию не найден');
            }


            if(empty($current_reg->sms_code) && $current_reg->count_sended_sms > 0) {
                throw new ErrorException('Смс код отсутствует.');
            }

            $check_code = trim($post['check_code']);
            if($check_code != $current_reg->sms_code) {

                $current_reg->setField('sms_code', ''); // удаляется код чтобы повторно программно не подбирался код
                $current_reg->setField('is_confirmed_mobile_phone', false);

                if($current_reg->count_sended_sms >= 3) {

                    if(time() - $current_reg->sended_sms_code_at < 3600) {
                        $current_reg->setField('sms_code', ''); // удаляется код чтобы повторно программно не подбирался код
                        $aErrors['check_code'][] = 'Нельзя запрашивать смс с кодом доступа более 3-х раз подряд. Запросить новый код можно будет '.date('d.m.Y H:i', $current_reg->sended_sms_code_at + 3600);
                        //$aErrors['check_code'][] = (time() - $current_reg->sended_sms_code_at);
                        return [
                            'success' => false,
                            'currentreg_errors' => $aErrors,
                            'current_reg' => $current_reg
                        ];
                    }else {
                        $current_reg->count_sended_sms = 0;
                        $current_reg->setField('count_sended_sms', 0);
                    }

                }else {

                    $aErrors['check_code'][] = 'Неправильный код';
                    return [
                        'success' => false,
                        'update_send_button' => true,
                        'currentreg_errors' => $aErrors,
                        'current_reg' => $current_reg
                    ];
                }
            }else {

                $current_reg->setField('is_confirmed_mobile_phone', true);

                $user = User::find()->where(['phone' => $current_reg->mobile_phone])->one();
                if($user != null) {
                    $current_reg->fio = $user->fio;
                    $current_reg->email = $user->email;
                }

                // здесь должна быть также история поездок
                return [
                    'success' => true,
                    'html' => $this->renderAjax('end-registration.php', [
                        'model' => $current_reg,
                    ])
                ];
            }

        }else {

            $current_reg = new CurrentReg();

            return [
                'success' => true,
                'html' => $this->renderAjax('end-registration.php', [
                    'model' => $current_reg,
                ])
            ];
        }
    }


    public function actionAjaxGetEndRegistrationForm()
    {
        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        if(count($post) > 0)
        {
            $current_reg = CurrentReg::find()->where(['mobile_phone' => $post['mobile_phone']])->one();
            if($current_reg == null) {
                throw new ForbiddenHttpException('Запрос на регистрацию не найден');
            }
            $current_reg->scenario = 'end_registration';

            $current_reg->email = $post['email'];
            $current_reg->fio = $post['fio'];
            $current_reg->password = $post['password'];
            $current_reg->confirm_password = $post['confirm_password'];


            if (
                //$current_reg->load($post)
                $current_reg->validate()
//                && $current_reg->generateRegistrationCode()
//                && $current_reg->sendRegistrationCode()
                && $current_reg->save()
                && $current_reg->createOrUpdateUser()
            ) {
                return [
                    'success' => true,
                ];

            }else {

                return [
                    'success' => false,
                    'currentreg_errors' => $current_reg->validate() ? '' : $current_reg->getErrors(),
                    'current_reg' => $current_reg
                ];
            }

        }else {

            $current_reg = new CurrentReg();

            return [
                'success' => true,
                'html' => $this->renderAjax('end-registration.php', [
                    'model' => $current_reg,
                ])
            ];
        }
    }
*/

/*
    public function actionAjaxGetRegistrationForm()
    {
        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        if(count($post) > 0)
        {
            $user = User::find()->where(['email' => $post['CurrentReg']['email']])->one();
            if($user != null) {
                throw new ForbiddenHttpException('Пользователь с такой почтой уже существует');
            }
            $user = User::find()->where(['phone' => $post['CurrentReg']['mobile_phone']])->one();
            if($user != null) {
                throw new ForbiddenHttpException('Пользователь с таким телефоном уже существует');
            }

            $current_reg = CurrentReg::find()
                ->where(['email' => $post['CurrentReg']['email']])
                ->orWhere(['mobile_phone' => $post['CurrentReg']['mobile_phone']])
                ->one();
            if($current_reg != null) {
                throw new ForbiddenHttpException('Запрос на регистрацию с такой почтой или телефоном уже отправлен');
            }

            $current_reg = new CurrentReg();
            if (
                $current_reg->load($post)
                && $current_reg->validate()
                && $current_reg->generateRegistrationCode()
                && $current_reg->sendRegistrationCode()
                && $current_reg->save()
            ) {
                //return; // + stasus 200 by default
                //return $this->goHome();
                return [
                    'success' => true,
                ];

            }else {

                return [
                    'success' => false,
                    'currentreg_errors' => $current_reg->validate() ? '' : $current_reg->getErrors(),
                    'current_reg' => $current_reg
                ];
            }

        }else {

            $current_reg = new CurrentReg();

            return [
                'success' => true,
                'html' => $this->renderAjax('registration.php', [
                    'model' => $current_reg,
                ])
            ];
        }

    }
*/

/*
    public function actionAjaxGetRestorePasswordForm()
    {
        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        if(count($post) > 0)
        {
            $user = User::find()->where(['email' => $post['RestorePasswordForm']['email']])->one();
            if($user == null) {
                throw new ForbiddenHttpException('Пользователь с такой почтой не найден');
            }

            $restore_password = new RestorePasswordForm();
            if(
                $restore_password->load($post)
                && $user->generateRestoreCode()
                && $user->save(false)
                && $user->sendRestoreCode()
            ) {
                return [
                    'success' => true,
                ];

            }else {

                return [
                    'success' => false,
                    'restorepassword_errors' => $restore_password->validate() ? '' : $restore_password->getErrors(),
                ];
            }

        }else {

            $restore_password = new RestorePasswordForm();

            return [
                'success' => true,
                'html' => $this->renderAjax('restore-password', [
                    'model' => $restore_password,
                ])
            ];
        }
    }
*/

    // открытие и submit формы изменение пароля
    public function actionAjaxGetChangePasswordForm()
    {
        Yii::$app->response->format = 'json';

        $post = Yii::$app->request->post();
        if(count($post) > 0)
        {
            $user = Yii::$app->user->identity;
            if($user == null) {
                throw new ErrorException('Пользователь не найден');
            }
            $user->scenario = 'set_password';


            $change_password_password = new ChangePasswordForm();
            if(
                $change_password_password->load($post)
                && $user->setPassword($change_password_password->new_password)
                && $user->save(false)
            ) {
                return [
                    'success' => true,
                ];

            }else {

                return [
                    'success' => false,
                    'changepassword_errors' => $change_password_password->validate() ? '' : $change_password_password->getErrors(),
                ];
            }

        }else {

            $change_password_password = new ChangePasswordForm();

            return [
                'success' => true,
                'html' => $this->renderAjax('change-password', [
                    'model' => $change_password_password,
                ])
            ];
        }
    }

}
