<?php

namespace app\module\admin;
use Yii;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\module\admin\controllers';

    public function init()
    {
        if (Yii::$app->user->getRole() == 'admin') {
            parent::init();
        }
        // custom initialization code goes here
    }
}
