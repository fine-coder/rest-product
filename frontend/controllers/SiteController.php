<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Product;
use common\models\ProductProperty;
use common\models\Property;
use common\models\PropertyValue;
use common\models\User;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = Category::find()->orderBy([
            'sort' => SORT_ASC
        ])->all();

        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param $url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($url)
    {
        if ($category = Category::findOne(['url' => $url])) {
            //$properties = $category->properties;

            $properties = Property::find()
                ->where(['category_id' => $category->id])
                ->with('propertyValues')
                ->all();

            /*
            $products = ProductProperty::find()
                ->joinWith(['product', 'property', 'propertyValue'])->where(['product.category_id' => $category->id])->orderBy(['product.name' => SORT_DESC])->asArray()->all();

            $products = ArrayHelper::map($products, 'property.name', 'propertyValue.value', 'product.name');
            */

            $products = Product::find()
                ->where(['category_id' => $category->id])
                ->with(['productProperties.property', 'productProperties.propertyValue'])
                ->asArray()
                ->all();

            return $this->render('category', compact('category', 'properties', 'products'));
        }

        throw new NotFoundHttpException('Ой, нет такой страницы');
    }

    /**
     * @param $url2
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProduct($url2)
    {
        $product = Product::find()
            ->where(['url' => $url2])
            ->with(['category', 'productProperties.property', 'productProperties.propertyValue'])
            ->one();

        if ($product) {
            return $this->render('product', [
                'product' => $product
            ]);
        }

        throw new NotFoundHttpException('Ой, нет такой страницы');
    }

    /**
     * Test.
     *
     * @return mixed
     */
    public function actionTest()
    {
        return $this->render('test');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
            //return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {

            $mail_to = User::findOne(['username' => 'admin'])->email;

            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setTo($mail_to)
                ->setSubject('На сайте зарегистрировались')
                //->setTextBody('Текст сообщения')
                ->setHtmlBody('Имя: '.$model->username.'<br>E-mail: '.$model->email)
                ->send();

            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию. Пожалуйста, проверьте свой почтовый ящик на наличие письма с подтверждением электронной почты.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль для предоставленной электронной почты.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Ваш адрес электронной почты был подтвержден!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'К сожалению, мы не можем подтвердить вашу учетную запись с помощью предоставленного токена.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'К сожалению, мы не можем повторно отправить проверочное письмо на указанную электронную почту.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
