<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
class WidgetController extends Controller {
    
    public $path;
    
    public $type = "project";
    /**
     *
     * @var string
     * CamelCase
     * z
     */
    public $name;
        
    public function options($id) {
        return ['name', 'path', 'type'];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'p' => 'path', 't' => 'type'];
    }
    
    public function actionCreate()
    {
        if(!$this->path) {
            die("Path should be specified");
        }
        $containerWidget = $this->path . "/widgets/" . $this->name . ".php" ;   
        $viewWidget = $this->path . "/widgets/views/" . $this->fromCamelCase($this->name) . ".php"; 

        if($this->type === "rkit") {
            $jsWidget = $this->path . "/js/project/" . $this->fromCamelCase($this->name) . ".ts";
            $cssWidget = $this->path . "/css/less/" . $this->fromCamelCase($this->name) . ".less";
        } else {
            $jsWidget = $this->path . "/web/js/project/" . $this->fromCamelCase($this->name) . ".ts";
            $cssWidget = $this->path . "/web/css/less/" . $this->fromCamelCase($this->name) . ".less";
        }
        $text = $this->getContainerWidget($this->name);
        if (file_put_contents($containerWidget, $text) !== false) {
        } else {
            echo "Cannot create container widget";
        }
        $text = $this->getViewWidget();
        if (file_put_contents($viewWidget, $text) !== false) {
        } else {
            echo "Cannot create view widget";
        }
        
        $text = $this->getJsWidgetText($this->name);
        if (file_put_contents($jsWidget, $text) !== false) {
        } else {
            echo "Cannot create TypeScript widget";
        }
        
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
    
    private function getViewWidget() {
        return "<?php";
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
        $path = $this->path;
        return 
"<?php

namespace $path\widgets;

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