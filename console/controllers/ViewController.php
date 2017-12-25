<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
class ViewController extends Controller {
    
    public $basePath;
    
    public $path;
    /**
     *
     * @var string
     * CamelCase
     * z
     */
    public $name;
        
    public function options($id) {
        return ['name', 'path', 'basePath'];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'p' => 'path', 'b' => 'basePath'];
    }
    
    public function actionCreate()
    {
        if(!$this->basePath) {
            die("It is required to have a base path (-b)");
        }
        
        $viewWidget = $this->basePath . "/views/" . $this->path . "/" .  
                $this->fromCamelCase($this->name) . ".php"; 
        $text = "<?php";
        if (file_put_contents($viewWidget, $text) !== false) {
        } else {
            echo "Cannot create view widget";
        }
        
        $jsWidget = $this->basePath . "/web/js/project/" . $this->fromCamelCase($this->name) . ".ts";
        $text = $this->getJsWidgetText($this->name);
        if (file_put_contents($jsWidget, $text) !== false) {
        } else {
            echo "Cannot create TypeScript widget";
        }
        
        $cssWidget = $this->basePath . "/web/css/less/" . $this->fromCamelCase($this->name) . ".less";
        $text = "";
        if (file_put_contents($cssWidget, $text) !== false) {
        } else {
            echo "Cannot create Less widget";
        }
    }
        
    private function fromCamelCase($camelCase) {
        $matches = [];
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $camelCase, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
          $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('-', $ret);
    }
    
    private function getJsWidgetText($name) {
        return 
"import {Component} from '../index';


export class $name extends Component{

    constructor(root: HTMLElement) {
        super(root);
    }
    
    decorate() {
        super.decorate();
        
    }
    
    bindEvent() {
        super.bindEvent();
    }
    
    detach() {
        super.detach();
    }
    
    unbindEvent() {
        // no event to unbind
    }
}
";
    }
    private function getContainerWidget($name) {
        $stipendCase = $this->fromCamelCase($name);
        $base = $this->basePath;
        return 
"<?php

namespace $base\widgets;

use yii\base\Widget;

class $name extends Widget {
    
    public \$id;
    
    public function init() {
        
    }
    
    public function run() {
        return \$this->render('$stipendCase', ['id' => \$this->id]);
    }
}
";
    }
    
    
    private function getFooterText() {
        return "}";
    }
}