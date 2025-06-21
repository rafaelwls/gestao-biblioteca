<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Item_compras;

/**
 * ItemComprasSearch represents the model behind the search form of `common\models\Item_compras`.
 */
class ItemComprasSearch extends Item_compras
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['compra_id', 'exemplar_id'], 'safe'],
            [['valor_unitario'], 'number'],
            [['quantidade'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Item_compras::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'valor_unitario' => $this->valor_unitario,
            'quantidade' => $this->quantidade,
        ]);

        $query->andFilterWhere(['ilike', 'compra_id', $this->compra_id])
            ->andFilterWhere(['ilike', 'exemplar_id', $this->exemplar_id]);

        return $dataProvider;
    }
}
