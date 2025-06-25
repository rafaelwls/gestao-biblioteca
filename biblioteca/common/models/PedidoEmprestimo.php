<?php

namespace backend\controllers;

use Yii;
use common\models\PedidoEmprestimo;
use common\models\Emprestimos;
use backend\models\PedidoEmprestimoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use sizeg\jwt\JwtHttpBearerAuth;

class PedidoEmprestimoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = [
            // 1) JWT Bearer authentication
            'authenticator' => [
                'class' => JwtHttpBearerAuth::class,
            ],
            // 2) Access control by role
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // any logged in user can create a request
                    [
                        'allow'   => true,
                        'actions' => ['create'],
                        'roles'   => ['@'],
                    ],
                    // only worker or admin can index/view/respond/update/delete
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'update', 'delete', 'resposta'],
                        'matchCallback' => function ($rule, $action) {
                            $u = Yii::$app->user->identity;
                            return $u->isTrabalhador() || $u->isAdmin();
                        },
                    ],
                ],
            ],
            // 3) Verb filter
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'   => ['POST'],
                    'resposta' => ['POST'],
                ],
            ],
        ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * Lists all PedidoEmprestimo models.
     */
    public function actionIndex()
    {
        $searchModel  = new PedidoEmprestimoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PedidoEmprestimo model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PedidoEmprestimo model.
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        if (!$user->canBorrow()) {
            throw new ForbiddenHttpException('Você não pode pegar mais empréstimos no momento.');
        }

        $model = new PedidoEmprestimo();
        $model->usuario_id = $user->id;

        // assume the POST payload contains only exemplar_id:
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Worker or admin responds to a request: ACEITO or RECUSADO.
     */
    public function actionResposta($id, $resposta)
    {
        $pedido = $this->findModel($id);

        // only worker or admin allowed
        $user = Yii::$app->user->identity;
        if (!$user->isTrabalhador() && !$user->isAdmin()) {
            throw new ForbiddenHttpException('Acesso negado.');
        }

        if (strtoupper($resposta) === 'ACEITO') {
            $pedido->status = 'ACEITO';
            $pedido->save(false);

            // create the real loan record
            Emprestimos::createFromPedido($pedido->usuario_id, $pedido->exemplar_id);
        } else {
            $pedido->status = 'RECUSADO';
            $pedido->save(false);
        }

        return $this->redirect(['view', 'id' => $pedido->id]);
    }

    /**
     * Updates an existing PedidoEmprestimo model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $user = Yii::$app->user->identity;
        if (!$user->isTrabalhador() && !$user->isAdmin()) {
            throw new ForbiddenHttpException('Acesso negado.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing PedidoEmprestimo model.
     */
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        if (!$user->isTrabalhador() && !$user->isAdmin()) {
            throw new ForbiddenHttpException('Acesso negado.');
        }

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the PedidoEmprestimo model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = PedidoEmprestimo::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Página não encontrada.');
    }
}
