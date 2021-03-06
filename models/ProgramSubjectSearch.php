<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProgramSubject;

/**
 * ProgramSubjectSearch represents the model behind the search form about `app\models\ProgramSubject`.
 */
class ProgramSubjectSearch extends ProgramSubject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_subject', 'id_program'], 'safe'],
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
        $query = ProgramSubject::find();

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
        $query->joinWith(['idSubject','idProgram']);

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id_subject' => $this->id_subject,
        //     'id_program' => $this->id_program,
        // ]);

        $query->andFilterWhere(['like', 'subject.name', $this->id_subject]);
        $query->andFilterWhere(['like', 'study_program.name', $this->id_program]);

        return $dataProvider;
    }
}
