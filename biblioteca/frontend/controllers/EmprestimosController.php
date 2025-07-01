<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\Emprestimos;
use common\models\Exemplares;
use yii\data\ActiveDataProvider;

class EmprestimosController extends Controller
{
    /**
     * Registra empréstimo sem form (botão na view do livro).
     */
    public function actionCreate($livroId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $exemplar = Exemplares::findOne(['livro_id' => $livroId]);
        if (!$exemplar) {
            throw new NotFoundHttpException('Exemplar não encontrado.');
        }

        $model = new Emprestimos();
        $model->exemplar_id = $exemplar->id;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Empréstimo registrado. Aguardando aprovação.');
        } else {
            Yii::$app->session->setFlash('error', 'Falha ao registrar empréstimo.');
        }

        return $this->redirect(['livros/view', 'id' => $livroId]);
    }

    /**
     * Lista apenas empréstimos pendentes.
     */
    public function actionIndex()
    {
        $query = Emprestimos::find()->where(['status' => 'PENDENTE']);
        if (!Yii::$app->user->identity->is_trabalhador) {
            $query->andWhere(['usuario_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['data_emprestimo' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Aprova um empréstimo (só trabalhador).
     * Atualiza status e status do exemplar.
     */
    public function actionApprove($id)
    {
        if (!Yii::$app->user->identity->is_trabalhador) {
            throw new ForbiddenHttpException('Você não tem permissão.');
        }

        $model = Emprestimos::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Empréstimo não encontrado.');
        }

        if ($model->status === 'PENDENTE') {
            $ex = $model->exemplar;
            $ex->status = 'Emprestado';
            $ex->save(false);

            $model->status = 'APROVADO';
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Empréstimo aprovado.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Rejeita um empréstimo (só trabalhador).
     */
    public function actionReject($id)
    {
        if (!Yii::$app->user->identity->is_trabalhador) {
            throw new ForbiddenHttpException('Você não tem permissão.');
        }

        $model = Emprestimos::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Empréstimo não encontrado.');
        }

        if ($model->status === 'PENDENTE') {
            $model->status = 'REJEITADO';
            $model->save(false);
            Yii::$app->session->setFlash('info', 'Empréstimo rejeitado.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Lista todo o histórico de empréstimos (sem filtro de status),
     * mas usuários padrão veem só os próprios, e trabalhadores veem todos.
     */
    public function actionHistory()
    {
        $query = Emprestimos::find();
        if (!Yii::$app->user->identity->is_trabalhador) {
            $query->andWhere(['usuario_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['data_emprestimo' => SORT_DESC]),
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
