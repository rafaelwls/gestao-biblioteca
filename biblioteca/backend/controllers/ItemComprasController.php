<?php

namespace backend\controllers;

use common\models\Item_compras;
use backend\models\ItemComprasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemComprasController implements the CRUD actions for Item_compras model.
 */
class ItemComprasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Item_compras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ItemComprasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item_compras model.
     * @param string $compra_id Compra ID
     * @param string $exemplar_id Exemplar ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($compra_id, $exemplar_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($compra_id, $exemplar_id),
        ]);
    }

    /**
     * Creates a new Item_compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Item_compras();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'compra_id' => $model->compra_id, 'exemplar_id' => $model->exemplar_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item_compras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $compra_id Compra ID
     * @param string $exemplar_id Exemplar ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($compra_id, $exemplar_id)
    {
        $model = $this->findModel($compra_id, $exemplar_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'compra_id' => $model->compra_id, 'exemplar_id' => $model->exemplar_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Item_compras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $compra_id Compra ID
     * @param string $exemplar_id Exemplar ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($compra_id, $exemplar_id)
    {
        $this->findModel($compra_id, $exemplar_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item_compras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $compra_id Compra ID
     * @param string $exemplar_id Exemplar ID
     * @return Item_compras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($compra_id, $exemplar_id)
    {
        if (($model = Item_compras::findOne(['compra_id' => $compra_id, 'exemplar_id' => $exemplar_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
