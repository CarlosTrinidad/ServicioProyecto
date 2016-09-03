<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property string $name
 * @property string $ps
 * @property string $model
 * @property integer $semester
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ps', 'model', 'semester'], 'required'],
            [['semester'], 'integer'],
            [['name', 'ps', 'model'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'ps' => Yii::t('app', 'Ps'),
            'model' => Yii::t('app', 'Model'),
            'semester' => Yii::t('app', 'Semester'),
        ];
    }
}
