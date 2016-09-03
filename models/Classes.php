<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property integer $id
 * @property integer $id_subject
 * @property integer $id_schoolroom
 * @property integer $day
 * @property string $time_start
 * @property string $time_end
 */
class Classes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_subject', 'id_schoolroom', 'day', 'time_start', 'time_end'], 'required'],
            [['id_subject', 'id_schoolroom', 'day'], 'integer'],
            [['time_start', 'time_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_subject' => Yii::t('app', 'Id Subject'),
            'id_schoolroom' => Yii::t('app', 'Id Schoolroom'),
            'day' => Yii::t('app', 'Day'),
            'time_start' => Yii::t('app', 'Time Start'),
            'time_end' => Yii::t('app', 'Time End'),
        ];
    }
}
