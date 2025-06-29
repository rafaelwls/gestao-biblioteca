<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Fluxo_pessoas;

class DashboardController extends Controller
{
    public $layout = '@frontend/views/layouts/main-biblio';

    /** já existia actionLivros; nova: */
    public function actionFluxo()
    {
        $today = date('Y-m-d');

        /* Entradas */
        $entradas = (new \yii\db\Query())
            ->from('fluxo_pessoas')
            ->where(['tipo' => 'ENTRADA'])
            ->andWhere(new \yii\db\Expression("timestamp::date = :d", [':d' => $today]))
            ->count();

        /* Saídas */
        $saidas = (new \yii\db\Query())
            ->from('fluxo_pessoas')
            ->where(['tipo' => 'SAIDA'])
            ->andWhere(new \yii\db\Expression("timestamp::date = :d", [':d' => $today]))
            ->count();

        $presentes = max($entradas - $saidas, 0);

        /* Agrupado por hora (ENT/SAI) */
        $rows = (new \yii\db\Query())
            ->select([
                "to_char(date_trunc('hour', timestamp), 'HH24:00') AS hora",
                "SUM(CASE WHEN tipo='ENTRADA' THEN 1 ELSE 0 END) AS ent",
                "SUM(CASE WHEN tipo='SAIDA'   THEN 1 ELSE 0 END) AS sai"
            ])
            ->from('fluxo_pessoas')
            ->andWhere(new \yii\db\Expression("timestamp::date = :d", [':d' => $today]))
            ->groupBy('hora')
            ->orderBy('hora')
            ->all();

        return $this->render('fluxo', compact(
            'entradas',
            'saidas',
            'presentes',
            'rows'
        ));
    }
}
