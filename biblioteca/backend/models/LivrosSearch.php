<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Livros;

/**
 * LivrosSearch represents the model behind the search form of `common\models\Livros`.
 */
class LivrosSearch extends Livros
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isbn', 'titulo', 'subtitulo', 'idioma', 'data_criacao'], 'safe'],
            [['ano_publicacao', 'paginas'], 'integer'],
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
        $query = Livros::find();

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
            'ano_publicacao' => $this->ano_publicacao,
            'paginas' => $this->paginas,
            'data_criacao' => $this->data_criacao,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'isbn', $this->isbn])
            ->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'subtitulo', $this->subtitulo])
            ->andFilterWhere(['ilike', 'idioma', $this->idioma]);

        return $dataProvider;
    }
}
