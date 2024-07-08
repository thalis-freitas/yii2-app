<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%gender}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Gender extends ActiveRecord
{
    const FEMALE = 'Female';
    const MALE = 'Male';
    const NON_BINARY = 'Non-binary';
    const OTHER = 'Other';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gender}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        $fields = ['id', 'name'];

        $fields['name'] = function () {
            return Yii::t('app', $this->name);
        };

        return $fields;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public static function getPredefinedGenders()
    {
        return [
            Yii::t('app', self::FEMALE),
            Yii::t('app', self::MALE),
            Yii::t('app', self::NON_BINARY),
            Yii::t('app', self::OTHER),
        ];
    }
}
