<?php

namespace frontend\controllers;

use Yii;
use common\models\Livros;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LivroController extends Controller
{
    public $layout = '@frontend/views/layouts/main-biblio';

    /* ---------- CRUD padrão ---------- */

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Livros::find(),
            'pagination' => ['pageSize' => 15],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Livros();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /* ---------- Favoritos ---------- */

    public function actionFavoritos()
    {
        $userId = Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Livros::find()
                ->innerJoin('favoritos f', 'f.livro_id = livro.id')
                ->where(['f.usuario_id' => $userId]),
        ]);

        return $this->render('favoritos', [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($m = Livros::findOne($id)) !== null) return $m;
        throw new NotFoundHttpException('Livro não encontrado.');
    }
}
