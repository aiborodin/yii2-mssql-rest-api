<?php

namespace app\actions\doctor;

use app\models\Doctor;
use Yii;
use yii\base\InvalidValueException;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class CreateAction extends \yii\rest\CreateAction
{
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $model = new Doctor();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && !$model->hasErrors()) {
            Yii::$app->db->createCommand("EXEC addDoctor :surname, :license_number, :hospital_code, :prescriptions_count", [
                ':surname' => $model->surname,
                ':license_number' => $model->license_number,
                ':hospital_code' => $model->hospital_code,
                ':prescriptions_count' => $model->prescriptions_count
            ])->execute();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } else {
            throw new ServerErrorHttpException('Failed to create the doctor.');
        }
        return $model;
    }

}
