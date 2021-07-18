<?php

namespace backend\controllers;

use common\models\Product;
use common\models\Property;
use common\models\PropertyValue;
use Yii;
use common\models\ProductProperty;
use common\models\ProductPropertySearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductPropertyController implements the CRUD actions for ProductProperty model.
 */
class ProductPropertyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductProperty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPropertySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductProperty model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductProperty();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $query1 = Product::find()->all();
        $query2 = Property::find()->all();
        $query3 = PropertyValue::find()->all();

        $products = ArrayHelper::map($query1, 'id', 'name');
        $properties = ArrayHelper::map($query2, 'id', 'name');
        $property_values = ArrayHelper::map($query3, 'id', 'value');

        return $this->render('create', compact('model', 'products', 'properties', 'property_values'));
    }

    /**
     * Updates an existing ProductProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $query1 = Product::find()->all();
        $query2 = Property::find()->all();
        $query3 = PropertyValue::find()->all();

        $products = ArrayHelper::map($query1, 'id', 'name');
        $properties = ArrayHelper::map($query2, 'id', 'name');
        $property_values = ArrayHelper::map($query3, 'id', 'value');

        return $this->render('update', compact('model', 'products', 'properties', 'property_values'));
    }

    /**
     * Deletes an existing ProductProperty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductProperty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
