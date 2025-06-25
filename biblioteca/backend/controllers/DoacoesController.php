<?php

namespace backend\controllers;

use Yii;
use common\models\Doacoes;
use backend\models\DoacoesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use sizeg\jwt\JwtHttpBearerAuth;

class DoacoesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = [
            // JWT authentication
            'authenticator' => [
                'class' => JwtHttpBearerAuth::class,
            ],
            // Access control
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // any user can create a donation request
                    [
                        'allow'   => true,
                        'actions' => ['create'],
                        'roles'   => ['@'],
                    ],
                    // only worker or admin can index/view/approve/update/delete
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'aprovar', 'update', 'delete'],
                        'matchCallback' => function ($rule, $action) {
                            $u = Yii::$app->user->identity;
                            return $u->isTrabalhador() || $u->isAdmin();
                        },
                    ],
                ],
            ],
            // Verb filter
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'  => ['POST'],
                    'aprovar' => ['POST'],
                ],
            ],
        ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * Lists all Doacoes models.
     */
    public function actionIndex()
    {
        $searchModel  = new DoacoesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Doacoes model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Doacoes model.
     */
    public function actionCreate()
    {
        $model = new Doacoes();
        $model->usuario_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Worker/admin approves or rejects a donation.
     */
    public function actionAprovar($id, $acao)
    {
        $doacao = $this->findModel($id);
        $user   = Yii::$app->user->identity;

        if (!$user->isTrabalhador() && !$user->isAdmin()) {
            throw new ForbiddenHttpException('Acesso negado.');
        }

        $doacao->status = (strtoupper($acao) === 'APROVAR') ? 'APROVADO' : 'RECUSADO';
        $doacao->save(false);

        // se aprovado, você pode adicionar lógica para criar exemplar/livro
        // Emprestimos::... ou Exemplar::createFromDoacao($doacao);

        return $this->redirect(['view', 'id' => $doacao->id]);
    }

    /**
     * Updates an existing Doacoes model.
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        if (!$user->isTrabalhador() && !$user->isAdmin()) {
            throw new ForbiddenHttpException('Acesso negado.');
        }

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Doacoes model.
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
     * Finds the Doacoes model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = Doacoes::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Página não encontrada.');
    }
}
