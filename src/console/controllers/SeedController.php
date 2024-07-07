<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Gender;

class SeedController extends Controller
{
    public function actionGender()
    {
        $genders = [
            Gender::FEMALE,
            Gender::MALE,
            Gender::NON_BINARY,
            Gender::OTHER,
        ];

        foreach ($genders as $gender) {
            $model = new Gender();
            $model->name = $gender;
            if ($model->save()) {
                echo "Inserted {$gender}\n";
            } else {
                echo "Failed to insert {$gender}\n";
            }
        }
    }
}
