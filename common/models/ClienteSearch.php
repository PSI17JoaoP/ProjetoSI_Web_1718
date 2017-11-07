<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cliente;

/**
 * ClienteSearch represents the model behind the search form about `common\models\Cliente`.
 */
class ClienteSearch extends Cliente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'telefone', 'pin'], 'integer'],
            [['nome_completo', 'data_nasc', 'email', 'regiao'], 'safe'],
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
        $query = Cliente::find();

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
            'id_user' => $this->id_user,
            'data_nasc' => $this->data_nasc,
            'telefone' => $this->telefone,
            'pin' => $this->pin,
        ]);

        $query->andFilterWhere(['like', 'nome_completo', $this->nome_completo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'regiao', $this->regiao]);

        return $dataProvider;
    }
}
