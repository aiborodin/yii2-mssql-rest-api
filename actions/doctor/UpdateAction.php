<?php


namespace app\actions\doctor;


use app\models\Doctor;
use Yii;
use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;

class UpdateAction extends \yii\rest\UpdateAction
{
    public function run($id)
    {
        $model = Doctor::findOne($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && !$model->hasErrors()) {
            Yii::$app->db->createCommand("EXEC updateDoctor :code, :surname, :license_number, :hospital_code, :prescriptions_count", [
                ':code' => $model->code,
                ':surname' => $model->surname,
                ':license_number' => $model->license_number,
                ':hospital_code' => $model->hospital_code,
                ':prescriptions_count' => $model->prescriptions_count
            ])->execute();
        } else {
            throw new ServerErrorHttpException('Failed to update the doctor.');
        }
        return $model;
    }

}
