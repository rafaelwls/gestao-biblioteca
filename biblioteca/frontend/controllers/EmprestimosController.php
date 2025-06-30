<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\{PedidoEmprestimo, Emprestimos, EmprestimoForm, Exemplares, Model};

class EmprestimoController extends Controller
{
    public $layout = '@frontend/views/layouts/main-biblio';

    public function behaviors()
    {
        return ['access' => [
            'class' => AccessControl::class,
            'rules' => [
                ['allow' => true, 'roles' => ['@'], 'actions' => ['meus', 'solicitar']],
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => fn() => Yii::$app->user->identity->is_admin ||
                        Yii::$app->user->identity->is_trabalhador,
                    'actions' => ['pedidos', 'aprovar', 'devolver']
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => fn() => Yii::$app->user->identity->is_admin,
                    'actions' => ['index']
                ],
            ],
        ]];
    }

    /* ---------- usuario ---------- */
    public function actionMeus()
    {
        $uid   = Yii::$app->user->id;
        $ativos = Emprestimos::find()->where([
            'usuario_id' => $uid,
            'data_devolucao_real' => null
        ]);
        $hist  = Emprestimos::find()->where(['usuario_id' => $uid])
            ->andWhere('data_devolucao_real IS NOT NULL');

        return $this->render('meus', [
            'ativos' => $ativos->all(),
            'hist'  => $hist->all(),
        ]);
    }

    public function actionSolicitar($exemplar)
    {
        $p = new PedidoEmprestimo([
            'usuario_id' => Yii::$app->user->id,
            'exemplar_id' => $exemplar,
            'status' => 'PENDENTE',
        ]);
        $p->save(false);
        Yii::$app->session->setFlash('success', 'Pedido enviado!');
        return $this->redirect(['/meus-emprestimos']);
    }

    /* ---------- trabalhador/admin ---------- */
    public function actionPedidos()
    {
        $dp = new ActiveDataProvider([
            'query' => PedidoEmprestimo::find()->where(['status' => 'PENDENTE'])
                ->with(['usuario', 'exemplar.livro'])
        ]);
        return $this->render('pedidos', compact('dp'));
    }

    public function actionAprovar($id)
    {
        $p = PedidoEmprestimo::findOne($id);
        if (!$p || $p->status !== 'PENDENTE') throw new NotFoundHttpException;
        $e = new Emprestimos([
            'exemplar_id' => $p->exemplar_id,
            'usuario_id' => $p->usuario_id,
            'data_emprestimo' => date('Y-m-d'),
            'data_devolucao_prevista' => date('Y-m-d', strtotime('+7 day')),
        ]);
        $e->save(false);
        $p->status = 'APROVADO';
        $p->save(false);
        Yii::$app->session->setFlash('success', 'Aprovado!');
        return $this->redirect(['pedidos']);
    }

    public function actionDevolver($id)
    {
        $emp = Emprestimos::findOne($id);
        if (!$emp) throw new NotFoundHttpException;

        $form = new EmprestimoForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $emp->data_devolucao_real = $form->data_devolucao_real;
            $atraso = (strtotime($form->data_devolucao_real) -
                strtotime($emp->data_devolucao_prevista)) / 86400;
            if ($atraso > 0) $emp->multa_calculada = $atraso * 1.00; // R$1 por dia
            $emp->save(false);
            Yii::$app->session->setFlash('success', 'Devolução registrada!');
            return $this->redirect(['index']);
        }
        return $this->render('devolver', compact('emp', 'form'));
    }

    public function actionIndex()
    {
        $dp = new ActiveDataProvider([
            'query' => Emprestimos::find()->with(['usuario', 'exemplar.livro'])
                ->orderBy(['data_emprestimo' => SORT_DESC])
        ]);
        return $this->render('index', compact('dp'));
    }
}
