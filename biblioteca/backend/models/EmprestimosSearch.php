<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Emprestimos;

/**
 * EmprestimosSearch represents the model behind the search form of `common\models\Emprestimos`.
 */
class EmprestimosSearch extends Emprestimos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'exemplar_id', 'usuario_id', 'data_emprestimo', 'data_devolucao_prevista', 'data_devolucao_real'], 'safe'],
            [['multa_calculada'], 'number'],
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
        $query = Emprestimos::find();

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
            'data_emprestimo' => $this->data_emprestimo,
            'data_devolucao_prevista' => $this->data_devolucao_prevista,
            'data_devolucao_real' => $this->data_devolucao_real,
            'multa_calculada' => $this->multa_calculada,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'exemplar_id', $this->exemplar_id])
            ->andFilterWhere(['ilike', 'usuario_id', $this->usuario_id]);

        return $dataProvider;
    }
}
