<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\Livros;
use common\models\Favoritos;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

use common\models\Exemplares;

class LivrosController extends Controller
{
    public function actionCreate()
    {
        $model = new Livros();
        $exemplar = new Exemplares();
        $post = Yii::$app->request->post();

        if (
            $model->load($post) &&
            $exemplar->load($post) &&
            $model->validate() &&
            $exemplar->validate(['quantidade', 'estado', 'codigo_barras', 'data_aquisicao'])
        ) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // salva todos os atributos do livro
                $model->save(false);

                // preenche e salva o exemplar
                $exemplar->livro_id = $model->id;
                $exemplar->status = $model->status;
                $exemplar->save(false);

                $transaction->commit();
                return $this->redirect(['index']);
            } catch (\yii\db\IntegrityException $e) {
                $transaction->rollBack();
                // tratamento de erro igual ao já implementado...
            } catch (\Exception $e) {
                $transaction->rollBack();
                // tratamento genérico...
            }
        }

        return $this->render('//livro/create', [
            'model' => $model,
            'exemplar' => $exemplar,
        ]);
    }


    public function actionView($id)
    {
        $model = Livros::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Livro não encontrado.');
        }
        // renderiza view em views/livros/view.php
        return $this->render('//livro/view', [
            'model' => $model,
        ]);
    }


    /**
     * Aplica controle de acesso: só usuários logados podem ver a lista de favoritos
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['favoritos', 'delete'],
                'rules' => [
                    [
                        'actions' => ['favoritos'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * Cria um novo Livro.
     */
    public function actionFavoritos()
    {
        $userId = Yii::$app->user->id;

        // Monta a query incluindo a coluna data_favorito
        $query = Livros::find()
            ->alias('l')
            ->select(['l.*', 'f.data_favorito'])
            ->innerJoin('favoritos f', 'f.livro_id = l.id')
            ->where(['f.usuario_id' => $userId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['data_favorito' => SORT_DESC],
                'attributes' => [
                    'titulo',
                    'data_favorito' => [
                        'asc' => ['f.data_favorito' => SORT_ASC],
                        'desc' => ['f.data_favorito' => SORT_DESC],
                        'label' => 'Data de Favorito',
                    ],
                ],
            ],
        ]);

        return $this->render('//livro/favoritos', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Adiciona ou remove o livro dos favoritos do usuário logado
     */
    public function actionToggleFavorite($id)
    {
        $userId = Yii::$app->user->id;

        // procura o favorito
        $fav = Favoritos::findOne(['usuario_id' => $userId, 'livro_id' => $id]);
        if ($fav) {
            $fav->delete();
            Yii::$app->session->setFlash('success', 'Livro removido dos favoritos.');
        } else {
            $new = new Favoritos();
            $new->usuario_id = $userId;
            $new->livro_id = $id;
            $new->save(false);
            Yii::$app->session->setFlash('success', 'Livro adicionado aos favoritos.');
        }

        // redireciona de volta à página de detalhe
        return $this->redirect(['view', 'id' => $id]);
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
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['titulo' => SORT_ASC]],
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
