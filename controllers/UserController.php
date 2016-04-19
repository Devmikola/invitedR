<?php

namespace app\controllers;

use app\models\City;
use app\models\Invite;
use Yii;
use app\models\SignUpForm;
use yii\web\Response;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

class UserController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['create', 'cities'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        if (User::isAdmin(Yii::$app->user->getId())) {
                            return true;
                        }
                        return false;
                    }
                ],

            ],
        ],
    ];
    }

    public function actionCreate()
    {
        $model = new SignUpForm(['scenario' => 'user_create']);

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if(!Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user = new User();
            $user->login = $model->login;
            $user->password_hash = $model->password;
            $user->phone = preg_replace('/\D/', '', $model->phone);
            $user->invite_id = $model->invite_id;
            $user->city_id = $model->city;
            if($user->save()) {
                $invite = Invite::findOne($user->invite_id);
                $invite->status = true;
                $invite->date_activation = date("Y-m-d H:i:s");

                if ($invite->update()) {
                    Yii::$app->session->setFlash('success', 'Регистрация прошла успешно');
                    return $this->redirect(['view', 'id' => $user->id]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCities($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $cities = City::find()->where(['country_id' => $id])->orderBy('id DESC')->all();
        $cities_list = '';

        if(count($cities) > 0) {
            foreach($cities as $city) {
                $cities_list .= "<option value='".$city->id."'>".$city->name."</option>";
            }
        }

        return ['cities_list' => $cities_list];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $model = User::findOne($id);
        if($model)
        {
            return $this->render('view', ['model' => $model]);
        } else {
            return $this->redirect('/');
        }
    }


}
