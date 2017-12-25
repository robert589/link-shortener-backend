<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
class ModelController extends Controller {
    
    public $name;
    
    public $attrs;
    
    public $path;
    
    public function options($id) {
        return ['name', 'attrs', "path"];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'a' => 'attrs', "p" => "path"];
    }
    
    public function actionCreate()
    {
        if(!$this->path) {
            die("Path is required");
        }
        $dirPath =  $this->path . "/models/" . $this->name . ".php" ;
        $attributes = explode(",", $this->attrs);
        
        $text = $this->getHeaderText($this->name);
        $text .= $this->generateAttrs($attributes);
        $text .= $this->getFooterText();
        if (file_put_contents($dirPath, $text) !== false) {
        } else {
            echo "Cannot create file";
        }
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
        $path = $this->path;
        return 
"<?php
namespace $path\models;

use rkit\components\RModel;
/**
 * $name model
 *
 */
class $name extends RModel
{

";
    }
    
    
    private function getFooterText() {
        return "}";
    }
}