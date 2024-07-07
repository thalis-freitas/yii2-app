<?php

namespace frontend\controllers;

use common\models\Address;
use common\models\Customer;
use common\components\ModelUploader;
use frontend\controllers\ApiController;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class CustomersController extends ApiController
{
    public $modelClass = Customer::class;

    private $uploader;

    public function __construct($id, $module, ModelUploader $uploader, $config = [])
    {
        $this->uploader = $uploader;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $customer = new Customer();
        $address = new Address();

        $customerData = \Yii::$app->request->post();
        $addressData = $customerData['address'] ?? [];

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($this->uploader->loadAndValidateModel($customer, $customerData) &&
                $address->load($addressData, '') && $address->validate()) {
                if ($this->saveModels($customer, $address)) {
                    $this->uploader->saveModelWithPhoto($customer);
                    $transaction->commit();
                    return $customer;
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        throw new UnprocessableEntityHttpException(json_encode(array_merge($customer->errors, $address->errors)));
    }

    private function saveModels($customer, $address)
    {
        if (!$address->save()) {
            throw new \Exception(json_encode($address->errors));
        }

        $customer->address_id = $address->id;
        if (!$customer->save()) {
            throw new \Exception(json_encode($customer->errors));
        }

        return true;
    }
}
