<?php

namespace app\controllers;

use app\module\admin\models\Followers;
use app\module\admin\models\Order;
use app\module\admin\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;
use app\module\admin\models\Config;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        $followers = new Followers();
        session_start();
        $followers->load(Yii::$app->request->post());

        $chech_followed = Followers::find()->where(['email' => $followers->email])->count();

        if ($chech_followed > 0) {
            $_SESSION['subscription'] = true;
            return $this->render('index', [
                'follower_id' => 1,
                'message' => (isset(Config::getConfig('followers', 'error_subscribe_message')->value) ? Config::getConfig('followers', 'error_subscribe_message')->value : 'Ви вже підписані на новинки і знижки'),
            ]);
        }else{
            $order = new Order();
            if ($followers->load(Yii::$app->request->post())) {
                $_SESSION['subscription'] = true;
                $followers->date_subscription = date('Y-m-d H:i');
                $followers->mailing = 1;
                $followers->save();
                foreach (User::getAdminEmails() as $to) $order->sendEmail($to, 'В LoungeStore Markaua Появился новый подписчик', $followers->fio . ' - ' . $followers->email);
                return $this->render('index', [
                    'follower_id' => $followers->id,
                    'message' => (isset(Config::getConfig('followers', 'after_subscribe_message')->value) ? Config::getConfig('followers', 'after_subscribe_message')->value : 'Дякуємо за те, що обрали саме нас!'),
                ]);
            } else {
                if (isset($_SESSION['subscription'])) {
                    return $this->render('index');
                } else {
                    return $this->render('index', [
                        'followers' => $followers,
                        'message' => (isset(Config::getConfig('followers', 'subscribe_message')->value) ? Config::getConfig('followers', 'subscribe_message')->value : 'Заповни просту анкету, якщо хочеш отримувати інформацію про новинки і знижки в нашому дівочому раю.'),
                    ]);
                }
            }
        }
    }




    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->render($this->goHome());
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->render($this->goHome());
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

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionWoman()
    {
        return $this->render('woman');
    }
}
