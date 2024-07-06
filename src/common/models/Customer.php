<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string $name
 * @property string $registration_number
 * @property string|null $photo
 * @property string|null $gender
 * @property int|null $address_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Address $address
 * @property Product[] $products
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'registration_number', 'created_at', 'updated_at'], 'required'],
            [['address_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'registration_number', 'photo', 'gender'], 'string', 'max' => 255],
            [['registration_number'], 'unique'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
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
            'registration_number' => 'Registration Number',
            'photo' => 'Photo',
            'gender' => 'Gender',
            'address_id' => 'Address ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AddressQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['customer_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CustomerQuery(get_called_class());
    }
}
