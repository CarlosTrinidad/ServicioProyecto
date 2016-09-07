<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Classes;
use app\models\Subject;
use app\models\Room;

/**
 * ClassesSearch represents the model behind the search form about `app\models\Classes`.
 */
class ClassesSearch extends Classes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day'], 'integer'],
            [['time_start','id_subject', 'id_room', 'time_end'], 'safe'],
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
        $query = Classes::find();

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
        
         $query->joinWith(['idSubject','idRoom']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'id_room' => $this->id_room,
            'day' => $this->day,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
        ]);
        $query->andFilterWhere(['like', 'subject.name', $this->id_subject]);
        $query->andFilterWhere(['like', 'room.room', $this->id_room]);



        return $dataProvider;
    }
}
