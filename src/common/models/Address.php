<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property int $id
 * @property string $zip_code
 * @property string $street
 * @property string $number
 * @property string $city
 * @property string $state
 * @property string|null $complement
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Customer[] $customers
 */
class Address extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        return ['id', 'zip_code', 'street', 'number', 'city', 'state', 'complement'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zip_code', 'street', 'number', 'city', 'state'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['zip_code', 'street', 'number', 'city', 'state', 'complement'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zip_code' => 'Zip Code',
            'street' => 'Street',
            'number' => 'Number',
            'city' => 'City',
            'state' => 'State',
            'complement' => 'Complement',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CustomerQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['address_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AddressQuery(get_called_class());
    }
}
