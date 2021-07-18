<?php

namespace frontend\controllers\rest;

use common\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Response;

class BaseController extends ActiveController
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function init()
    {
        parent::init();

        \Yii::$app->user->enableSession = false;
    }

    /*
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formatParam' => '_format',
                'formats' => [
                    'application/xml' => Response::FORMAT_XML,
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    */

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = User::find()->where(['username' => $username])->one();
                if ($user->validatePassword($password)) {
                    return $user;
                }
                return null;
            }
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        return parent::actions();
    }
}
