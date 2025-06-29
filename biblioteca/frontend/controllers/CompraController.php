<?php

namespace frontend\controllers;

use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Compras;
use common\models\Model;
use Yii;
use common\models\ItemCompraForm;
use common\models\Item_compras;
use common\models\Exemplares;
use yii\web\Response;

class CompraController extends Controller
{
    public $layout = '@frontend/views/layouts/main-biblio';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn() =>
                        Yii::$app->user->identity->is_admin ||
                            Yii::$app->user->identity->is_trabalhador
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dp = new ActiveDataProvider([
            'query' => Compras::find()->orderBy(['data_compra' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dp,
            'pendentes' => Compras::find()->where(['status' => 'PENDENTE'])->count(),
            'totalMes'  => Compras::find()
                ->andWhere(['between', 'data_compra', date('Y-m-01'), date('Y-m-t')])
                ->sum('valor_total') ?: 0,
            'livrosMes' => (new \yii\db\Query())
                ->from('item_compras ic')
                ->innerJoin('compras c', 'c.id = ic.compra_id')
                ->andWhere(['between', 'c.data_compra', date('Y-m-01'), date('Y-m-t')])
                ->sum('quantidade') ?: 0,
        ]);
    }
    public function actionCreate()
    {
        $model  = new Compras();
        // pelo menos um item vazio para exibir na view
        $items = [new ItemCompraForm()];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $items = Model::createMultiple(ItemCompraForm::class);
            Model::loadMultiple($items, Yii::$app->request->post());

            $valid = $model->validate() && Model::validateMultiple($items);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // total calculado
                    $model->valor_total = array_sum(
                        array_map(fn($i) => $i->quantidade * $i->valor_unitario, $items)
                    );
                    $model->usuario_id  = Yii::$app->user->id;
                    $model->data_compra = date('Y-m-d');

                    if ($model->save(false)) {
                        foreach ($items as $it) {
                            $item = new Item_compras();
                            $item->attributes   = $it->attributes;
                            $item->compra_id    = $model->id;
                            if (!$item->save(false)) {
                                throw new \Exception('Falha ao salvar item');
                            }
                        }
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Pedido criado!');
                    return $this->redirect(['index']);
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('create', compact('model', 'items'));
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', compact('model'));
    }

    /* -------- UPDATE -------- */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $items = Model::createMultiple(ItemCompraForm::class, $model->itemCompras);
        if (
            $model->load(Yii::$app->request->post()) &&
            Model::loadMultiple($items, Yii::$app->request->post())
        ) {
            $valid = $model->validate() && Model::validateMultiple($items);
            if ($valid && $this->saveCompra($model, $items, true)) {
                Yii::$app->session->setFlash('success', 'Pedido atualizado!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', compact('model', 'items'));
    }

    /* -------- ALTERAR STATUS via badge -------- */
    public function actionSetStatus($id, $status)
    {
        $this->ensureAdmin();
        $model = $this->findModel($id);
        $model->status = strtoupper($status);
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /* -------- DELETE -------- */
    public function actionDelete($id)
    {
        $this->ensureAdmin();
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Pedido removido.');
        return $this->redirect(['index']);
    }

    /* ---------------- HELPERS ---------------- */
    protected function findModel($id)
    {
        if (($m = Compras::findOne($id)) !== null) return $m;
        throw new NotFoundHttpException('Pedido não encontrado.');
    }

    private function ensureAdmin()
    {
        if (!Yii::$app->user->identity->is_admin) {
            throw new yii\web\ForbiddenHttpException('Ação permitida só para administradores.');
        }
    }

    /* Salva compra + itens (criação ou update) */
    private function saveCompra(Compras $model, array $items, bool $isUpdate = false): bool
    {
        $tx = Yii::$app->db->beginTransaction();
        try {
            if ($isUpdate) {            // limpa itens antigos
                Item_compras::deleteAll(['compra_id' => $model->id]);
            }
            $model->valor_total = array_sum(
                array_map(fn($i) => $i->quantidade * $i->valor_unitario, $items)
            );
            if (!$model->save(false)) throw new \Exception('falha pedido');

            foreach ($items as $i) {
                $it = new Item_compras();
                $it->attributes = $i->attributes;
                $it->compra_id  = $model->id;
                if (!$it->save(false)) throw new \Exception('falha item');
            }
            $tx->commit();
            return true;
        } catch (\Throwable $e) {
            $tx->rollBack();
            return false;
        }
    }
}
