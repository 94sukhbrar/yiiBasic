<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%subject}}".
 *
 * @property int $id
 * @property string $subject_name
 * @property string $created_on
 * @property string|null $updated_on
 * @property int|null $created_by_id
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subject}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_name', 'created_on'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['created_by_id'], 'integer'],
            [['subject_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_name' => 'Subject Name',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_by_id' => 'Created By ID',
        ];
    }
}
