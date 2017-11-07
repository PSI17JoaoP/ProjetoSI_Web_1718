<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Proposta;

/**
 * PropostaSearch represents the model behind the search form about `common\models\Proposta`.
 */
class PropostaSearch extends Proposta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_proposto', 'quant', 'id_user', 'id_anuncio'], 'integer'],
            [['estado', 'data_proposta'], 'safe'],
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
        $query = Proposta::find();

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
            'cat_proposto' => $this->cat_proposto,
            'quant' => $this->quant,
            'id_user' => $this->id_user,
            'id_anuncio' => $this->id_anuncio,
            'data_proposta' => $this->data_proposta,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
