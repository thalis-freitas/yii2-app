<?php

namespace common\traits;

use yii\web\UploadedFile;
use Yii;

trait PhotoUploadTrait
{
    public $photoFile;

    public function uploadPhoto()
    {
        $path = 'assets/uploads/photos/';
        $directory = Yii::getAlias('@webroot/' . $path);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if ($this->photoFile) {
            $filePath = $directory . $this->photoFile->baseName . '.' . $this->photoFile->extension;
            if ($this->photoFile->saveAs($filePath)) {
                $this->photo = $path . $this->photoFile->baseName . '.' . $this->photoFile->extension;
                return true;
            }
            return false;
        }
        return true;
    }
}
