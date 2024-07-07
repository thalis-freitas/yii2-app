<?php

namespace frontend\controllers;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;
use common\components\ModelUploader;

class ProductsController extends ActiveController
{
    public $modelClass = Product::class;

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
        $product = new Product();

        $productData = \Yii::$app->request->post();

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($this->uploader->loadAndValidateModel($product, $productData)) {
                $this->uploader->saveModelWithPhoto($product);
                $transaction->commit();
                return $product;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        throw new UnprocessableEntityHttpException(json_encode($product->errors));
    }
}
