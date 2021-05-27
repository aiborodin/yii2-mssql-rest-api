<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "doctors".
 *
 * @property int $code
 * @property string $surname
 * @property int $license_number
 * @property int $hospital_code
 * @property int|null $prescriptions_count
 *
 * @property Hospital $hospital
 * @property Prescriptions[] $prescriptions
 */
class Doctor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surname', 'license_number', 'hospital_code'], 'required'],
            [['license_number', 'hospital_code', 'prescriptions_count'], 'integer'],
            [['surname'], 'string', 'max' => 50],
            [['license_number'], 'unique'],
            [['hospital_code'], 'exist', 'skipOnError' => true, 'targetClass' => Hospital::class, 'targetAttribute' => ['hospital_code' => 'code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'surname' => 'Surname',
            'license_number' => 'License Number',
            'hospital_code' => 'Hospital Code',
            'prescriptions_count' => 'Prescriptions Count',
        ];
    }

    /**
     * Gets query for [[Hospital]].
     *
     * @return ActiveQuery
     */
    public function getHospital()
    {
        return $this->hasOne(Hospital::class, ['code' => 'hospital_code']);
    }

    /**
     * Gets query for [[Prescriptions]].
     *
     * @return ActiveQuery
     */
    public function getPrescriptions()
    {
        return $this->hasMany(Prescriptions::class, ['doctor_code' => 'code']);
    }
}
