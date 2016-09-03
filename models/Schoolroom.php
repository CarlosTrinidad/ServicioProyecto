<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schoolroom".
 *
 * @property integer $id
 * @property string $schoolroom
 * @property integer $capacity
 */
class Schoolroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schoolroom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schoolroom', 'capacity'], 'required'],
            [['capacity'], 'integer'],
            [['schoolroom'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'schoolroom' => Yii::t('app', 'Schoolroom'),
            'capacity' => Yii::t('app', 'Capacity'),
        ];
    }
}
