<?php

namespace common\traits;

use yii\web\UploadedFile;
use Yii;

trait PhotoUploadTrait
{
    public $photoFile;

    public function uploadPhoto()
    {
        if ($this->photoFile) {
            $filePath = Yii::getAlias('@webroot/uploads/photos/') . $this->photoFile->baseName . '.' . $this->photoFile->extension;
            if ($this->photoFile->saveAs($filePath)) {
                $this->photo = 'uploads/photos/' . $this->photoFile->baseName . '.' . $this->photoFile->extension;
                return true;
            }
            return false;
        }
        return true;
    }
}
