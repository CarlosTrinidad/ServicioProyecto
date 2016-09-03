<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instructor".
 *
 * @property integer $id
 * @property string $name
 * @property string $last_name
 */
class Instructor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'last_name'], 'required'],
            [['name', 'last_name'], 'string', 'max' => 100],
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
            'last_name' => Yii::t('app', 'Last Name'),
        ];
    }
}
