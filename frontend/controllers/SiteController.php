<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
			 'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],

        ];
    }

	public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        //echo '<pre>';print_r($attributes);echo '</pre>';die;
        
        if($_GET['authclient']=='google'){
            $attributes['email']=$attributes['emails'][0]['value'];
        }
        $user = User::find()->where(['email'=>$attributes['email']])->one();
        
        if(!empty($user)){
            Yii::$app->user->login($user);
            $loginId = Yii::$app->user->id;
            Yii::$app->session->set('loginId',$loginId);    
            
        }else{
            
           if($_GET['authclient']=='google'){
                
                $email= $attributes['email'];
                $username = $attributes['displayName'];
                $name = explode(" ", $username);
                $first_name = $name[0];
                $last_name = $name[1];
                
            }else{
                
                $email= $attributes['email'];
                $username = $attributes['name'];
                $name = explode(" ", $username);
                $first_name = $name[0];
                $last_name = $name[1];
            }
            
            $model= new User();
            $model->setAttribute('first_name',$first_name);
            $model->setAttribute('last_name',$last_name);
            $model->setAttribute('email',$email);
            $model->setAttribute('username',$email);
            $model->setAttribute('user_type','customer');
            $model->setAttribute('status',10);
            //$model->setAttribute('created_at',date('Y-m-d h:i:s'));
            //$model->setAttribute('updated_at',date('Y-m-d h:i:s'));
            
            if($model->save()){
                $user = User::find()->where(['email'=>$email])->one();
                Yii::$app->user->login($user);
                $loginId = Yii::$app->user->id;
                Yii::$app->session->set('loginId',$loginId);    
                $this->ThankYouEmail($email,$loginId);
                $this->RegUserNotifyAdmin($first_name,$last_name);
            }
        }
        //echo '<pre>';print_r($attributes);echo '</pre>';die;
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
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
        } else {
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
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } else {
				//echo ":<pre>"; print_r( $user->errors ); die;
			}
        } else {
			//echo "<pre>"; print_r( $model->errors ); die;
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
