<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form of `common\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nome', 'sobrenome', 'email', 'data_cadastro', 'data_validade'], 'safe'],
            [['is_admin', 'is_trabalhador'], 'boolean'],
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
        $query = Usuarios::find();

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
            'data_cadastro' => $this->data_cadastro,
            'data_validade' => $this->data_validade,
            'is_admin' => $this->is_admin,
            'is_trabalhador' => $this->is_trabalhador,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'nome', $this->nome])
            ->andFilterWhere(['ilike', 'sobrenome', $this->sobrenome])
            ->andFilterWhere(['ilike', 'email', $this->email]);

        return $dataProvider;
    }
}
