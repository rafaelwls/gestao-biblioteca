<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Transaction;
use common\models\Livros;
use common\models\Compras;
use common\models\ItemCompras;

class ComprasController extends Controller
{
    /**
     * Cria uma nova compra para um livro específico.
     * Rota: /compras/create?livroId=UUID
     */
    public function actionCreate($livroId)
    {
        // 1) Carrega o livro ou 404
        $livro = Livros::findOne($livroId);
        if (!$livro) {
            throw new NotFoundHttpException("Livro não encontrado: $livroId");
        }

        // 2) Model da compra
        $compra = new Compras();
        $compra->usuario_id = Yii::$app->user->id;
        // data_compra vem default do DB

        // Campos extras não no model: quantidade e valor_unitario
        $quantidade     = Yii::$app->request->post('quantidade', 1);
        $valorUnitario  = Yii::$app->request->post('valor_unitario', '');

        if (Yii::$app->request->isPost) {
            // validações básicas
            if ($quantidade < 1) {
                Yii::$app->session->setFlash('error', 'Quantidade deve ser ao menos 1.');
            } elseif (!is_numeric($valorUnitario) || $valorUnitario <= 0) {
                Yii::$app->session->setFlash('error', 'Valor unitário inválido.');
            } else {
                // Calcula valor_total
                $compra->valor_total = $quantidade * $valorUnitario;

                $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
                try {
                    if (!$compra->save()) {
                        throw new \Exception('Falha ao salvar compra');
                    }

                    // criar exemplares e itens de compra
                    for ($i = 0; $i < $quantidade; $i++) {
                        // 1 exemplar
                        $exemplar = new \common\models\Exemplares();
                        $exemplar->livro_id       = $livro->id;
                        $exemplar->status         = 'DISPONÍVEL';
                        $exemplar->estado         = 'NOVO';
                        // data_aquisicao default
                        if (!$exemplar->save()) {
                            throw new \Exception('Falha ao criar exemplar');
                        }

                        // item de compra
                        $item = new ItemCompras();
                        $item->compra_id      = $compra->id;
                        $item->exemplar_id    = $exemplar->id;
                        $item->valor_unitario = $valorUnitario;
                        $item->quantidade     = 1;
                        if (!$item->save()) {
                            throw new \Exception('Falha ao criar item de compra');
                        }
                    }

                    $transaction->commit();
                    return $this->redirect(['livros/view', 'id' => $livro->id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'livro'          => $livro,
            'compra'         => $compra,
            'quantidade'     => $quantidade,
            'valorUnitario'  => $valorUnitario,
        ]);
    }
}
