<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InstructorSubject;

/**
 * InstructorSubjectSearch represents the model behind the search form about `app\models\InstructorSubject`.
 */
class InstructorSubjectSearch extends InstructorSubject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_subject', 'id_instructor'], 'safe'],
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
        $query = InstructorSubject::find();

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
        $query->joinWith(['idSubject','idInstructor']);

        // grid filtering conditions
        // $query->andFilterWhere([
            // 'id_subject' => $this->id_subject,
            // 'id_instructor' => $this->id_instructor,
        // ]);

        $query->andFilterWhere(['like', 'subject.name', $this->id_subject]);
        // $query->where(['like', 'instructor.name', $this->id_instructor]);
        // $query->where(['like', 'instructor.last_name', $this->id_instructor]);
        $query->andFilterWhere(['like', "concat(instructor.name,' ',instructor.last_name)", $this->id_instructor]);


        return $dataProvider;
    }
}
