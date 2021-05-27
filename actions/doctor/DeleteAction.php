<?php


namespace app\actions\doctor;


use Yii;

class DeleteAction extends \yii\rest\DeleteAction
{
    public function run($id)
    {
        Yii::$app->db->createCommand("EXEC deleteDoctor :id", [
            ':id' => $id
        ])->execute();

        Yii::$app->getResponse()->setStatusCode(204);
    }

}
