<?php

namespace frontend\controllers;

use Yii;
use yii\rest\Controller;
use common\models\LoginForm;
use yii\web\UnauthorizedHttpException;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->login()) {
            return [
                'token' => Yii::$app->user->identity->getAuthKey(),
                'user' => Yii::$app->user->identity->toArray(),
            ];
        } else {
            throw new UnauthorizedHttpException(Yii::t('error', 'Invalid login or password.'));
        }
    }
}
