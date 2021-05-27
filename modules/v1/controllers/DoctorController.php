<?php

namespace app\modules\v1\controllers;

use app\models\Doctor;
use app\models\helpers\BehaviorsHelper;
use Yii;
use yii\db\Exception;
use yii\rest\ActiveController;

class DoctorController extends ActiveController
{
    public $modelClass = 'app\models\Doctor';

    public function behaviors()
    {
        return BehaviorsHelper::getBehaviors(parent::behaviors());
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['class'] = 'app\actions\doctor\IndexAction';
        $actions['create']['class'] = 'app\actions\doctor\CreateAction';
        $actions['update']['class'] = 'app\actions\doctor\UpdateAction';
        $actions['delete']['class'] = 'app\actions\doctor\DeleteAction';

        return $actions;
    }

    public function actionGoodTransaction() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $doctor = Doctor::findOne(3);
            $doctor->surname = 'Komarovskiy new';
            $doctor->save();

            $doctor = Doctor::findOne(['surname' => 'Bikov']);
            $doctor->license_number = 100100;
            $doctor->save();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
        return 'Transaction was committed!';
    }

    public function actionBadTransaction() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $doctor = Doctor::findOne(3);
            $doctor->surname = 'Komarovskiy new';
            $doctor->save();

            $doctor = Doctor::findOne(['surname' => 'Bikov']);
            throw new Exception('Error happened.');
            $doctor->save();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return 'Transaction failed!' . ' ' . $e->getMessage();
        }
        return 'Transaction was committed!';
    }
}
