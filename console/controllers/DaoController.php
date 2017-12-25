<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
class DaoController extends Controller {
  
    public $name;
    
    public $moduleName;
        
    public function options($id) {
        return ['name',  "moduleName"];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'm' => 'moduleName'];
    }
    
    public function actionCreate()
    {
        $containerWidget = "common/modules/" . $this->moduleName .  "/daos/" . $this->name . ".php" ;
        $text = $this->getText($this->name);
        if (file_put_contents($containerWidget, $text) !== false) {
        } else {
            echo "Cannot create container widget";
        }
    }
    
    private function getText($name) {
        $module = $this->moduleName;
        return 
"<?php
namespace common\modules\\$module\\daos;

use Yii;
use rkit\components\Dao;
/**
 * $name class
 */
class " . $name . " implements Dao
{
    
}

";
    }
    
    
}