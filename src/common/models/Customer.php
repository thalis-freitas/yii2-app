<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\traits\PhotoUploadTrait;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string $name
 * @property string $registration_number
 * @property string|null $photo
 * @property string|null $gender
 * @property int|null $address_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Address $address
 * @property Product[] $products
 */
class Customer extends ActiveRecord
{
    use PhotoUploadTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        return ['id', 'name', 'registration_number', 'photo', 'address'];
    }

    public function extrafields()
    {
        return ['products'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'registration_number'], 'required'],
            [['address_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'registration_number', 'photo', 'gender'], 'string', 'max' => 255],
            [['registration_number'], 'unique'],
            [['registration_number'], 'validateCpf'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
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

    public function validateCpf($attribute, $params)
    {
        $cpf = $this->$attribute;

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (!$this->hasValidLength($cpf)) {
            $this->addError($attribute, 'Registration number must have 11 digits');
            return;
        }

        if ($this->hasAllSameDigits($cpf) || !$this->isValidCpf($cpf)) {
            $this->addError($attribute, 'Invalid registration number');
            return;
        }
    }

    private function hasValidLength($cpf)
    {
        return strlen($cpf) == 11;
    }

    private function hasAllSameDigits($cpf)
    {
        return preg_match('/(\d)\1{10}/', $cpf);
    }

    private function isValidCpf($cpf)
    {
        if ($cpf[9] != $this->calculateVerifierDigit($cpf, 9)) {
            return false;
        }

        return $cpf[10] == $this->calculateVerifierDigit($cpf, 10);
    }

    private function calculateVerifierDigit($cpf, $length)
    {
        $sum = 0;
        for ($i = 0; $i < $length; $i++) {
            $sum += $cpf[$i] * (($length + 1) - $i);
        }
        $remainder = $sum % 11;
        return ($remainder < 2) ? 0 : 11 - $remainder;
    }
}
