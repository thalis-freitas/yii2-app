<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\traits\PhotoUploadTrait;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string|null $photo
 * @property int $customer_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Customer $customer
 */
class Product extends ActiveRecord
{
    use PhotoUploadTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        $fields = ['id', 'name', 'price', 'photo', 'customer'];

        $fields['photo'] = function ($model) {
            if ($model->photo) {
                return Yii::$app->request->hostInfo . '/' . $model->photo;
            }
            return null;
        };

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'customer_id'], 'required'],
            [['price'], 'number'],
            [['customer_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'photo' => 'Photo',
            'customer_id' => 'Customer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CustomerQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }
}
