<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Fluxo_pessoas;

/**
 * Endpoints HTTP-JSON para integrações externas (catraca).
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;          // chamará via device externo
    public $layout = false;                        // sem HTML

    private function checkKey(): bool
    {
        $hdr = Yii::$app->request->headers->get('X-API-KEY');
        return $hdr === Yii::$app->params['catracaApiKey'];
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!$this->checkKey()) {
            Yii::$app->response->statusCode = 401;
            echo json_encode(['error' => 'unauthorized']);   // early exit
            return false;
        }
        return parent::beforeAction($action);
    }

    /** POST /api/fluxo  { usuario_id, tipo } */
    public function actionFluxo()
    {
        $body = Yii::$app->request->bodyParams;
        if (!isset($body['usuario_id'], $body['tipo'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'usuario_id e tipo obrigatórios'];
        }
        if (!in_array($body['tipo'], ['ENTRADA', 'SAIDA'], true)) {
            Yii::$app->response->statusCode = 422;
            return ['error' => 'tipo deve ser ENTRADA ou SAIDA'];
        }

        $f = new Fluxo_pessoas([
            'usuario_id' => $body['usuario_id'],
            'tipo'       => $body['tipo'],
        ]);
        if ($f->save()) {
            return ['ok' => true, 'id' => $f->id];
        }
        Yii::$app->response->statusCode = 500;
        return ['error' => 'erro ao salvar'];
    }
}
