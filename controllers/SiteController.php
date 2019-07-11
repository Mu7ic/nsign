<?php

namespace app\controllers;

use app\models\Bluda;
use app\models\Ingredient;
use app\models\TableBlud;
use Symfony\Component\Console\Helper\Table;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $ing=Ingredient::findAll(['status'=>1]);
        $msg="";
        if(isset($_POST['checkbox'])){
             $array=$_POST['checkbox'];
             //var_dump(count($array));
            if(count($array)<2) {
                $msg = "Выберите больше ингредиентов";
                return $this->render('about', ['ing' => $ing, 'msg' => $msg]);
            }
            $check=$this->check($array);
            if($check!=null){
                var_dump(count($array));
                return $this->render('about', ['ing' => $ing, 'dishes' => $check]);
            } else{
                $msg = "Ничего не найдено";
                return $this->render('about', ['ing' => $ing, 'msg' => $msg]);
            };
        }else
        return $this->render('about',['ing'=>$ing]);
    }

    public function check($array){
        $implode=implode(',',$array);
        //var_dump($implode);
        $query="SELECT id_bluda,COUNT(`int`) AS count FROM table_blud WHERE id_ingredient IN(".$implode.") GROUP BY id_bluda ORDER BY count DESC";
        $res=TableBlud::findBySql($query)->all();
        $id_sovpadeniya="";
        $else="";
        if(empty($res))
            return NULL;
            else{
        foreach ($res as $r) {
            if($r->count==$this->getCountIng($r->id_bluda)){
                $id_sovpadeniya.=".".$r->id_bluda;
            }
        }
        $expl=explode('.', $id_sovpadeniya);
        //var_dump($id_sovpadeniya);
        $exp=array_slice($expl,1,count($expl)-1);

        if($exp!=null)
            return $this->getTable($exp);
        else
            return $this->getPartQuery($implode);
            }
    }

    public function getTable($in){
        return Bluda::find()->where(['in','id',$in])->all();
    }

    public function getCountIng($id_dish){
        echo $id_dish;
        return count(TableBlud::find()->where(['id_bluda'=>$id_dish])->all());
    }

    public function getPartQuery($implode){
        $query="SELECT bluda.`name` AS name,COUNT(table_blud.`int`) AS `count` FROM table_blud,bluda WHERE table_blud.id_ingredient IN(".$implode.") AND table_blud.id_bluda=bluda.id GROUP BY table_blud.id_bluda ORDER BY COUNT DESC";
         return TableBlud::findBySql($query)->all();
    }
}
