<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Livros;
use Yii;

class ControleController extends Controller
{
    public $layout = '@frontend/views/layouts/main-biblio';
    public function behaviors()
    {
        return ['access' => [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => fn() => Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_trabalhador
                ]
            ]
        ]];
    }

    public function actionLivros($q = null)
    {
        $query = Livros::find();
        if ($q) {
            $query->andFilterWhere(['ilike', 'titulo', $q])
                ->orFilterWhere(['ilike', 'autor', $q]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('livros', compact('dataProvider', 'q'));
    }
}
