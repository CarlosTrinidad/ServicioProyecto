<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Classes;
use app\models\Subject;
use app\models\Room;
use yii\helpers\ArrayHelper;

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
            [['id'], 'integer'],
            [['day','time_start','id_subject', 'id_room', 'time_end'], 'safe'],
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
            //'day' => $this->day,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
        ]);
        
if($this->day){
         $dias = array(  '1' => 'Lunes',
                    '2' => 'Martes',
                    '3'=> 'Miércoles',
                    '4' => 'Jueves',
                    '5' => 'Viernes',
                    '6' => 'Sábado',
                    '0' => 'Domingo');
$max=0;
$ind=0;
                    for ($i = 1; $i <= 6; $i++) {
                     $valor = ArrayHelper::getValue($dias, $i);
                     similar_text($valor, $this->day, $percent); 
                     if($max<$percent&&$percent>25){
                        $max=$percent;
                        $ind=$i;
                     }
                         }
}else{
    $ind=$this->day;
}

        $query->andFilterWhere(['like', 'subject.name', $this->id_subject]);
        $query->andFilterWhere(['like', 'room.room', $this->id_room]);
        $query->andFilterWhere(['like', 'day',$ind]);
        return $dataProvider;
    }
}
