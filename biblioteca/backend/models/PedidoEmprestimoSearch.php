<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PedidoEmprestimo;

/**
 * PedidoEmprestimoSearch represents the model behind the search form of `common\models\PedidoEmprestimo`.
 */
class PedidoEmprestimoSearch extends PedidoEmprestimo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'exemplar_id', 'data_solicitacao', 'status'], 'safe'],
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
        $query = PedidoEmprestimo::find();

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
            'data_solicitacao' => $this->data_solicitacao,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'usuario_id', $this->usuario_id])
            ->andFilterWhere(['ilike', 'exemplar_id', $this->exemplar_id])
            ->andFilterWhere(['ilike', 'status', $this->status]);

        return $dataProvider;
    }
}
