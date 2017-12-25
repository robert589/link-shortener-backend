<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\models\Admin;
class RbacController extends Controller {
    
    public function actionInit() {
        $adminId = Admin::find()->one()['id'];
        
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->assign($admin, $adminId);
    }
    
    
}