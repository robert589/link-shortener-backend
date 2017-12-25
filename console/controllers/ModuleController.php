<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\models\AccessControl;


class ModuleController extends Controller {
    
    public $name;
    
    public function options($id) {
        return ['name'];
    }
    
    public function optionAliases() {
        return ['n' => 'name'];
    }
    
    public function actionCreate()
    {
        $dirPath =  $this->getDirPath();
        if(!file_exists($dirPath)) {
            mkdir($dirPath, '0755', true);
        }
        
        mkdir($this->getControllersDirPath(), '0755', true);
        mkdir($this->getConfigDirPath(), '0755', true);
        mkdir($this->getModelsDirPath(), '0755', true);
        mkdir($this->getOrmsDirPath(), '0755', true);
        mkdir($this->getDaosDirPath(), '0755', true);
        mkdir($this->getResponsesDirPath(), '0755', true);
        mkdir($this->getFormsDirPath(), '0755', true);
        mkdir($this->getMigrationsDirPath(), '0755', true);
        mkdir($this->getVosDirPath(), '0755', true);
        $this->createModuleFile();
        $this->createDefaultControllerFile();
        
    }
    
    private function createConfigFile() : void {
        $path = $this->getConfigMainFilePath();
        $text = $this->getConfigMainFileText();
        if (file_put_contents($path, $text) !== false) {
        } else {
            echo "Cannot create file";
        }
        
        return;
    
    }
    
    private function createModuleFile() : void
    {       
        $moduleFilePath = $this->getModuleFilePath();
        $moduleFileText = $this->getModuleFileText();
        if (file_put_contents($moduleFilePath, $moduleFileText) !== false) {
        } else {
            echo "Cannot create file";
        }
        
        return;
    }
    
    private function createDefaultControllerFile() : void {
        
        $defaultControllerFilePath = $this->getDefaultControllerFilePath();
        $defaultControllerFileText = $this->getDefaultControllerFileText();
        if (file_put_contents($defaultControllerFilePath, $defaultControllerFileText) !== false) {
        } else {
            echo "Cannot create file";
        }
        
        return;
    }
    
    private function getDirPath() : string {
        return  "common/modules/" . $this->name;
    }
    
    private function getConfigDirPath() : string {
        return $this->getDirPath() . '/config';
    }
    
    private function getConfigMainFilePath() : string {
        return $this->getConfigDirPath() . '/main.php';
    }
    
    private function getControllersDirPath() : string {
        return $this->getDirPath() . '/controllers';
    }
    
    private function getDefaultControllerFilePath() : string {
        return $this->getControllersDirPath() . '/DefaultController.php';
    }
    
    private function getMigrationsDirPath() : string {
        return $this->getDirPath() . '/migrations';
    }
    
    private function getVosDirPath() : string {
        return $this->getDirPath() . "/vos";
    }
    
    private function getConfigMainFileText() : string {
        return "<?php 
return [
]";
    }
    
    private function getDefaultControllerFileText() : string {
        $name = $this->name;
        return "<?php
namespace common\modules\\$name\controllers;

use Yii;
use yii\web\Controller;
/**
 * Default controller
 */
class DefaultController extends Controller
{
    public \$enableCsrfValidation = false;
    
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'OPTIONS','GET'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse', 'application/json', 'content-type', 'Authorization'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ]

            ],
            \rkit\behaviors\AuthBehavior::className()
        ];
    }
    
    public function init() {
        
    }
    
}

";
    }
    
    private function getModelsDirPath() : string {
        return $this->getDirPath() . '/models';
    }
    
    private function getModuleFilePath() : string {
        return $this->getDirPath() . '/Module.php';
    }
    
    private function getFormsDirPath() : string {
        return $this->getDirPath() . '/forms';
    }
    
    private function getResponsesDirPath() : string {
        return $this->getDirPath() . '/responses';
    }
    
    private function getDaosDirPath() : string {
        return $this->getDirPath() . '/daos';
    }
    
    private function getOrmsDirPath() : string {
        return $this->getDirPath() . '/orms';
    }
    
    private function getModuleFileText() : string {
        $name = $this->name;
        return "<?php
namespace common\modules\\$name;

class Module extends \yii\base\Module
{
    
    public function init()
    {
        parent::init();
        \Yii::configure(\$this, require(__DIR__ . '/config/main.php'));

    }
}";
    }
}