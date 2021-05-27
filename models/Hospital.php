<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hospitals".
 *
 * @property int $code
 * @property int $type_id
 * @property string|null $address
 *
 * @property Doctor[] $doctors
 * @property HospitalType $type
 */
class Hospital extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospitals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id'], 'integer'],
            [['address'], 'string', 'max' => 30],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => HospitalType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'type_id' => 'Type ID',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[Doctors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::class, ['hospital_code' => 'code']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(HospitalType::class, ['id' => 'type_id']);
    }
}
