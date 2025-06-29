<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Exemplares;
use common\models\Favoritos;
use common\models\Emprestimos;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],           // só logados
                        'matchCallback' => function () {
                            /** @var \common\models\Usuarios $u */
                            $u = Yii::$app->user->identity;
                            return $u->isAdmin() || $u->isTrabalhador();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        // mesmos dados, mas para todos os usuários
        $available = Exemplares::find()->where(['status' => 'disponível'])->joinWith('livro')->all();
        $allFavorites = Favoritos::find()->joinWith(['usuario', 'livro'])->all();
        $allLoans     = Emprestimos::find()->joinWith(['usuario', 'exemplar.livro'])->all();

        return $this->render('index', [
            'available'    => $available,
            'allFavorites' => $allFavorites,
            'allLoans'     => $allLoans,
        ]);
    }
}
