<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hospital_types".
 *
 * @property int $id
 * @property string $type
 *
 * @property Hospital[] $hospitals
 */
class HospitalType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospital_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Hospitals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHospitals()
    {
        return $this->hasMany(Hospital::class, ['type_id' => 'id']);
    }
}
