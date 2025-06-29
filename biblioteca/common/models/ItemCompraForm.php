<?php

namespace common\models;

use yii\base\Model;

class ItemCompraForm extends Model
{
    public $exemplar_id;
    public $quantidade;
    public $valor_unitario;

    public function rules()
    {
        return [
            [['exemplar_id', 'quantidade', 'valor_unitario'], 'required'],
            [['exemplar_id'], 'string'],
            [['quantidade'], 'integer', 'min' => 1],
            [['valor_unitario'], 'number', 'min' => 0],
        ];
    }
}
