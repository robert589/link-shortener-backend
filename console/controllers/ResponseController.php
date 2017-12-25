<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;

class ResponseController extends Controller {
    
    public $name;
    
    public $attrs;
    
    public $moduleName;
    
    public $subpath;
    
    public function options($id) {
        return ['name', 'attrs', "moduleName", "subpath"];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'a' => 'attrs', "m" => "moduleName", "s" => "subpath"];
    }
    
    public function actionCreate()
    {
        if(!$this->moduleName) {
            die("You need to specify the path");
        }
        
        if(!file_exists($this->getDirPath())) {
            mkdir($this->getDirPath(), 0755, true);
        }
        $dirPath = $this->getDirPath() . "/" .$this->name . ".php" ;
        $attributes = explode(",", $this->attrs);
        
        $text = $this->getHeaderText($this->name);
        $text .= $this->generateAttrs($attributes);
        $text .= $this->getFooterText();
        if (file_put_contents($dirPath, $text) !== false) {
        } else {
            echo "Cannot create file";
        }
    }
    
    private function getDirPath() {
        return "common/modules/" . $this->moduleName . "/responses/" . $this->subpath;
    }
    
    private function generateAttrs($attrs) {
        $text = "    //attributes"
                . "\n";
        foreach($attrs as $attr) {
            $text .= "    public $" . $attr  . ";\n\n";
                    
        }
            
        return $text;
        
    }
    
    private function getHeaderText($name) {
        $moduleName = $this->moduleName;
        $subpath = $this->subpath;
        return 
"<?php
namespace common\modules\\$moduleName\\responses\\$subpath;

use rkit\components\RResponse;
/**
 * $name response
 *
 */
class $name extends RResponse
{
 
";
    }
    
    
    private function getFooterText() {
        return "
       
}";
    }
}