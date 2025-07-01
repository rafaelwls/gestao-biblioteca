<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Usuarios;

class UsuariosController extends Controller
{
    /**
     * Lista todos os usuários.
     * URL: /usuarios/index
     */
    public function actionIndex()
    {
        $query = Usuarios::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['nome' => SORT_ASC],
                'attributes' => [
                    'id',
                    'nome',
                    'sobrenome',
                    'email',
                    'data_cadastro',
                    'data_validade',
                    'is_admin',
                    'is_trabalhador',
                    'senha',
                    'auth_key',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = Usuarios::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Usuário não encontrado: $id");
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Atualiza um usuário existente.
     * URL: /usuarios/update?id=UUID
     */
    public function actionUpdate($id)
    {
        $model = Usuarios::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Usuário não encontrado: $id");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Cria um novo usuário.
     * URL: /usuarios/create
     */
    public function actionCreate()
    {
        $model = new \common\models\Usuarios();

        if ($model->load(Yii::$app->request->post())) {
            // campos automáticos: id, data_cadastro, created_at, updated_at
            // senha e auth_key devem ser gerados antes do save, por ex:
            $model->senha = Yii::$app->security->generateRandomString(8);
            $model->auth_key = Yii::$app->security->generateRandomString();
            // data_cadastro terá default no DB; created_at/updated_at podem vir de behaviours TimestampBehavior

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Falha ao salvar usuário.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
