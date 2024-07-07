<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;

class UserController extends Controller
{
    public function actionCreate($login, $password, $username)
    {
        $user = new User();
        $user->login = $login;
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            echo Yii::t('success', 'User {username} created successfully.', ['username' => $username]) . "\n";
        } else {
            echo Yii::t('error', 'Error creating user') . "\n";
            foreach ($user->errors as $error) {
                echo "- {$error[0]}\n";
            }
        }
    }
}
