<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;

class ControllerController extends Controller {
    
    public $moduleName;
    
    /**
     *
     * @var string
     * CamelCase
     * z
     */
    public $name;
        
    public function options($id) {
        return ['name', "moduleName"];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'm' => 'moduleName'];
    }
    
    public function actionCreate()
    {
        if(!$this->moduleName) {
            die("You need to specify the part");
        }
        $containerWidget = "common/modules/" . $this->moduleName .  "/controllers/" . $this->name . ".php" ;
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
namespace common\modules\\$module\\controllers;

use Yii;
use yii\web\Controller;
/**
 * $name controller
 */
class " . $name . " extends Controller
{
    public \$enableCsrfValidation = false;
    
      
    public static function allowedDomains() {
        return [
             '*',                        // star allows all domains
//            'http://test1.example.com',
//            'http://test2.example.com',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST'],
                    'Access-Control-Request-Headers' => ['Content-Type', 'Authorization'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                ]
            ],
            \\rkit\behaviors\AuthBehavior::className()

        ]);
    }
    
}

";
    }
    
    
}