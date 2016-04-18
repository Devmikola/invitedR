<?php

namespace app\controllers;

use app\models\City;
use app\models\Invite;
use Yii;
use app\models\SignUpForm;
use yii\web\Response;
use app\models\User;
use yii\widgets\ActiveForm;

class UserController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new SignUpForm(['scenario' => 'user_create']);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if($model->validate()) {

                $user = new User();
                $user->login = $model->login;
                $user->password_hash = $model->password;
                $user->phone = preg_replace('/\D/', '', $model->phone);
                $user->invite_id = $model->invite_id;
                $user->city_id = $model->city;
                if($user->save())
                {
                    $invite = Invite::findOne($user->invite_id);
                    $invite->status = true;
                    $invite->date_activation = date("Y-m-d H:i:s");

                    if($invite->update())
                    {
                        Yii::$app->session->getFlash('Регистрация прошла успешно');
                        return $this->redirect(['view', 'id' => $user->id]);
                    }
                }
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
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

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView()
    {
        Yii::$app->session->getFlash('Регистрация прошла успешно');
        return $this->render('view');
    }


}
