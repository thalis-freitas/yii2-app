<?php

namespace common\components;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\web\UnprocessableEntityHttpException;
use Yii;

class ModelUploader
{
    public function loadAndValidateModel(ActiveRecord $model, array $data)
    {
        $model->photoFile = UploadedFile::getInstanceByName('photo');
        return $model->load($data, '') && $model->validate();
    }

    public function saveModelWithPhoto(ActiveRecord $model)
    {
        if ($model->save()) {
            if ($model->uploadPhoto()) {
                $model->save(false);
                return true;
            } else {
                throw new \Exception('Failed to upload photo.');
            }
        } else {
            throw new \Exception(json_encode($model->errors));
        }
    }
}
