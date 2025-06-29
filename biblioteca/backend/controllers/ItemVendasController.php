<?php

namespace backend\controllers;

use common\models\Item_vendas;
use backend\models\ItemVendasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;

/**
 * ItemVendasController implements the CRUD actions for Item_vendas model.
 */
class ItemVendasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // descomente para NÃO usar JWT enquanto testa
        // unset($behaviors['authenticator']);
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
                        /** @var \common\models\Usuarios $u */
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
     * Lists all Item_vendas models.
     *
     * @return string
     */
    public function actionIndex()
    {

        var_dump(get_class(Yii::$app->user->identity));
        exit;

        $searchModel = new ItemVendasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item_vendas model.
     * @param string $venda_id Venda ID
     * @param string $exemplar_id Exemplar ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($venda_id, $exemplar_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($venda_id, $exemplar_id),
        ]);
    }

    /**
     * Creates a new Item_vendas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Item_vendas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'venda_id' => $model->venda_id, 'exemplar_id' => $model->exemplar_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item_vendas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $venda_id Venda ID
     * @param string $exemplar_id Exemplar ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($venda_id, $exemplar_id)
    {
        $model = $this->findModel($venda_id, $exemplar_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'venda_id' => $model->venda_id, 'exemplar_id' => $model->exemplar_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Item_vendas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $venda_id Venda ID
     * @param string $exemplar_id Exemplar ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($venda_id, $exemplar_id)
    {
        $this->findModel($venda_id, $exemplar_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item_vendas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $venda_id Venda ID
     * @param string $exemplar_id Exemplar ID
     * @return Item_vendas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($venda_id, $exemplar_id)
    {
        if (($model = Item_vendas::findOne(['venda_id' => $venda_id, 'exemplar_id' => $exemplar_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
