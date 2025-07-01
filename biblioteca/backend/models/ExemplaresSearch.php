<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Exemplares;

/**
 * ExemplaresSearch represents the model behind the search form of `common\models\Exemplares`.
 */
class ExemplaresSearch extends Exemplares
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'livro_id', 'data_aquisicao', 'status', 'estado', 'codigo_barras', 'data_remocao', 'motivo_remocao'], 'safe'],
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
        $query = Exemplares::find();

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
            'data_aquisicao' => $this->data_aquisicao,
            'data_remocao' => $this->data_remocao,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'livro_id', $this->livro_id])
            ->andFilterWhere(['ilike', 'status', $this->status])
            ->andFilterWhere(['ilike', 'estado', $this->estado])
            ->andFilterWhere(['ilike', 'codigo_barras', $this->codigo_barras])
            ->andFilterWhere(['ilike', 'motivo_remocao', $this->motivo_remocao]);

        return $dataProvider;
    }
}
