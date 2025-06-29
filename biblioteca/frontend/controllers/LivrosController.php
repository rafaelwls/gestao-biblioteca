<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\Livros;
use frontend\models\Favoritos;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class LivrosController extends Controller
{
    /**
     * Aplica controle de acesso: só usuários logados podem ver a lista de favoritos
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                // passe a aplicar a regra também em delete:
                'only' => ['favoritos', 'delete'],
                'rules' => [
                    // favoritos continua como antes…
                    [
                        'actions' => ['favoritos'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // delete só para admin ou trabalhador
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $u = Yii::$app->user->identity;
                            return $u->is_admin || $u->is_trabalhador;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Exclui um livro (somente admin/trabalhador).
     * URL: /livros/delete?id=…
     */
   public function actionDelete($id)
{
    $model = Livros::findOne($id);
    if (!$model) {
        throw new NotFoundHttpException('Livro não encontrado.');
    }

    // só altera o status para INATIVO em vez de apagar
    $model->status = 'INATIVO';
    $model->save(false, ['status']);

    return $this->redirect(['index']);
}


    /**
     * Action que lista os livros marcados como favoritos pelo usuário logado.
     * URL: /livros/favoritos
     */
    public function actionFavoritos()
    {
        $userId = Yii::$app->user->id;
        $query = Livros::find()
            ->alias('livro')
            ->innerJoin('favoritos f', 'f.livro_id = livro.id')
            ->where(['f.usuario_id' => $userId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['f.data_favorito' => SORT_DESC],
            ],
        ]);

        // Se você quer usar a view que já existe em views/livro/favoritos.php:
        return $this->render('//livro/favoritos', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        $query = Livros::find();

        // se não for admin/trabalhador, só exibe status = ATIVO
        $user = Yii::$app->user->identity;
        if (!$user->is_admin && !$user->is_trabalhador) {
            $query->andWhere(['status' => 'ATIVO']);
        }

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => 10],
            'sort'       => ['defaultOrder' => ['titulo' => SORT_ASC]],
        ]);

        return $this->render('//livro/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Atualiza um livro existente.
     * URL: /livros/update?id=…
     */
    public function actionUpdate($id)
    {
        // 1) Carrega o model (ou lança 404)
        $model = Livros::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Livro não encontrado.');
        }

        // 2) Verifica permissão de edição (caso aplique)
        $user = Yii::$app->user->identity;
        if (!$user->is_admin && !$user->is_trabalhador) {
            throw new \yii\web\ForbiddenHttpException('Acesso negado.');
        }

        // 3) Se veio via POST, tenta carregar + salvar
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // > aqui é onde a alteração no banco acontece
            // 4) Redireciona de volta para index
            return $this->redirect(['index']);
        }

        // 5) Se não for POST ou falhar validação, renderiza o form de update
        return $this->render('//livro/update', [
            'model' => $model,
        ]);
    }


}
