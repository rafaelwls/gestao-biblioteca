<?php

namespace backend\controllers;

use common\models\PedidoEmprestimo;
use backend\models\PedidoEmprestimoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;

/**
 * PedidoEmprestimoController implements the CRUD actions for PedidoEmprestimo model.
 */
class PedidoEmprestimoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // 1) JWT Bearer Auth para todas as ações
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
        ];

        // 2) Controle de acesso: apenas usuários logados, e regras por ação
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                // qualquer usuário autenticado pode criar (pedido ou doação)
                [
                    'allow'   => true,
                    'actions' => ['create'],
                    'roles'   => ['@'],
                ],
                // só trabalhador/admin pode index/view/update/delete/resposta/aprovar
                [
                    'allow'   => true,
                    'actions' => ['index', 'view', 'update', 'delete', 'resposta', 'aprovar'],
                    'matchCallback' => function ($rule, $action) {
                        $u = Yii::$app->user->identity;
                        return $u->isTrabalhador() || $u->isAdmin();
                    },
                ],
            ],
        ];

        // 3) VerbFilter para métodos HTTP
        $behaviors['verbs'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'delete'   => ['POST'],
                'resposta' => ['POST'],
                'aprovar'  => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all PedidoEmprestimo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PedidoEmprestimoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PedidoEmprestimo model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PedidoEmprestimo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PedidoEmprestimo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PedidoEmprestimo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PedidoEmprestimo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PedidoEmprestimo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return PedidoEmprestimo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PedidoEmprestimo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
