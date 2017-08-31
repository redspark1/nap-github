<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\UploadForm;
use yii\web\UploadedFile;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'profile'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginSysAdmin()) {
            return $this->goBack();
        } else {
			//echo "<pre>"; print_r( $model->errors ); die;
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	public function actionProfile()
	{
		$model = \common\models\User::findOne([ 'id' => Yii::$app->user->id ]);
		$modelUpload = new UploadForm();
        if ($model->load(Yii::$app->request->post())) {
			/* profile image upload st */
			$modelUpload->profile_image = UploadedFile::getInstance($modelUpload, 'profile_image');
			if (  $modelUpload->profile_image &&  $filename = $modelUpload->upload() ) {
				$model->profile_image = $filename;
			}
			/* profile image upload en */
			
			if( $model->save() )
			{
				
			}
            return $this->redirect(['profile']);
        } else {
            return $this->render( 'profile', [ 'model' => $model, 'modelUpload'=>$modelUpload ]);
        }
	}
}