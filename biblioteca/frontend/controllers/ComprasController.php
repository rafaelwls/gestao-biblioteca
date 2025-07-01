<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\Compras;
use common\models\Exemplares;
use yii\data\ActiveDataProvider;

class ComprasController extends Controller
{
    /**
     * Exibe os detalhes de uma compra.
     */
    public function actionView($id)
    {
        $model = Compras::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Compra não encontrada.');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Lista todo o histórico de compras (pendentes, aprovadas e rejeitadas).
     */
    public function actionHistory()
    {
        $query = Compras::find();
        // usuário comum só vê as próprias
        if (!Yii::$app->user->identity->is_trabalhador) {
            $query->andWhere(['usuario_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['data_compra' => SORT_DESC]),
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($livroId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $exemplar = Exemplares::findOne(['livro_id' => $livroId]);
        if (!$exemplar) {
            throw new NotFoundHttpException('Exemplar não encontrado.');
        }

        $model = new Compras();
        $model->exemplar_id = $exemplar->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->status = 'PENDENTE';
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Solicitação de venda registrada. Aguardando sua aprovação.');
            return $this->redirect(['livros/view', 'id' => $livroId]);
        }

        return $this->render('create', [
            'model' => $model,
            'exemplar' => $exemplar,
        ]);
    }

    public function actionIndex()
    {
        $query = Compras::find();
        // traz só compras pendentes
        $query = Compras::find()
            ->where(['status' => 'PENDENTE']);

        // se não for trabalhador, limita ao próprio usuário
        if (!Yii::$app->user->identity->is_trabalhador) {
            $query->andWhere(['usuario_id' => Yii::$app->user->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['data_compra' => SORT_DESC]),
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionApprove($id)
    {
        if (!Yii::$app->user->identity->is_trabalhador) {
            throw new ForbiddenHttpException('Sem permissão.');
        }
        $m = Compras::findOne($id);
        if (!$m)
            throw new NotFoundHttpException;
        if ($m->status === 'PENDENTE') {
            $ex = $m->exemplar;
            $ex->quantidade -= $m->quantidade;
            $ex->save(false);
            $m->status = 'APROVADA';
            $m->save(false);
            Yii::$app->session->setFlash('success', 'Compra aprovada.');
        }
        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        if (!Yii::$app->user->identity->is_trabalhador) {
            throw new ForbiddenHttpException('Sem permissão.');
        }
        $m = Compras::findOne($id);
        if (!$m)
            throw new NotFoundHttpException;
        if ($m->status === 'PENDENTE') {
            $m->status = 'REJEITADA';
            $m->save(false);
            Yii::$app->session->setFlash('info', 'Compra rejeitada.');
        }
        return $this->redirect(['index']);
    }
}
