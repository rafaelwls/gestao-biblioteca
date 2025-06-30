<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Exemplares;

class Compras extends ActiveRecord
{
    public static function tableName()
    {
        return 'compras';
    }

    public function rules()
    {
        return [
            // campos vindos do form
            [['quantidade','valor_unitario'], 'required'],
            ['quantidade', 'integer', 'min' => 1],
            ['valor_unitario', 'number', 'min' => 0.01],

            // status padrão
            ['status', 'default', 'value' => 'PENDENTE'],
            ['status', 'in', 'range'=>['PENDENTE','APROVADA','REJEITADA']],

            // FK exemplar
            ['exemplar_id','required'],
            ['exemplar_id','exist','targetClass'=>Exemplares::class,'targetAttribute'=>['exemplar_id'=>'id']],

            // valida disponibilidade
            ['quantidade','validateAvailable'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'exemplar_id'    => 'Exemplar',
            'quantidade'     => 'Quantidade',
            'valor_unitario' => 'Valor Unitário',
            'valor_total'    => 'Valor Total',
            'status'         => 'Status',
            'data_compra'    => 'Data da Compra',
        ];
    }

    public function getExemplar()
    {
        return $this->hasOne(Exemplares::class, ['id'=>'exemplar_id']);
    }

    public function validateAvailable($attribute)
    {
        if (!$this->hasErrors() && $this->exemplar) {
            if ($this->$attribute > $this->exemplar->quantidade) {
                $this->addError($attribute, "Máximo disponível: {$this->exemplar->quantidade}");
            }
        }
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->valor_total = $this->quantidade * $this->valor_unitario;
            $this->usuario_id = Yii::$app->user->id;
            $this->data_compra = date('Y-m-d');
        }
        return parent::beforeSave($insert);
    }
}
