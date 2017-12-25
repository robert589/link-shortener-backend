<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;

class ActiveController extends Controller {
    
    public $name;
    
    public $moduleName;
    
    public function options($actionId) {
        return ['name', 'moduleName'];
    }
    
    public function optionAliases() {
        return ['n' => 'name', 'm' => 'moduleName'];
    }
    
    public function actionCreate()
    {
        $dirPath = "common/modules/" . $this->moduleName . '/orms/' . $this->name . ".php" ;
        $text = $this->getText($this->name);
        if (file_put_contents($dirPath, $text) !== false) {
        } else {
            echo "Cannot create file";
        }
    }
    
    private function getText($name) {
        $underCase=  $this->convertToDb($name);
        $moduleName = $this->moduleName;
        return 
"<?php
namespace common\modules\\$moduleName\orms;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * $name model
 *
 */
class $name extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%$underCase}}';
    }
    
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt'
            ],
        ];
    }


}
";
    }
    
    private function convertToDb($name) {
        $matcher = [];
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $name, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
          $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}