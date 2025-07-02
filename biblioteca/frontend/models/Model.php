<?php

namespace common\models;

use Yii;
use yii\base\Model as YiiModel;

/**
 * Helper para formulários tabulares (createMultiple / loadMultiple).
 * Adaptado do exemplo oficial da extensão yii2-dynamicform.
 */
class Model extends YiiModel
{
    /**
     * Cria um array de instâncias do $modelClass
     * preenchendo com dados do POST se existirem.
     *
     * @param string $modelClass  Classe do modelo (ex.: ItemCompraForm::class)
     * @param array  $multipleModels  Instâncias existentes (update)
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $request  = Yii::$app->request;
        $formName = (new $modelClass())->formName();
        $post     = $request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(Yii::$app->request->post($formName, []));
            foreach ($multipleModels as $i => $model) {
                if (in_array($i, $keys)) {
                    $models[$i] = $model;
                }
            }
        }

        if (! empty($post)) {
            foreach ($post as $i => $item) {
                $models[$i] = new $modelClass();
            }
        }

        unset($models['__id__']); // caso venha de dynamicform
        return $models ?: [new $modelClass()];
    }
}
