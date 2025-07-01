<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\Vendas;
use common\models\Item_vendas;
use common\models\ItemVendaForm;
use common\models\Model;        // helper
use common\models\Exemplares;

class VendaController extends Controller
{
    public $layout = '@frontend/views/layouts/main-biblio';

    /* ACL: admin ou trabalhador */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [[
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => fn() =>
                    Yii::$app->user->identity->is_admin ||
                        Yii::$app->user->identity->is_trabalhador,
                ]],
            ],
        ];
    }

    /* ---------- LISTAGEM ---------- */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vendas::find()->orderBy(['data_venda' => SORT_DESC]),
            'pagination' => ['pageSize' => 15],
        ]);

        $pendentes = Vendas::find()->where(['status' => 'PENDENTE'])->count();
        $totalMes  = Vendas::find()
            ->andWhere(['between', 'data_venda', date('Y-m-01'), date('Y-m-t')])
            ->sum('valor_total') ?: 0;
        $livrosMes = (new \yii\db\Query())
            ->from('item_vendas iv')
            ->innerJoin('vendas v', 'v.id = iv.venda_id')
            ->andWhere(['between', 'v.data_venda', date('Y-m-01'), date('Y-m-t')])
            ->sum('quantidade') ?: 0;

        return $this->render('index', compact(
            'dataProvider',
            'pendentes',
            'totalMes',
            'livrosMes'
        ));
    }

    /* ---------- CREATE ---------- */
    public function actionCreate()
    {
        $model = new Vendas();
        $items = [new ItemVendaForm()];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $items = Model::createMultiple(ItemVendaForm::class, $items);
            Model::loadMultiple($items, Yii::$app->request->post());

            $valid = $model->validate() && Model::validateMultiple($items);
            if ($valid && $this->saveVenda($model, $items, false)) {
                Yii::$app->session->setFlash('success', 'Venda registrada!');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', compact('model', 'items'));
    }

    /* ---------- VIEW ---------- */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', compact('model'));
    }

    /* ---------- UPDATE ---------- */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $items = Model::createMultiple(ItemVendaForm::class, $model->itemVendas);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            Model::loadMultiple($items, Yii::$app->request->post());
            $valid = $model->validate() && Model::validateMultiple($items);

            if ($valid && $this->saveVenda($model, $items, true)) {
                Yii::$app->session->setFlash('success', 'Venda atualizada!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', compact('model', 'items'));
    }

    /* ---------- ALTERAR STATUS (apenas admin) ---------- */
    public function actionSetStatus($id, $status)
    {
        $this->ensureAdmin();
        $m = $this->findModel($id);
        $m->status = strtoupper($status);
        $m->save(false);
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /* ---------- DELETE ---------- */
    public function actionDelete($id)
    {
        $this->ensureAdmin();
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Venda removida.');
        return $this->redirect(['index']);
    }

    /* ---------- HELPERS ---------- */
    protected function findModel($id)
    {
        if (($m = Vendas::findOne($id)) !== null) return $m;
        throw new NotFoundHttpException('Venda não encontrada.');
    }
    private function ensureAdmin()
    {
        if (!Yii::$app->user->identity->is_admin)
            throw new \yii\web\ForbiddenHttpException('Apenas administradores.');
    }
    private function saveVenda(Vendas $model, array $items, bool $isUpdate): bool
    {
        $tx = Yii::$app->db->beginTransaction();
        try {
            if ($isUpdate) Item_vendas::deleteAll(['venda_id' => $model->id]);

            $model->valor_total = array_sum(
                array_map(fn($i) => $i->quantidade * $i->valor_unitario, $items)
            );
            $model->usuario_id = Yii::$app->user->id;
            $model->data_venda = date('Y-m-d');

            if (!$model->save(false)) throw new \Exception('falha venda');

            foreach ($items as $itF) {
                $it = new Item_vendas();
                $it->attributes = $itF->attributes;
                $it->venda_id   = $model->id;
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
