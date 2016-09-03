<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Schoolroom;

/**
 * SchoolroomSearch represents the model behind the search form about `app\models\Schoolroom`.
 */
class SchoolroomSearch extends Schoolroom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'capacity'], 'integer'],
            [['schoolroom'], 'safe'],
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
        $query = Schoolroom::find();

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
            'capacity' => $this->capacity,
        ]);

        $query->andFilterWhere(['like', 'schoolroom', $this->schoolroom]);

        return $dataProvider;
    }
}
