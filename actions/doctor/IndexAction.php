<?php


namespace app\actions\doctor;

use Yii;

class IndexAction extends \yii\rest\IndexAction
{
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        return Yii::$app->db->createCommand('exec getDoctors')->queryAll();
    }

}
