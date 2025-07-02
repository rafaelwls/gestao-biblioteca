<?php

namespace common\models;

use yii\base\Model;

class EmprestimoForm extends Model
{
    public $data_devolucao_real;

    public function rules()
    {
        return [
            ['data_devolucao_real', 'required'],
            ['data_devolucao_real', 'date', 'format' => 'php:Y-m-d']
        ];
    }
}
