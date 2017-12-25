<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
class VoController extends Controller {
    
    public $name;
    
    public $attrs;
    
    public $moduleName;
    
    public function options($id) {
        return ['name', 'attrs', "moduleName"];
        
    }
    
    public function optionAliases() {
        return ['n' => 'name', "a" => "attrs", "m" => "moduleName"];
    }
    
    public function actionCreate()
    {
        $attributes = explode(",", $this->attrs);
        
        $builderPath = "common/modules/" . $this->moduleName . "/vos/" . $this->name . "Builder.php" ;
        $builderText = $this->getBuilderText($this->name);
        $builderText .= $this->generateAttrs($attributes, true);
        $builderText .= $this->generateRules($attributes);
        $builderText .= $this->generateGetters($attributes);
        $builderText .= $this->generateSetters($attributes);
        $builderText .= $this->getFooterText();
        if (file_put_contents($builderPath, $builderText) !== false) {
        } else {
            echo "Cannot create Builder";
        }
        
        $voPath = "common/modules/" . $this->moduleName . "/vos/" . $this->name . ".php" ;;
        $voText = $this->getVoText($this->name);
        $voText .= $this->generateAttrs($attributes);
        $voText .= $this->getVoConstructor($this->name, $attributes);
        $voText .= $this->generateGetters($attributes);
        $voText .= $this->getFooterText();
        if (file_put_contents($voPath, $voText) !== false) {
        } else {
            echo "Cannot create Vo";
        }
        
    }
    
    public function generateRules($attrs) {
        $text  = "\n\n    public function rules() { \n";
        $text .= "        return [\n";
        foreach($attrs as $attr) {
        $text .= "           ['$attr','string'],\n";
        }
        $text .= "        ];\n";
        $text .= "    }";
        return $text;
    }
    
    private function generateGetters($attrs) {
        $text = "\n"
                . "\n"
                . "    //getters";
        foreach($attrs as $attr) {
            $text .= "\n" . "\n"
                    . "    public function get" . ucfirst($attr) . "() { \n"
                    . "        return \$this->" . $attr . "; \n"
                    . "    }";
        }
        
        return $text;
    }
    
    private function generateSetters($attrs) {
        $text = "\n"
                . "\n"
                . "    //setters";
        foreach($attrs as $attr) {
            $text .= "\n" . 
                     "\n" .
                     "    public function set" . ucfirst($attr) . "(\$$attr) { \n"
                    . "        \$this->" . $attr . " = \$$attr; \n"
                    . "    }";
        }
        
        return $text;
    }
    
    private function generateAttrs($attrs, $public = false) {
        $text = "    //attributes";
        $isPublic = ($public) ? "public" : "private";
        foreach($attrs as $attr) {
            $text .= "\n"
                    . "\n"
                    . "    $isPublic $" . $attr  . ';'; 
        }
            
        return $text;
        
    }
    
    private function getBuilderText($name) {
        $moduleName = $this->moduleName;
        return 
"<?php
namespace common\modules\\$moduleName\\vos;

use yii\db\ActiveRecord;
use rkit\components\RVoBuilder;
/**
 * $name builder
 *
 */
class " .$name . "Builder extends RVoBuilder
{
    function build() { return new " . $name . "(\$this);  }
";    
    }
    
    private function getVoText($name) {
        $moduleName = $this->moduleName;
        return 
        
"<?php
namespace common\modules\\$moduleName\\vos;

use yii\db\ActiveRecord;
use rkit\components\RVo2;
/**
 * $name vo
 *
 */
class $name extends RVo2
{
    public static function createBuilder() { return new $name" . "Builder();} 
";
    }
    
    private function getVoConstructor($name, $attrs) {
        $text = "\n\n    public function __construct($name" . "Builder \$builder) { \n";
        foreach($attrs as $attr) {
            $text .= "        \$this->$attr = \$builder->get" . ucfirst($attr) . "(); \n";
        }
        $text .= "    }";
        return $text;
    }
    
    
    private function getFooterText() {
        return "\n"
        . "}";
    }
    private function convertToDb($name) {
        $matcher = [];
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $name, $matches);
        $ret = $matches[0];
        foreach (   $ret as &$match) {
          $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}