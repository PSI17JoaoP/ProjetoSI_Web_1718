<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Anuncio;

/**
 * AnuncioSearch represents the model behind the search form about `common\models\Anuncio`.
 */
class AnuncioSearch extends Anuncio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'cat_oferecer', 'quant_oferecer', 'cat_receber', 'quant_receber'], 'integer'],
            [['titulo', 'estado', 'data_criacao', 'data_conclusao', 'comentarios'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Anuncio::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'cat_oferecer' => $this->cat_oferecer,
            'quant_oferecer' => $this->quant_oferecer,
            'cat_receber' => $this->cat_receber,
            'quant_receber' => $this->quant_receber,
            'data_criacao' => $this->data_criacao,
            'data_conclusao' => $this->data_conclusao,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'comentarios', $this->comentarios]);

        return $dataProvider;
    }
}
